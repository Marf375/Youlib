import React from "react";
import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import axios from "axios";

class Cen extends React.Component {
    render() {
        const { cartItems, isAuthenticated, userLibrary, books } = this.props;
        const routeProps = {
            addToCart: this.props.addToCart,
            removeFromCart: this.props.removeFromCart,
            cartItems,
            userLibrary,
            isAuthenticated,
            books,
        };
console.log(books,"books in cen")
        return (
            <Router>
                <div>
                    <div className="anv">
                        <p className="nv"><Link to={isAuthenticated ? "/dashboard/" : "/"}>Главная</Link></p>
                        <p className="nv"><Link to={isAuthenticated ? "/dashboard/comics" : "/comics"}>Комиксы</Link></p>
                        <p className="nv"><Link to={isAuthenticated ? "/dashboard/books" : "/books"}>Книги</Link></p>
                        <p className="nv"><Link to={isAuthenticated ? "/dashboard/audio" : "/audio"}>Аудиокниги</Link></p>
                    </div>

                    <Routes>
                        <Route path="/" element={<Main {...routeProps} />} />
                        <Route path="/dashboard/" element={<Main {...routeProps} />} />
                        <Route path="/comics" element={<Comics {...routeProps} />} />
                        <Route path="/dashboard/comics" element={<Comics {...routeProps} />} />
                        <Route path="/books" element={<Books {...routeProps} />} />
                        <Route path="/dashboard/books" element={<Books {...routeProps} />} />
                        <Route path="/audio" element={<div><h1 className='text-[2rem] text-center'>Здесь пока ничего нет, мы работаем над этим</h1></div>} />
                        <Route path="/dashboard/audio" element={<div><h1 className='text-[2rem] text-center'>Здесь пока ничего нет, мы работаем над этим</h1></div>} />
                    </Routes>
                </div>
            </Router>
        );
    }
}


class Main extends React.Component {
    render() {
        const { books, isAuthenticated, userLibrary, addToCart, removeFromCart, cartItems } = this.props;
        console.log(books,"books in main")
        return (
            <div>
                <h1 className="text-[2rem] text-[#9370DB] mx-[5dvw]">Рекомендуемые</h1>
                <Rec books={books} isAuthenticated={isAuthenticated} userLibrary={userLibrary}
                     addToCart={addToCart} removeFromCart={removeFromCart} cartItems={cartItems} />
                <div className="w-[100dvw] h-[50px] it my-[5dvh]" />
                <h1 className="text-[2rem] text-[#9370DB] my-[10px] mx-[5dvw]">Интересный факт</h1>
                <div className="tsp mt-[3dvh] w-[50dvw] h-[30dvh] justify-self-center">
                    <p className="fp">Интересный факт: Самая большая библиотека в мире — Библиотека Конгресса США. В её коллекции более 170 миллионов единиц хранения, а длина книжных полок превышает 1 300 километров!</p>
                </div>
                <div className="w-[100dvw] h-[20dvh]" />
            </div>
        );
    }
}

