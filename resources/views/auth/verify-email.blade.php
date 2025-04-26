<x-layout>
    <div class="container">
        <h1>Vérification de votre adresse e-mail</h1>

        <p>Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer.</p>

        <p>Si vous n'avez pas reçu l'e-mail, nous pouvons vous en renvoyer un :</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success">
                Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                Renvoyer l'e-mail de vérification
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px;">
            @csrf
            <button type="submit" class="btn btn-secondary">
                Se déconnecter
            </button>
        </form>
    </div>
</x-layout>