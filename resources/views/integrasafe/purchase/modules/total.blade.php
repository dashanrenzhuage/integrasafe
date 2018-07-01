<div id="pricing-total" class="mdc-card mdc-elevation--z4">
    <section class="mdc-card__primary">
        <h1 class="mdc-card__title mdc-card__title--large">
            Products: $<span id="product-total">{{ $total - $tax - 15 }}<span id="order-total">
        </h1>
        <h1 class="mdc-card__title mdc-card__title--large">
            Shipping: $<span id="current-shipping">15.00</span>
        </h1>
        <h1 class="mdc-card__title mdc-card__title--large">
            Tax: $<span id="tax-total">{{ $tax }}</span>
        </h1>
    </section>
    <section class="mdc-card__media">
        <h1 class="mdc-card__title mdc-card__title--large">Order Total:
            $<span id="order-total-price">{{ $total }}</span>
        </h1>
    </section>
    <section class="mdc-card__primary">
        <label>
            <input name="discount_code" class="field is-empty"/>
            <span><span>Coupon Code</span></span>
        </label>
        <button id="submit-form" type="submit" class="submit-button" title="Review your Order">
            Review and Purchase
        </button>
    </section>
</div>
