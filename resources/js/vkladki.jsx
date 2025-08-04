
import React, { useState } from "react";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";
import Navig from "./navig";
import Cart from "./components/cart";

function Vkladki() {
  const [cartItems, setCartItems] = useState([]);
  const [isCartOpen, setIsCartOpen] = useState(false);

  const addToCart = (book) => {
    setCartItems((prevItems) => [...prevItems, book]);
  };

  const removeFromCart = (bookId) => {
    setCartItems((prevItems) => prevItems.filter((item) => item.id !== bookId));
  };

  const clearCart = () => {
    setCartItems([]);
  };

  return (
    <div className="caa">
      <Navig />
      <button className="btn btn-primary mt-3 mx-3" onClick={() => setIsCartOpen(true)}>
        Открыть корзину ({cartItems.length})
      </button>

      {isCartOpen && (
        <div className="modal d-block bg-dark bg-opacity-50" tabIndex="-1">
          <div className="modal-dialog">
            <div className="modal-content">
              <div className="modal-header">
                <h5 className="modal-title">Корзина</h5>
                <button className="btn-close" onClick={() => setIsCartOpen(false)}></button>
              </div>
              <div className="modal-body">
                <Cart cartItems={cartItems} removeFromCart={removeFromCart} clearCart={clearCart} />
              </div>
            </div>
          </div>
        </div>
      )}
    </div>
  );
}

export default Vkladki;