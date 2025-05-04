<form action="{{ route('stripe.checkout') }}" method="POST">
    @csrf
    <input type="hidden" name="order_id" value="{{ $orderId }}">
    <button type="submit">Tester Checkout</button>
</form>