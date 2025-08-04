import axios from "axios";
import React from "react";
import Card_a from "./card_a";
import Card from "./card";

class Love extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      activeIndex: 0,
      books: [],
      userLibrary: [],
      isAuthenticated: false,
      cartItems:[],
      genres:[],
      vibrangenre:[],
    };
  }

  componentDidMount() {
    this.fetchBooks();
    this.fetchUserLibrary();
    this.checkAuthentication();
    this.fetchgenres();
  }
  prevSlide = () => {
    if(window.innerWidth<1400 && window.innerWidth>400) {
      this.setState((prevState) => ({
        activeIndex: prevState.activeIndex > 0
          ? prevState.activeIndex - 1
          : Math.floor(this.filterBooksByDate(books).length / 2) - 1
      }));
    }else if(window.innerWidth<400){
      this.setState((prevState) => ({
        activeIndex: prevState.activeIndex > 0
          ? prevState.activeIndex - 1
          : Math.floor(this.filterBooksByDate(books).length / 1) - 1
      }));
    }
    else{
      this.setState((prevState) => ({
        activeIndex: prevState.activeIndex > 0
          ? prevState.activeIndex - 1
          : Math.floor(this.filterBooksByDate(books).length / 4) - 1
      }));
    }
  };

  nextSlide = () => {
    if(window.innerWidth<1400 && window.innerWidth>400){
      this.setState((prevState) => ({
        activeIndex: prevState.activeIndex < Math.floor(this.filterBooksByDate(books).length / 2) -0
          ? prevState.activeIndex + 1
          : 0
      }));
    }
    else if(window.innerWidth<400){
      this.setState((prevState) => ({
        activeIndex: prevState.activeIndex < Math.floor(this.filterBooksByDate(books).length / 1) -0
          ? prevState.activeIndex + 1
          : 0
      }));
    }
    else{
      this.setState((prevState) => ({
        activeIndex: prevState.activeIndex < Math.floor(this.filterBooksByDate(books).length / 4) -0
          ? prevState.activeIndex + 1
          : 0
      }));
    }

  };
  fetchBooks = async () => {
    try {
      const response = await axios.get("/books");
      this.setState({ books: response.data });
    } catch (error) {
      console.error("Ошибка при загрузке книг:", error);
    }
  };
  fetchgenres = async () => {
    try {
      const response = await axios.get("/genres");
      this.setState({ genres: response.data });

     const ran=Math.floor(Math.random()*response.data.length)
     console.log("genres:",ran);
      console.log("genres:",response.data);
      this.setState(()=>({vibrangenre:response.data[ran]}))

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

  getLoveBooks = (books) => {
    const a=this.state.vibrangenre.name
  console.log(a)
    return books.filter(book =>
      book.genres.some(genre => genre.name === a)

    );
  };
  render() {
    const { books, isAuthenticated, userLibrary,activeIndex,vibrangenre  } = this.state;
    const { addToCart, removeFromCart, cartItems } = this.props;
    const filteredBooks = this.getLoveBooks(books);
    const bookChunks = [];

if(window.innerWidth<1400 && window.innerWidth>400){
  for (let i = 0; i < filteredBooks.length; i += 2) {
    bookChunks.push(filteredBooks.slice(i, i + 2));
  }
}else if(window.innerWidth<400){
  for (let i = 0; i < filteredBooks.length; i += 1) {
    bookChunks.push(filteredBooks.slice(i, i + 1));
  }
}
else{
  for (let i = 0; i < filteredBooks.length; i += 4) {
    bookChunks.push(filteredBooks.slice(i, i + 4));
  }
}


    return (
      <div className="">
     <h1 className="text-[2rem] text-[#9370DB] mx-[5dvw]">Случайный Жанр, Вам попался:{this.state.vibrangenre.name}</h1>
     {(filteredBooks==0)? (<div><h1 className="text-[2rem] text-center text-[#9370DB] ">Нет доступных книг</h1></div>):(<div> <div className="carousel-container w-[90dvw] max-h-[30dvh] relative">
       <div className="carousel w-[90dvw] max-h-[30dvh]">
         {bookChunks.map((chunk, index) => (
           <div
             key={index}
             className={`carousel-item ${
               index === activeIndex ? "active" : "hidden"
             }`}
           >
            <div className="flex flex-wrap justify-center h-[30dvh] gap-[3dvw]">
              {chunk.map((book) =>
                isAuthenticated ? (
                 <Card_a
               key={`${book.id}-${index}`}
               book={book}
               userLibrary={userLibrary}
               addToCart={addToCart}
               removeFromCart={removeFromCart}
               cartItems={cartItems}
             />
                ) : (
                 <Card key={`${book.id}-${index}`} book={book} />
                )
              )}
            </div>
          </div>
        ))}
      </div>

      {bookChunks.length > 1 && (
        <>
          <button
            className="carousel-control-prev mr-[500px] "
            onClick={this.prevSlide}
          >
            <span className="carousel-control-prev-icon" aria-hidden="true"></span>
            <span className="visually-hidden">Previous</span>
          </button>
          <button className="carousel-control-next" onClick={this.nextSlide}>
            <span className="carousel-control-next-icon" aria-hidden="true"></span>
            <span className="visually-hidden">Next</span>
          </button>
        </>
      )}
    </div></div>) }

    </div>
   );
  }





}

export default Love;
