<x-layout>
    <div class="container">
        <h1>Vérification de votre compte</h1>

        <h2>Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous adresser par email de nouveau.</h2>

        <p>Si vous n'avez pas reçu l'e-mail, nous pouvons vous en renvoyer un :</p>
        
        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="border rounded bg-black my-4 py-1 px-10 text-white hover:bg-gray-700">
                Renvoyer l'e-mail de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="border rounded bg-black my-4 py-1 px-10 text-white hover:bg-gray-700">
                Se déconnecter
            </button>
        </form>
    </div>
</x-layout>