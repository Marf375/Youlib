import React, { Component } from 'react';
import axios from 'axios';
import ReactDOM from 'react-dom/client';

class Reviews extends Component {
    constructor(props) {
        super(props);
        this.state = {
            reviews: [],
            userName: '',
            content: '',
            rating: 0,
            successMessage: '',
            errorMessage: '',
            currentPage: 1,
            totalPages: 1,
            userId: null,
            bookId: null,
            isLoading: true
        };
    }

    componentDidMount() {
        this.getBookId()
            .then(bookId => {
                if (!bookId) {
                    throw new Error('Не удалось определить ID книги');
                }
                this.setState({ bookId, isLoading: false }, () => {
                    this.fetchUserData();
                    this.fetchReviews();
                });
            })
            .catch(error => {
                console.error('Ошибка инициализации:', error);
                this.setState({
                    errorMessage: 'Ошибка загрузки отзывов. Проверьте URL страницы.',
                    isLoading: false
                });
            });
    }
    // Получаем ID книги из параметра hash URL
    getBookId = () => {
        return new Promise((resolve) => {
            // 1. Проверяем props
            if (this.props.bookId) return resolve(this.props.bookId);
            // 2. Проверяем data-атрибут
            const container = document.getElementById('book-reviews');
            if (container?.dataset?.bookId) return resolve(container.dataset.bookId);
            // 3. Проверяем глобальную переменную
            if (window.bookId) return resolve(window.bookId);
            // 4. Извлекаем из URL (формат: /book_a?hash=1)
            const urlParams = new URLSearchParams(window.location.search);
            const bookId = urlParams.get('hash');
            resolve(bookId || null);
        });
    };

    fetchUserData = async () => {
        try {
            const [userResponse, userIdResponse] = await Promise.all([
                axios.get('/user'),
                axios.get('/userid')
            ]);

            this.setState({
                userName: userResponse.data.name,
                userId: userIdResponse.data.user_id
            });
        } catch (error) {
            console.error('Ошибка загрузки данных пользователя:', error);
            this.setState({ 
                errorMessage: 'Ошибка загрузки данных пользователя' 
            });
        }
    };

    fetchReviews = async (page = 1) => {
        const { bookId } = this.state;
        try {
            const response = await axios.get(`/reviews/book/${bookId}?page=${page}`);
            this.setState({
                reviews: response.data.data,
                currentPage: response.data.current_page,
                totalPages: response.data.last_page,
                errorMessage: ''
            });
        } catch (error) {
            console.error('Ошибка загрузки отзывов:', error);
            let errorMessage = 'Ошибка при загрузке отзывов';
            
            if (error.response) {
                // Добавляем детали из ответа сервера
                errorMessage = error.response.data.message || errorMessage;
            }
            
            this.setState({ 
                errorMessage,
                reviews: [],
                currentPage: 1,
                totalPages: 1
            });
        }
    };

    handleSubmit = async (e) => {
        e.preventDefault();
        const { content, rating, userId, bookId } = this.state;

        if (!content || !rating) {
            this.setState({ errorMessage: 'Заполните все обязательные поля' });
            return;
        }
        try {
            await axios.post('/reviews', {
                user_id: userId,
                book_id: bookId,
                content,
                rating: Number(rating)
            });

            this.setState({
                content: '',
                rating: 0,
                successMessage: 'Отзыв успешно добавлен!',
                errorMessage: ''
            });

            this.fetchReviews();
        } catch (error) {
            console.error('Ошибка отправки отзыва:', error);
            this.setState({ 
                errorMessage: error.response?.data?.message || 'Ошибка при отправке отзыва' 
            });
        }
    };

    render() {
        const { 
            reviews, 
            userName, 
            content, 
            rating, 
            successMessage, 
            errorMessage, 
            currentPage, 
            totalPages,
            isLoading,
            bookId
        } = this.state;

        if (isLoading) {
            return <div className="loading">Загрузка...</div>;
        }

        if (!bookId) {
            return (
                <div className="error">
                    <h2>Ошибка</h2>
                    <p>Не удалось определить книгу для отзывов.</p>
                    <p>Проверьте, что URL содержит параметр hash (например: ?hash=1)</p>
                </div>
            );
        }

        return (
            <div className="book-reviews-container">
                <h2>Отзывы о книге</h2>
                
                {successMessage && (
                    <div className="alert success">{successMessage}</div>
                )}
                
                {errorMessage && (
                    <div className="alert error">{errorMessage}</div>
                )}
                
                <form onSubmit={this.handleSubmit} className="review-form">
                    <div className="form-group">
                        <input
                            type="text"
                            value={userName}
                            readOnly
                            className="form-input bg-black text-white rounded-[10px] w-[10dvw]"
                        />
                    </div>
                    
                    <div className="form-group">
                        <textarea
                            name="content"
                            value={content}
                            onChange={(e) => this.setState({ content: e.target.value })}
                            required
                            className="form-textarea rounded-[10px] bg-black text-white h-[100px] w-[10dvw]"
                            placeholder="Ваш отзыв" 
                        />
                    </div>
                    <div>
                    <label htmlFor="rating">
                                        <div className="stars">
                                            {[5, 4, 3, 2, 1].map((star) => (
                                                <React.Fragment key={star}>
                                                    <input type="radio" name="rating" value={star} id={`star${star}`}  onChange={(e) => this.setState({ rating: star })}
                                                required></input>
                                                <label htmlFor={`star${star}`} 
                                                className={`star ${this.state.rating >= star ? 'active' : ''}`}>
                                                    &#9733;
                                                </label>
                                                
                                                </React.Fragment>
                                            ))}
                                        </div>
                                        </label>
                    </div>
                    
                    <button type="submit" className="submit-button bg-transparent border-[1px] border-solid border-[#9370db] text-[#9370db] w-[10dvw] h-[4dvh] rounded-[10px] hover:bg-[#9370db] hover:text-white">
                        Отправить отзыв
                    </button>
                </form>
                
                <div className="review-align ]">
                    <h3>Последние отзывы</h3>
                    
                    {reviews.length === 0 ? (
                        <p>Пока нет отзывов. Будьте первым!</p>
                    ) : (
                        reviews.map((review) => (
                            <div key={review.id} className="review text-[1.5rem] my-[3dvh]">
                                <div className="review-header flex justify-between mx-[5dvw]">
                                    <strong className="review-author">
                                        {review.user?.name || 'Анонимный пользователь'}
                                    </strong>
                                    <div>
                                {[...Array(5)].map((_, i) => (
                                    <span key={i} className={`star ${i < review.rating ? 'filled' : ''}`}>&#9733;</span>
                                ))}
                                </div>
                                </div>
                                <p className="review-content ml-[10px]">{review.content}</p>
                                <p className="review-date ml-[10px]">
                                добавлено:
                                    {new Date(review.created_at).toLocaleDateString('ru-RU')}
                                </p>
                            </div>
                        ))
                    )}
                </div>
                
                {totalPages > 1 && (
                    <div className="pagination">
                        {Array.from({ length: totalPages }, (_, i) => i + 1).map(page => (
                            <button
                                key={page}
                                onClick={() => this.fetchReviews(page)}
                                className={` text-white currentPage === page ? 'active' : ''`}
                            >
                                {page}
                            </button>
                        ))}
                    </div>
                )}
            </div>
        );
    }
}

const a= ReactDOM.createRoot(document.getElementById('reviews'))
a.render(<Reviews />)
