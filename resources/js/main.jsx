import React from 'react';
import Rec from './components/inma';
import News from './components/news';
import Love from './components/love';
import PropTypes from 'prop-types';

class Main extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      cartItems:[],
    };
  }


  render() {
    const { addToCart, removeFromCart, cartItems } = this.props;
    return (
      <div>
           <div>
          <h1 className="text-[2rem] text-[#9370DB] mx-[5dvw]">Рекомендуемые</h1>
          <Rec addToCart={addToCart} removeFromCart={removeFromCart} cartItems={cartItems} />
        </div>
            <div className="w-[100dvw] h-[50px] it my-[5dvh]">

            </div>
            <div>
              <h1 className="text-[2rem] text-[#9370DB] my-[10px] mx-[5dvw]">Интересный факт</h1>
              <div className="tsp mt-[3dvh] w-[50dvw] h-[30dvh] justify-self-center">
                <p className='fp'>Интересный факт: Самая большая библиотека в мире — Библиотека Конгресса США. В её коллекции более 170 миллионов единиц хранения, а длина книжных полок превышает 1 300 километров!</p>
              </div>
            </div>

            <div>

          <News addToCart={addToCart} removeFromCart={removeFromCart} cartItems={cartItems} />
        </div>
        <div className='w-[100dvw] h-[20dvh]'></div>
        <div >

          <Love addToCart={addToCart} removeFromCart={removeFromCart} cartItems={cartItems} />
        </div>

      </div>
    );
  }
}

export default Main;
