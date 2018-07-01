<div id="payment-information" class="mdc-card mdc-elevation--z4">
    {{-- Payment Information --}}
    <section class="mdc-card__primary">
        <h1 class="mdc-card__title mdc-card__title--large">Personal Information</h1>
    </section>
    <section class="mdc-card__supporting-text">
        <label>
            <input name="cardholderName" class="field is-empty" value="John Smith"
                   placeholder="John Smith" required/>
            <span><span>Name*</span></span>
        </label>

        <label>
            <input name="cardholderEmail" class="field is-empty" type="email"
                   value="johnsmith@email.com" placeholder="johnsmith@email.com" required/>
            <span><span>Email Address*</span></span>
        </label>

        <label>
            <div id="card-element" class="field is-empty"></div>
            <span><span>Credit or debit card*</span></span>
        </label>
    </section>

    {{-- Billing Information --}}
    <section class="mdc-card__primary">
        <h1 class="mdc-card__title mdc-card__title--large">Billing Information</h1>
    </section>
    <section class="mdc-card__supporting-text">
        <label>
            <input name="billingAddress" class="field is-empty" value="123 Street"
                   placeholder="123 Street" required/>
            <span><span>Street Address*</span></span>
        </label>

        <label>
            <input name="billingCity" class="field is-empty" value="Hollywood" placeholder="Hollywood"
                   required/>
            <span><span>City*</span></span>
        </label>

        <label>
            <input name="billingState" class="field is-empty" value="California"
                   placeholder="California" required/>
            <span><span>State*</span></span>
        </label>

        <label>
            <input name="billingCountry" class="field is-empty" value="United States"
                   placeholder="United States" required/>
            <span><span>Country*</span></span>
        </label>

        <label>
            <input name="billingZipCode" class="field is-empty" value="12345" placeholder="12345"
                   required/>
            <span><span>Zip Code*</span></span>
        </label>
    </section>

    {{-- Shipping Information --}}
    <section class="mdc-card__primary">
        <h1 class="mdc-card__title mdc-card__title--large">Shipping Information</h1>
        <h2 class="mdc-card__subtitle">
            <ul class="mdc-list">
                <li class="mdc-list-item">
                    <input type="checkbox" class="filled-in" name="same_as_billing" id="hide-shipping" />
                    <label for="hide-shipping">
                        Same as Billing
                    </label>
                </li>
            </ul>
        </h2>
    </section>
    <div id="shipping-information">
        <section class="mdc-card__supporting-text">
            <label>
                <input name="shippingAddress" class="field is-empty" placeholder="123 Street"/>
                <span><span>Street Address*</span></span>
            </label>

            <label>
                <input name="shippingCity" class="field is-empty" placeholder="Hollywood"/>
                <span><span>City*</span></span>
            </label>

            <label>
                <input name="shippingState" class="field is-empty" placeholder="California"/>
                <span><span>State*</span></span>
            </label>

            <label>
                <input name="shippingCountry" class="field is-empty" placeholder="United States"/>
                <span><span>Country*</span></span>
            </label>

            <label>
                <input name="shippingZipCode" class="field is-empty" placeholder="12345"/>
                <span><span>Zip Code*</span></span>
            </label>
        </section>
    </div>

    <section class="mdc-card__supporting-text">
        <em>* Required Field</em>
    </section>
</div>