// Карусель книг
class Rec extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            activeIndex: 0,
        };
    }

    prevSlide = () => {
        const { books } = this.props;
        const chunkCount = this.getChunkCount(books);
        this.setState((prev) => ({
            activeIndex: prev.activeIndex > 0 ? prev.activeIndex - 1 : chunkCount - 1,
        }));
    };

    nextSlide = () => {
        const { books } = this.props;
        const chunkCount = this.getChunkCount(books);
        this.setState((prev) => ({
            activeIndex: prev.activeIndex < chunkCount - 1 ? prev.activeIndex + 1 : 0,
        }));
    };

    getChunkCount = (books) => {
        const step = this.getStep();
        return Math.ceil(books.length / step);
    };

    getStep = () => {
        const width = window.innerWidth;
        if (width < 400) return 1;
        if (width < 1400) return 2;
        return 4;
    };

    chunkBooks = (books) => {
        const step = this.getStep();
        const chunks = [];
        for (let i = 0; i < books.length; i += step) {
            chunks.push(books.slice(i, i + step));
        }
        return chunks;
    };

    render() {
        const { books, isAuthenticated, userLibrary, addToCart, removeFromCart, cartItems } = this.props;
        const { activeIndex } = this.state;
        const bookChunks = this.chunkBooks(books);
        console.log("Books data:", books);
        return (
            <div className="carousel-container w-[90dvw] h-[50dvh] relative">
                <div className="carousel h-[50dvh]">
                    {bookChunks.map((chunk, index) => (
                        <div key={index} className={index === activeIndex ? "active" : "hidden"}>
                            <div className="flex flex-wrap justify-center h-[50dvh] gap-[3dvw]">
                                {chunk.map((book) =>
                                    isAuthenticated ? (
                                        <Card_a key={book.id} book={book} userLibrary={userLibrary}
                                                addToCart={addToCart} removeFromCart={removeFromCart}
                                                cartItems={cartItems} />
                                    ) : (
                                        <Card key={book.id} book={book} />
                                    )
                                )}
                            </div>
                        </div>
                    ))}
                </div>

                {bookChunks.length > 1 && (
                    <>
                        <button className="carousel-control-prev mr-[500px]" onClick={this.prevSlide}>←</button>
                        <button className="carousel-control-next" onClick={this.nextSlide}>→</button>
                    </>
                )}
            </div>
        );
    }
}

// Карточка для авторизованного
class Card_a extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            inCart: false,
            isInLibrary: false,
        };
    }

    componentDidMount() {
        this.checkStates();
    }

    componentDidUpdate(prevProps) {
        if (prevProps.cartItems !== this.props.cartItems ||
            prevProps.userLibrary !== this.props.userLibrary ||
            prevProps.book !== this.props.book) {
            this.checkStates();
        }
    }

    checkStates = () => {
        const { book, cartItems, userLibrary } = this.props;
        const inCart = cartItems.some(item => item.id === book.id);
        const inLibrary = userLibrary.library?.some(libBook =>
            libBook.book_name?.trim().toLowerCase() === book.name?.trim().toLowerCase() ||
            libBook.id === book.id
        );
        this.setState({ inCart, isInLibrary: inLibrary });
    };

    render() {
        const { book, addToCart, removeFromCart } = this.props;
        const { inCart, isInLibrary } = this.state;
        return (
            <div className="mt-5 card card_a border-none bg-transparent h-[50dvh]">
                <div className="product-card h-[50dvh]">
                    <a href={`/book_a#${book.id}`}>
                        <img src={book.img} alt="Товар" className="product-image" />
                        <div className="product-info">
                            <h5>{book.file}</h5>
                            <h5 className="bn">{book.name}</h5>
                            <h5>{book.copyright_holder}</h5>
                        </div>
                    </a>
                </div>
                {isInLibrary ? (
                    <p className="bp text-white">Книга у вас в библиотеке</p>
                ) : (
                    <div>
                        <div className="flex">
                            <p className="bp text-[18px] my-[10px] mx-[20px] price text-[#9370DB]">{book.price}</p>
                            <p className="mx-[5px] my-[10px] text-[#9370DB]">Руб.</p>
                        </div>
                        {inCart ? (
                            <button className="ats bg-gray-600 border border-[#9370DB] text-[#9370DB] rounded-[10px] h-[50px]"
                                    onClick={() => removeFromCart(book.id)}>
                                В корзине (удалить)
                            </button>
                        ) : (
                            <button className="ats bg-purple-600 border border-[#9370db] text-[#9370DB] rounded-[10px] h-[50px]"
                                    onClick={() => addToCart(book)}>
                                Добавить в корзину
                            </button>
                        )}
                    </div>
                )}
            </div>
        );
    }
}

// Карточка для неавторизованного
class Card extends React.Component {
    componentDidMount() {
        this.checkStates();
    }
    componentDidUpdate(prevProps) {
        if (prevProps.book !== this.props.book) {
            this.checkStates();
        }
    }

