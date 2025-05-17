<x-mail::message>

Bonjour {{ $order->user->firstname }} {{ $order->user->lastname }},

nous vous confirmons la validation et le paiement de la commande n° {{ $order->paid_at->format('Ymd')}}-{{ $order->id }}.

Nous préparons votre commande afin de vous l'adresser dans les meilleurs délais. 

Si besoin, vous pouvez consulter votre commande en suivant ce lien : 

<x-mail::button :url="route('orders.show', $order->id)">
Voir ma commande
</x-mail::button>

Merci à vous,<br>
{{ config('app.name') }}
</x-mail::message>
