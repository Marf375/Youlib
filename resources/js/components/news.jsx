import React from "react";
import axios from "axios";
import Card_a from "./card_a";
import Card from "./card";

class News extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      activeIndex: 0,
      books: [],
      userLibrary: [],
      isAuthenticated: false,
      cartItems:[],
    };
  }

  componentDidMount() {
    this.fetchBooks();
    this.fetchUserLibrary();
    this.checkAuthentication();
  }

  fetchBooks = async () => {
    try {
      const response = await axios.get("/books");
      this.setState({ books: response.data });
    } catch (error) {
      console.error("Ошибка при загрузке книг:", error);
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
  filterBooksByDate = (books) => {
    const currentDate = new Date();
    const fiveDaysAgo = new Date();
    fiveDaysAgo.setDate(currentDate.getDate() - 7);

    return books.filter((book) => {
      const bookDate = new Date(book.created_at);
      return bookDate >= fiveDaysAgo;
    });
  };
  
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

  render() {
    const { books, isAuthenticated, userLibrary,activeIndex  } = this.state;
    const { addToCart, removeFromCart, cartItems } = this.props;  
    const news = this.filterBooksByDate(books);
    const bookChunks = [];
if(window.innerWidth>1200){
    for (let i = 0; i < news.length; i += 4) {
      bookChunks.push(news.slice(i, i + 4));
    }
  }else if(window.innerWidth<400){
    for (let i = 0; i < news.length; i += 1) {
      bookChunks.push(news.slice(i, i + 1));
    }
  }
    else if(window.innerWidth<1200 && window.innerWidth>400){
    for (let i = 0; i < news.length; i += 2) {
      bookChunks.push(news.slice(i, i + 2));
    }
  }


    return (
   
       
        <div>
    
          {(news.length==0)?(<div></div>):( <div>
            <h1 className="text-[2rem] text-[#9370DB] mx-[5dvw]">Новинки</h1>
            <div className="carousel-container w-[90dvw] h-[30dvh] relative">
        <div className="carousel h-[30dvh]">
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
       
     </div>
     </div>
  )}
     </div>
      
    );
    
  }
}


export default News;