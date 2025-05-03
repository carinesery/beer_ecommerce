<style>
    main {
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 2rem;
        padding: 4rem 2rem;
    }

    h1 {
        font-size: 2rem;
        font-weight: 700;
        text-align: center;
    }

    form {
        width: fit-content;
        margin: auto;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    fieldset {
        width: 100%;
    }

   
    legend {
        border-bottom: 1px solid grey;
        padding: .25rem;
        width: 100%;
        font-weight: 700;
    }

    .label-input {
        padding: 0.25rem;
        width: 100%;
        display: flex;
    }

    .false-label-input {
        display: flex;
        padding: 0.25rem;
        width: 100%;
    }

    .label, 
    .known {
        display: block;
    }

    label,
    .label {
        display: block;
        width: 30%;
    }

    input {
        
        border: 1px solid grey;
        border-radius: .25rem;
        margin-left: .25rem;
        width: 60%;
    }

    input[type="checkbox"] {
        width: fit-content;
    }

    .identity,
    .contact-informations {
        display: flex;
        flex-direction: column;
        /* gap: 1rem; */
        margin-top: .5rem;
        width: 100%;
    }

    .civility {
        display: flex;
        gap: .5rem;
        align-items: center;
    }

    .required {
        color: red;
    }

    .legal-informations-required {
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .legal-informations-required .label-input {
        padding: 0 .25rem;
    }

    button {
        width: fit-content;
        padding: .5rem 1rem;
        background-color: orangered;
        color: white;
        margin: 2rem auto;
        border-radius: .5rem;
    }

    .legal-informations-required a {
        text-decoration: underline;
        text-decoration-color: orangered ;
    }
</style>

<x-layout title="Validation de commande">
    <main>
        <h1>Validation de commande</h1>
            <h2>Résumé de votre panier</h2>
                <ul class="resume-cart">
                @foreach($order->items as $item)
                    <li>
                        Bière {{ $item->productVariant->product->name }}, contenance de  
                        {{ $item->productVariant->volume }}. Quantité : {{ $item->quantity }} / Prix TTC : {{ number_format($item->priceWithTax()/100, 2, ',', '') }} €
                    </li>
                @endforeach
                </ul>
                <p>Total TTC : {{ number_format($order->total_price_with_tax/100, 2, ',', '') }} €</p>
        <form action="{{ route('orders.store') }}" method="POST">
        @csrf
            <!-- Prénom, nom, mail, adresse, code postal, ville, numéro de téléphone, checkbox conditions générales -->
            <fieldset>
                <legend>Identité</legend>
                <div class="identity">
                    <span class="false-label-input"><span class="label">Prénom</span><span class="known">{{ $user->firstname }}</span></span> 
                    <span class="false-label-input"><span class="label">Nom</span><span class="known">{{ $user->lastname }}</span></span> 
                </div>
                <!-- Boutons radio pour civilité ? -->
                <!-- <div class="identity">
                    <div class="civility">
                        <span>Civilité<span class="required">*</span></span>
                        <div class="label-input">
                            <label>
                                <input type="radio" name="civility" value="M." {{ old('civility') == 'M.' ? 'checked' : '' }} required>
                                Monsieur
                            </label>
                        </div>
                        <div class="label-input">
                            <label>
                                <input type="radio" name="civility" value="Mme" {{ old('civility') == 'Mme' ? 'checked' : '' }} required>
                                Madame
                            </label>
                        </div>
                    </div>
                    <div class="label-input">
                        <label for="firstname">Prénom<span class="required">*</span></label>
                        <input type="text" name="firstname" id="firstname" required>
                    </div>
                    <div class="label-input">
                        <label for="lastname">Nom<span class="required">*</span></label>
                        <input type="text" name="lastname" id="lastname" required>
                    </div>   
                </div>
            </fieldset> -->
            <fieldset>
                <legend>Coordonnées de contact</legend>
                <div class="contact-informations">
                    <!--<div class="label-input">
                        <label for="email">Email<span class="required">*</span></label>
                        <input type="email" name="email" id="email" required>
                    </div> -->
                    <span class="false-label-input"><span class="label">Email</span><span class="known">{{ $user->email }}</span></span> 
                    <div class="label-input">
                        <label for="phone">Téléphone</label>
                        <input type="number" name="phone" id="phone">
                    </div>
                </div>
            </fieldset>
            <fieldset>
                <legend>Adresse de livraison</legend>
                <div class="label-input">
                    <label for="address">Adresse (numéro et nom de la rue)<span class="required">*</span></label>
                    <input type="text" name="address" id="address" required>
                </div>
                <div class="label-input">
                    <label for="zipcode">Code postal<span class="required">*</span></label>
                    <input type="number" name="zipcode" id="zipcode" required>
                </div>
                <div class="label-input">
                    <label for="city">Ville<span class="required">*</span></label>
                    <input type="text" name="city" id="city" required>
                </div>
            </fieldset>
            <div class="legal-informations-required">
                <div class="label-input">
                    <input type="checkbox" name="privacy-policy" id="privacy-policy" required>
                    <label for="privacy-policy">En cochant cette case, j'accepte la <a href="">Politique de confidentialité</a>.<span class="required">*</span></label>
                </div>
                <div class="label-input">
                    <input type="checkbox" name="terms-of-sale" id="terms-of-sale" required>
                    <label for="terms-of-sale">En cochant cette case, j'accepte les <a href="">Conditions générales de vente</a>.<span class="required">*</span></label>
                </div>
            </div>
            <button type="submit">Valider la commande</button>
        </form>
    </main>
</x-layout>