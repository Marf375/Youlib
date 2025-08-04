<!DOCTYPE html>
<html>
<head>
    <title>Пополнение баланса</title>
    <script src="https://js.stripe.com/v3/"></script>
</head>
<body>
    <h1>Пополнение баланса</h1>

    <!-- Кнопка для Google Pay, Apple Pay -->
    <div id="payment-request-button-container"></div>

    <hr>

    <form id="payment-form">
        <label for="amount">Сумма:</label>
        <input type="number" id="amount" name="amount" min="1" required>

        <div id="card-element"><!-- Stripe Elements вставит поле для карты --></div>

        <button id="submit-button" type="submit">Пополнить баланс</button>
    </form>

    <div id="payment-message"></div>

    <script>
        const stripe = Stripe("{{ config('services.stripe.key') }}");
        const elements = stripe.elements();

        // Создаем Payment Request для Google Pay и Apple Pay
        const paymentRequest = stripe.paymentRequest({
            country: 'RU',
            currency: 'rub',
            total: {
                label: 'Пополнение баланса',
                amount: 1000, // Значение по умолчанию в центах
            },
            requestPayerName: true,
            requestPayerEmail: true,
        });

        // Создаем кнопку для Payment Request
        const prButton = elements.create('paymentRequestButton', {
            paymentRequest: paymentRequest,
        });

        paymentRequest.canMakePayment().then(function (result) {
            if (result) {
                prButton.mount('#payment-request-button-container');
            } else {
                document.getElementById('payment-request-button-container');
            }
        });

        // Создаем поле для ввода карты
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        // Обработчик отправки формы
        document.getElementById('payment-form').addEventListener('submit', async (event) => {
            event.preventDefault();

            const amount = document.getElementById('amount').value;

            if (!amount) {
                document.getElementById('payment-message').textContent = "Введите сумму!";
                return;
            }

            // Обновляем сумму в Payment Request
            paymentRequest.update({
                total: {
                    label: 'Пополнение баланса',
                    amount: parseInt(amount) * 100,
                }
            });

            // Запрос на сервер для получения PaymentIntent
            const response = await fetch("{{ route('balance.payment') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ amount })
            });

            const { clientSecret, error } = await response.json();

            if (error) {
                document.getElementById('payment-message').textContent = error;
                return;
            }

            // Подтверждаем платеж через Stripe
            const { error: stripeError } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                }
            });

            if (stripeError) {
                document.getElementById('payment-message').textContent = stripeError.message;
            } else {
                document.getElementById('payment-message').textContent = "Пополнение успешно!";
            }
        });
    </script>
</body>
</html>