    checkStates = () => {
        const { book } = this.props;
    };
    render() {
        const { book } = this.props;
        return (
            <div className="mt-5 h-[35dvh] prs">
                <div className="product-card">
                    <a href={`/book#${book.id}`}>
                        <img src={book.img} alt="Товар" className="product-image" />
                        <div className="product-info">
                            <h5 className="mt-[20%]">{book.name}</h5>
                            <p>{book.copyright_holder}</p>
                        </div>
                    </a>
                </div>
                <p className="text-[#9370DB] text-[18px]">{book.price} руб.</p>
            </div>
        );
    }
}

class Books extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            genres: [],
            selectedGenres: [],
            showFilters: false,
        };
    }

    componentDidMount() {
        this.fetchGenres();
    }

    fetchGenres = async () => {
        try {
            const response = await axios.get("/genres");
            this.setState({ genres: response.data });
        } catch (error) {
            console.error("Ошибка при загрузке жанров:", error);
        }
    };

    handleGenreChange = (genreId) => {
        this.setState(prevState => ({
            selectedGenres: prevState.selectedGenres.includes(genreId)
                ? prevState.selectedGenres.filter(id => id !== genreId)
                : [...prevState.selectedGenres, genreId]
        }));
    };

    filterBooksByGenre = (books) => {
        const { selectedGenres } = this.state;
        if (selectedGenres.length === 0) return books;
        return books.filter(book =>
            book.genres && book.genres.some(genre => selectedGenres.includes(genre.id))
        );
    };

    toggleFilters = () => {
        this.setState(prev => ({ showFilters: !prev.showFilters }));
    };

    resetFilters = () => {
        this.setState({ selectedGenres: [], showFilters: false });
    };

    getComicsBooks = () => {
        const { books } = this.props;
        const filtered = this.filterBooksByGenre(books);
        return filtered.filter(book => book.type === "books");
    };

    render() {
        const { isAuthenticated, userLibrary, addToCart, removeFromCart, cartItems } = this.props;
        const { genres, selectedGenres, showFilters } = this.state;
        const comicsBooks = this.getComicsBooks();

        return (
            <div className="container mx-auto p-6">
                <button
                    onClick={this.toggleFilters}
                    className="mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    {showFilters ? 'Скрыть фильтры' : 'Фильтр'}
                </button>

                {showFilters && (
                    <div className="mb-6 p-4 bg-gray-100 rounded-lg">
                        <h1 className="text-xl font-bold mb-3">Жанры</h1>
                        <form>
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
                                {genres.map(genre => (
                                    <div key={genre.id} className="flex items-center">
                                        <input
                                            type="checkbox"
                                            id={`genre-${genre.id}`}
                                            checked={selectedGenres.includes(genre.id)}
                                            onChange={() => this.handleGenreChange(genre.id)}
                                            className="mr-2"
                                        />
                                        <label htmlFor={`genre-${genre.id}`}>{genre.name}</label>
                                    </div>
                                ))}
                            </div>
                            <div className="flex space-x-3">
                                <button type="button" onClick={this.resetFilters}
                                        className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                    Сбросить
                                </button>
                                <button type="button" onClick={this.toggleFilters}
                                        className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Применить
                                </button>
                            </div>
                        </form>
                    </div>
                )}

                <h2 className="text-2xl font-bold mb-4">Книги</h2>
                {selectedGenres.length > 0 && (
                    <p className="mb-3 text-sm text-gray-600">
                        Выбрано жанров: {selectedGenres.length}
                    </p>
                )}

                <div className="cs1">
                    {comicsBooks.length > 0 ? (
                        comicsBooks.map(book => isAuthenticated ? (
                            <Card_a
                                key={book.id}
                                book={book}
                                userLibrary={userLibrary}
                                addToCart={addToCart}
                                removeFromCart={removeFromCart}
                                cartItems={cartItems}
                            />
                        ) : (
                            <Card key={book.id} book={book} />
                        ))
                    ) : (
                        <p className="text-gray-500 col-span-full">
                            {selectedGenres.length > 0
                                ? "Нет книг, соответствующих выбранным фильтрам"
                                : "Нет доступных книг"}
                        </p>
                    )}
                </div>
            </div>
        );
    }
}

