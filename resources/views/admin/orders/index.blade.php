<x-layout title="Toutes les commandes des clients">
    <h1>Liste des commandes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Utilisateur</th>
                <th>Statut</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->firstname }} {{ $order->user->lastname }}</td>
                <td>{{ $order->getStatusLabel() }}</td>
                <td>{{ number_format($order->total_price_with_tax / 100, 2, ',', '') }} €</td>
                <td>
                    @if($order->status !== 'cancelled')
                    <form method="POST" action="{{ route('admin-orders.cancel', $order->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Annuler la commande</button>
                    </form>
                    @else
                        Annulée
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout>