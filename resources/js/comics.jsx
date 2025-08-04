import React from "react";
import Card_a from './components/card_a';
import Card from "./components/card";
import axios from "axios";

class Comics extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      books: [],
      userLibrary: [],
      isAuthenticated: false,
      cartItems: [],
      genres: [],
      selectedGenres: [], // Добавляем состояние для выбранных жанров
      showFilters: false // Состояние для отображения/скрытия фильтров
    };
  }

  componentDidMount() {
      this.fetchBooks();
    this.fetchUserLibrary();
    this.checkAuthentication();
    this.fetchGenres();
  }
    fetchBooks = async () => {
        try {
            const response = await axios.get("/books");
            this.setState({ books: response.data });
        } catch (error) {
            console.error("Ошибка при загрузке книг:", error);
        }
    };

  fetchGenres = async () => {
    try {
      const response = await axios.get("/genres");
      this.setState({ genres: response.data });
    } catch (error) {
      console.error("Ошибка при загрузке жанров:", error);
    }
  };

  fetchUserLibrary = async () => {
    try {
      const response = await axios.get("/user-library");
      this.setState({ userLibrary: response.data });
    } catch (error) {
      console.error("Ошибка при загрузке библиотеки пользователя:", error);
    }
  };

  checkAuthentication = async () => {
    try {
      const response = await axios.get("/user-status");
      this.setState({ isAuthenticated: response.data.isAuthenticated });
    } catch (error) {
      console.error("Ошибка при проверке аутентификации:", error);
    }
  };

  // Обработчик изменения состояния чекбоксов
  handleGenreChange = (genreId) => {
    this.setState(prevState => {
      if (prevState.selectedGenres.includes(genreId)) {
        return {
          selectedGenres: prevState.selectedGenres.filter(id => id !== genreId)
        };
      } else {
        return {
          selectedGenres: [...prevState.selectedGenres, genreId]
        };
      }
    });
  };

  // Функция для фильтрации книг по выбранным жанрам
  filterBooksByGenre = (books) => {
    const { selectedGenres } = this.state;

    if (selectedGenres.length === 0) {
      return books; // Если жанры не выбраны, возвращаем все книги
    }

    return books.filter(book =>
      book.genres && book.genres.some(genre => selectedGenres.includes(genre.id))
    );
  };

  // Функция для переключения видимости фильтров
  toggleFilters = () => {
    this.setState(prevState => ({
      showFilters: !prevState.showFilters
    }));
  };

  // Функция для сброса фильтров
  resetFilters = () => {
    this.setState({
      selectedGenres: [],
      showFilters: false
    });
  };

  getComicsBooks = () => {
    const filteredBooks = this.filterBooksByGenre(this.state.books);
    return filteredBooks.filter(book => book.type === "comics");
  };

  render() {
    const { isAuthenticated, userLibrary, genres, selectedGenres, showFilters,} = this.state;
    const { addToCart, removeFromCart, cartItems } = this.props;
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
                      type="checkbox"id={genre-`${genre.id}`}
                      checked={selectedGenres.includes(genre.id)}
                      onChange={() => this.handleGenreChange(genre.id)}
                      className="mr-2"
                    />
                    <label htmlFor={genre-`${genre.id}`}>{genre.name}</label>
                  </div>
                ))}
              </div>
              <div className="flex space-x-3">
                <button
                  type="button"
                  onClick={this.resetFilters}
                  className="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                >
                  Сбросить
                </button>
                <button
                  type="button"
                  onClick={this.toggleFilters}
                  className="px-4 py-2 bg-[green] text-white rounded hover:bg-green-600"
                >
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
                key={`${book.id}`}
                book={book}
                userLibrary={userLibrary}
                addToCart={addToCart}
                removeFromCart={removeFromCart}
                cartItems={cartItems}
              />
            ) : (
              <Card key={`${book.id}`} book={book} />
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

export default Comics;