class Comics extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            genres: [],
            selectedGenres: [],
            showFilters: false,
        };
    }

    componentDidMount() {
        this.fetchGenres();
    }

    fetchGenres = async () => {
        try {
            const response = await axios.get("/genres");
            this.setState({ genres: response.data });
        } catch (error) {
            console.error("Ошибка при загрузке жанров:", error);
        }
    };

    handleGenreChange = (genreId) => {
        this.setState(prevState => ({
            selectedGenres: prevState.selectedGenres.includes(genreId)
                ? prevState.selectedGenres.filter(id => id !== genreId)
                : [...prevState.selectedGenres, genreId]
        }));
    };

    filterBooksByGenre = (books) => {
        const { selectedGenres } = this.state;
        if (selectedGenres.length === 0) return books;
        return books.filter(book =>
            book.genres && book.genres.some(genre => selectedGenres.includes(genre.id))
        );
    };

    toggleFilters = () => {
        this.setState(prev => ({ showFilters: !prev.showFilters }));
    };

    resetFilters = () => {
        this.setState({ selectedGenres: [], showFilters: false });
    };

    getComicsBooks = () => {
        const { books } = this.props;
        const filtered = this.filterBooksByGenre(books);
        return filtered.filter(book => book.type === "comics");
    };

    render() {
        const { isAuthenticated, userLibrary, addToCart, removeFromCart, cartItems } = this.props;
        const { genres, selectedGenres, showFilters } = this.state;
        const comicsBooks = this.getComicsBooks();

        return (
            <div className="container mx-auto p-6">
                <button
                    onClick={this.toggleFilters}
                    className="mb-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    {showFilters ? 'Скрыть фильтры' : 'Фильтр'}
                </button>

                {showFilters && (
                    <div className="mb-6 p-4 bg-gray-100 rounded-lg">
                        <h1 className="text-xl font-bold mb-3">Жанры</h1>
                        <form>
                            <div className="grid grid-cols-2 md:grid-cols-4 gap-2 mb-4">
                                {genres.map(genre => (
                                    <div key={genre.id} className="flex items-center">
                                        <input
                                            type="checkbox"
                                            id={`genre-${genre.id}`}
                                            checked={selectedGenres.includes(genre.id)}
                                            onChange={() => this.handleGenreChange(genre.id)}
                                            className="mr-2"
                                        />
                                        <label htmlFor={`genre-${genre.id}`}>{genre.name}</label>
                                    </div>
                                ))}
                            </div>
                            <div className="flex space-x-3">
                                <button type="button" onClick={this.resetFilters}
                                        className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                                    Сбросить
                                </button>
                                <button type="button" onClick={this.toggleFilters}
                                        className="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Применить
                                </button>
                            </div>
                        </form>
                    </div>
                )}

                <h2 className="text-2xl font-bold mb-4">Комиксы</h2>
                {selectedGenres.length > 0 && (
                    <p className="mb-3 text-sm text-gray-600">
                        Выбрано жанров: {selectedGenres.length}
                    </p>
                )}

                <div className="cs1">
                    {comicsBooks.length > 0 ? (
                        comicsBooks.map(book => isAuthenticated ? (
                            <Card_a
                                key={book.id}
                                book={book}
                                userLibrary={userLibrary}
                                addToCart={addToCart}
                                removeFromCart={removeFromCart}
                                cartItems={cartItems}
                            />
                        ) : (
                            <Card key={book.id} book={book} />
                        ))
                    ) : (
                        <p className="text-gray-500 col-span-full">
                            {selectedGenres.length > 0
                                ? "Нет книг, соответствующих выбранным фильтрам"
                                : "Нет доступных книг"}
                        </p>
                    )}
                </div>
            </div>
        );
    }
}

export default Cen;
