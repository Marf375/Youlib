import React, { Component } from 'react';
import axios from 'axios';
import ReactDOM from 'react-dom/client';

class BalanceModal extends Component {
    constructor(props) {
        super(props);
        this.state = {
            amount: '',
            isLoading: false,
            error: '',
            isOpen: false,
        };
    }

    openModal = () => {
        this.setState({ isOpen: true });
    };

    closeModal = () => {
        this.setState({ isOpen: false, amount: '', error: '' });
    };

    handleInputChange = (event) => {
        this.setState({ amount: event.target.value });
    };

    handleSubmit = async (event) => {
        event.preventDefault();
        const { amount } = this.state;

        if (!amount || parseFloat(amount) <= 0) {
            this.setState({ error: 'Введите корректную сумму' });
            return;
        }

        this.setState({ isLoading: true, error: '' });

        try {
            const response = await axios.post('/balance/topup', {
                amount: parseFloat(amount)
            });

            const clientSecret = response.data.clientSecret;
            if (clientSecret) {
                // Подключение Stripe.js, если не подключено
                if (!window.Stripe) {
                    const script = document.createElement('script');
                    script.src = 'https://js.stripe.com/v3/';
                    script.onload = () => {
                        const stripe = window.Stripe(window.STRIPE_KEY); // должен быть определён в <head>
                        stripe.confirmCardPayment(clientSecret);
                    };
                    document.body.appendChild(script);
                } else {
                    const stripe = window.Stripe(window.STRIPE_KEY);
                    stripe.confirmCardPayment(clientSecret);
                }
            } else {
                this.setState({ error: 'Ошибка получения данных от Stripe' });
            }

            this.closeModal();
        } catch (error) {
            console.error(error);
            this.setState({ error: 'Ошибка пополнения. Попробуйте снова.' });
        } finally {
            this.setState({ isLoading: false });
        }
    };

    render() {
        const { isOpen, amount, isLoading, error } = this.state;

        return (
            <div className='win'>
                <button onClick={this.openModal} className="open-modal-button addn">+</button>

                {isOpen && (
                    <div className="modal-overlay">
                        <div className="modal-window">
                            <div className='aa'>
                                <h2 className='text-center text-[2rem] text-[#9370DB]'>Пополнение баланса</h2>
                                <button className="close-button" onClick={this.closeModal}>&times;</button>
                            </div>
                            <form onSubmit={this.handleSubmit}>
                                <input
                                    className='aadd bg-[transparent] border-solid border-[1px] border-[#9370DB] rounded-[10px] text-[white]'
                                    type="number"
                                    min="1"
                                    step="0.01"
                                    value={amount}
                                    onChange={this.handleInputChange}
                                    required
                                    placeholder='Сумма (₽)'
                                />

                                <p className='text-sm text-gray-400 mt-2 mb-4'>Оплата через банковскую карту (Stripe)</p>

                                <button className="bts text-[white]" type="submit" disabled={isLoading}>
                                    {isLoading ? 'Обработка...' : 'Пополнить'}
                                </button>
                                {error && <p className="text-red-500 mt-2">{error}</p>}
                            </form>
                        </div>
                    </div>
                )}
            </div>
        );
    }
}

// Рендерим в контейнер с id="bala"
const a = ReactDOM.createRoot(document.getElementById('bala'));
a.render(<BalanceModal />);
