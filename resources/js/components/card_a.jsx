import React from "react";

class Card_a extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      inCart: false,
      isInLibrary: false // Добавляем в состояние
    };
  }

  componentDidUpdate(prevProps) {
    if (prevProps.cartItems !== this.props.cartItems) {
      this.checkIfInCart();
    }
    if (prevProps.userLibrary !== this.props.userLibrary ||
        prevProps.book !== this.props.book) {
      this.checkIfInLibrary();
    }


  }

  componentDidMount() {
    this.checkIfInCart();
    this.checkIfInLibrary();
  }

  checkIfInCart = () => {
    const { book, cartItems } = this.props;
    const isInCart = cartItems && Array.isArray(cartItems) &&
                    cartItems.some(item => item.id === book.id);
    this.setState({ inCart: isInCart });
  };

  checkIfInLibrary = () => {
    const { book, userLibrary } = this.props;

    if (!book || !userLibrary || !userLibrary.library || !Array.isArray(userLibrary.library)) {
      this.setState({ isInLibrary: false });
      return;
    }
    const normalizeString = str =>
      str ? str.toString().trim().toLowerCase() : '';

    const bookNameNormalized = normalizeString(book.name);
    const bookId = book.id;

    const isInLibrary = userLibrary.library.some(libBook => {
      const libBookNameNormalized = normalizeString(libBook.book_name);
      return (
        libBookNameNormalized === bookNameNormalized ||
        libBook.id === bookId
      );
    });

    this.setState({ isInLibrary });
  };

  handleAddToCart = () => {
    const { book, addToCart } = this.props;
    addToCart(book);
    this.setState({ inCart: true });
  };

  handleRemoveFromCart = () => {
    const { book, removeFromCart } = this.props;
    removeFromCart(book.id);
    this.setState({ inCart: false });
  };

  render() {
    const { book } = this.props;
    const { inCart, isInLibrary } = this.state;

    if (!book) {
      return <div>Загрузка...</div>;
    }

    return (
      <div className="mt-5  card card_a border-none bg-transparent  h-[50dvh]">
        <div className="product-card h-[50dvh] ">
          <a href={`/book_a#${book.id}`}>
            <img src={book.img} alt="Товар" className="product-image" />
            <div className="product-info">
              <h5>{book.file}</h5>
              <h5 className="bn">{book.name}</h5>
              <h5>{book.copyright_holder}</h5>
            </div>
          </a>
        </div>

        <div>
          {isInLibrary ? (
            <p className="bp text-white">Книга у вас в библиотеке</p>
          ) : (
            <div>
              <div className="flex">

                <p className="bp text-[18px] my-[10px] mx-[20px] price text-[#9370DB]">{book.price}</p>
                <p className="mx-[5px] my-[10px] text-[#9370DB]">Руб.</p>
              </div>
              {inCart ? (
                <button
                  className="ats border border-[#9370DB] text-[#9370DB] rounded-[10px] h-[50px] w-[13dwv] bg-gray-600"
                  onClick={this.handleRemoveFromCart}
                >
                  В корзине(удалить из корзины)
                </button>
              ) : (
                <button
                  className="ats border border-[#9370db] text-[#9370DB] rounded-[10px] h-[50px] w-[10dvw] bg-purple-600 ml-[7dvw] overflow-hidden"
                  onClick={this.handleAddToCart}
                >
                  Добавить в корзину
                </button>
              )}
            </div>
          )}
        </div>
      </div>
    );
  }
}

export default Card_a;
