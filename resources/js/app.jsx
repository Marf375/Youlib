import ReactDOM from 'react-dom/client'
import Cen from './navig';
import Cart from "./components/cart";
import { BrowserRouter as Router, Link, Routes, Route } from 'react-router-dom';

import Main from './main';
import Comics from './comics';
import React, { useState, useEffect } from 'react';
import axios from 'axios';

class Appin extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            loading: true,
            books: [],
            userLibrary: [],
            isAuthenticated: false,
        };
    }

    componentDidMount() {
        // Определяем текущий путь
        const currentPath = window.location.pathname;

        // Страницы, где НУЖЕН user-library
        const libraryPages = ['/profile', '/dashboard', '/dashboard/comics/dashboard/books']; // добавьте свои пути

        // Нужно ли загружать user-library?
        const shouldLoadLibrary = libraryPages.includes(currentPath);

        // Создаем массив обязательных запросов
        const requests = [
            axios.get('/books'),
            axios.get('/books'),
            axios.get('/user-status'),
            axios.get('/user-status')
        ];

        // Добавляем запрос user-library только если требуется
        if (shouldLoadLibrary) {
            requests.push(axios.get('/user-library'));
        }

        Promise.all(requests)
            .then((responses) => {
                const [firstBooksRes, secondBooksRes, firstStatusRes, secondStatusRes] = responses;
                let libraryRes = shouldLoadLibrary ? responses[4] : { data: null };

                // Выбираем непустые данные
                const booksData = firstBooksRes.data?.length ? firstBooksRes.data : secondBooksRes.data;
                const statusData = firstStatusRes.data || secondStatusRes.data; // исправлено для статуса

                this.setState({
                    books: booksData,
                    isAuthenticated: statusData.isAuthenticated,
                    userLibrary: libraryRes.data,
                    loading: false,
                });
            })
            .catch((error) => {
                console.error('Ошибка загрузки данных:', error);
                this.setState({ loading: false });
            });
    }

    render() {
        const { loading, books, userLibrary, isAuthenticated } = this.state;

        if (loading) {
            return (
                <div
                    id="preloader"
                    style={{
                        position: 'fixed',
                        top: 0, left: 0, right: 0, bottom: 0,
                        backgroundColor: '#fff',
                        display: 'flex',
                        justifyContent: 'center',
                        alignItems: 'center',
                        zIndex: 9999,
                    }}
                >
                    <div
                        style={{
                            width: 50,
                            height: 50,
                            border: '5px solid #3498db',
                            borderTop: '5px solid transparent',
                            borderRadius: '50%',
                            animation: 'spin 1s linear infinite',
                        }}
                    />
                    <style>
                        {`
              @keyframes spin {
                to { transform: rotate(360deg); }
              }
            `}
                    </style>
                </div>
            );
        }

        return (
            <div>
                <App
                    books={books}
                    userLibrary={userLibrary}
                    isAuthenticated={isAuthenticated}
                />
            </div>
        );
    }
}
const a= ReactDOM.createRoot(document.getElementById('anp'))
a.render(<Appin />)

class App extends React.Component{
    constructor(props) {
        super(props);
        this.state = {
            showCart: false,
            cartItems: [],
            User:[],
            user: null,
            isAuthenticated: false,
        };
    }
    componentDidMount() {
        axios.get('/user-st').then(res => {
            this.setState({
                user: res.data,
                isAuthenticated: res.data.isAuthenticated,
            });
        }).catch(err => {
            console.error('Ошибка получения user-status:', err);
        });
    }
    clearCart = () => {
        this.setState({ cartItems: [] });
    };

    addToCart = (book) => {
        this.setState((prevState) => ({
            cartItems: [...prevState.cartItems, book],
        }));
    };

    removeFromCart = (bookId) => {
        this.setState((prevState) => ({
            cartItems: prevState.cartItems.filter((item) => item.id !== bookId),
        }));
    };

    toggleCart = () => {
        this.setState((prevState) => ({
            showCart: !prevState.showCart,
        }));
    };

    render() {
        const { showCart, cartItems,user,} = this.state;
        const { isAuthenticated } = this.props;
        console.log('Cart items:', cartItems);
        console.log('user', user);

        return (
            <div>
                <Cen
                    addToCart={this.addToCart}
                    removeFromCart={this.removeFromCart}
                    cartItems={cartItems}
                    books={this.props.books}
                    userLibrary={this.props.userLibrary}
                    isAuthenticated={isAuthenticated}
                />

                {isAuthenticated && (
                    <button
                        onClick={this.toggleCart}
                        className="absolute text-[#9370db] border-[1px] border-solid border-[#9370DB] w-[10dvw] rounded-[10px] h-[4dvh] anp"
                    >
                        Корзина ({cartItems.length})
                    </button>
                )}

                {/* Модальное окно корзины */}
                {showCart && (
                    <div className=" fixed inset-0 bg-[black] bg-opacity-50 flex justify-center items-center   z-50">
                        <div className="cc  rounded-lg p-6 max-[w-2xl] w-[70dvw] max-h-[80vh] overflow-y-auto border-solid border-[1px] border-[#9370DB] ">
                            <div className="flex justify-between items-center mb-4 anv">
                                <h2 className="text-2xl font-bold text-[white]">Ваша корзина</h2>
                                <button
                                    onClick={this.toggleCart}
                                    className="text-[#ff0000] hover:text-gray-700"
                                >
                                    ✕
                                </button>
                            </div>

                            <Cart
                                cartItems={cartItems}
                                removeFromCart={this.removeFromCart}
                                clearCart={this.clearCart}
                                userId={user?.id}
                            />

                            <div className="mt-4 flex justify-end space-x-4 ">
                                <button
                                    onClick={this.toggleCart}
                                    className="px-4 py-2 border-solid border-[1px] border-[#9370DB]  text-[#9370DB] rounded hover:bg-gray-100"
                                >
                                    Продолжить покупки
                                </button>
                            </div>
                        </div>
                    </div>
                )}
            </div>
        );
    }
}
