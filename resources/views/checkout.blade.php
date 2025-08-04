<!DOCTYPE html>
<html>
<head>
    <title>Checkout</title>
</head>
<body>
<h1>Stripe Checkout</h1>
<form action="{{ route('session') }}" method="POST">
    @csrf
    <button type="submit">Оплатить $20</button>
</form>

@if(request('success'))
    <p style="color: green">Оплата прошла успешно!</p>
@endif

@if(request('canceled'))
    <p style="color: red">Оплата была отменена.</p>
@endif
</body>
</html>
