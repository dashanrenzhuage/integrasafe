<div id="cart-products" class="mdc-card mdc-elevation--z4">
    <section class="mdc-card__primary">
        <h1 class="mdc-card__title mdc-card__title--large">Selected Products</h1>
    </section>
    <ul class="mdc-list mdc-list--two-line mdc-list--avatar-list">
        @forelse ($skus as $sku)
            <li class="mdc-list-item mdc-ripple-upgraded"
                style="--mdc-ripple-fg-size:192px; --mdc-ripple-fg-scale:1.76042;">
                <span class="mdc-list-item__graphic" role="presentation">
                    <i class="material-icons" aria-hidden="true">redeem</i>
                </span>
                <span class="mdc-list-item__text">
                    {{ $sku->name }}
                    <span class="mdc-list-item__secondary-text"
                          title="Desired Quantity">Quantity: {{ $sku->quantity }}</span>
                    @if ($sku->subscription !== false)
                        <span class="mdc-list-item__secondary-text" title="Subscription Price">
                            Subscription:
                            ${{ substr($sku->subscription->amount, 0, -2) }}.{{ substr($sku->subscription->amount, 1) }}
                            per {{ $sku->subscription->interval }}
                        </span>
                    @endif
                </span>
                <span class="mdc-list-item__meta"
                      title="Product Price">Price: ${{ $sku->price }}
                </span>
                <button class="mdc-button" type=button value="{{ $sku->product_sku }}" onclick="removeFromCart(this)">
                    <i class="mdc-list-item__meta material-icons mdc-button__icon">delete_forever</i>
                </button>
                <input type="hidden" name="{{ $sku->product_sku }}">
            </li>
        @empty
            <li class="mdc-list-item mdc-ripple-upgraded"
                style="--mdc-ripple-fg-size:192px; --mdc-ripple-fg-scale:1.76042;">
                <span class="mdc-list-item__graphic" role="presentation">
                    <a href="{{ url('/purchase') }}" class="mdc-list-item__meta material-icons"
                       aria-label="View Products" title="View available Products">
                    info
                    </a>
                </span>
                <span class="mdc-list-item__text">
                    No Products Selected!
                    <span class="mdc-list-item__secondary-text">
                        You have not added any items to your cart
                    </span>
                </span>
            </li>
        @endforelse
    </ul>
</div>
