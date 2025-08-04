import React from "react";

class Cart extends React.Component {
    handleCheckout = async () => {
        const { cartItems, userId } = this.props;

        try {
            const response = await fetch('/create-checkout-session', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    items: cartItems.map(item => ({
                        name: item.name,
                        price: Math.round(parseFloat(item.price) * 100),
                        quantity: 1
                    })),
                    metadata: {
                        user_id: userId,
                        cart: JSON.stringify(cartItems.map(item => ({
                            bookName: item.name,
                            bookPrice: item.price,
                            img: item.img,
                        })))
                    }
                }),
            });

            const data = await response.json();
            if (data.url) {
                window.location.href = data.url;
            } else {
                console.error('Stripe не вернул URL');
            }
        } catch (err) {
            console.error('Ошибка при создании сессии Stripe:', err);
            alert('Произошла ошибка при оплате. Попробуйте позже.');
        }
    };




    handleBalancePayment = () => {
        const { cartItems, clearCart } = this.props;

        if (cartItems.length === 0) {
            alert("Корзина пуста!");
            return;
        }

        const totalCost = cartItems.reduce((sum, item) => sum + parseFloat(item.price), 0);

        fetch("/orders", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({
                cart: cartItems.map((item) => ({
                    id: item.id,
                    bookName: item.name,
                    bookPrice: item.price,
                    img: item.img,
                    file_path: item.file_path,
                })),
                total: totalCost,
            }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    alert("Оплата с баланса прошла успешно!");
                    clearCart();
                } else {
                    alert("Ошибка при оплате с баланса: " + (data.error || "Неизвестная ошибка"));
                }
            })
            .catch((err) => {
                console.error("Ошибка:", err);
                alert("Произошла ошибка при оплате с баланса.");
            });
    };

    render() {
        const { cartItems, removeFromCart, clearCart } = this.props;

        return (
            <div>
                {cartItems.length === 0 ? (
                    <p className="text-[#9370DB]">Корзина пуста</p>
                ) : (
                    <ul>
                        {cartItems.map((item) => (
                            <li key={item.id} className="flex justify-between items-center mb-2">
                                <span>{item.name}</span>
                                <span>{item.price} Руб.</span>
                                <img src={item.img} alt={item.name} className="w-10 h-10" />
                                <button
                                    onClick={() => removeFromCart(item.id)}
                                    className="text-red-600 hover:text-red-800"
                                >
                                    ❌
                                </button>
                                <hr className="bg-[white]" />
                            </li>
                        ))}
                    </ul>
                )}

                {cartItems.length > 0 && (
                    <div className="mt-4">
                        <p className="text-lg font-semibold text-[#9370DB]">
                            Итого: {cartItems.reduce((sum, item) => sum + parseFloat(item.price), 0)} Руб.
                        </p>
                        <div className="flex justify-end space-x-4 mt-2">
                            <button
                                onClick={clearCart}
                                className="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                            >
                                Очистить
                            </button>
                            <button
                                onClick={this.handleBalancePayment}
                                className="bg-[#9370DB] hover:bg-[#7c5fc9] text-white px-4 py-2 rounded"
                            >
                                Оплатить с баланса
                            </button>
                            <button
                                onClick={this.handleCheckout}
                                className="bg-[#21ba09] hover:bg-green-600 text-white px-4 py-2 rounded"
                            >
                                Оплатить через Stripe
                            </button>
                        </div>
                    </div>
                )}
            </div>
        );
    }
}

export default Cart;
