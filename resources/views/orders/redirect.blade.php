<x-layout>
    <p>Redirection vers le paiement...</p>

    <form id="stripeForm" action="{{ route('stripe.checkout') }}" method="POST">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
    </form>

    <script>
        document.getElementById('stripeForm').submit();
    </script>
</x-layout>
    
    
