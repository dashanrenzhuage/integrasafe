<style>
    .mdc-tab--active {
        color: dodgerblue;
    }

    .material-icons.mdc-tab--active {
        color: orange;
    }

    .previous-active,
    .material-icons.previous-active {
        color: limegreen;
    }
</style>
<div id="payment_process" style="padding-top: 120px"
     class="custom-ink-color-tab mdc-tab-bar mdc-tab-bar--icons-with-text mdc-tab-bar-upgraded">
    {{-- Select Products to Purchase --}}
    <a href="{{ url('/purchase') }}"
       class="mdc-tab mdc-tab--with-icon-and-text mdc-ripple-upgraded {{ $payment_process['select'] }}">
        <i class="material-icons mdc-tab__icon {{ $payment_process['select'] }}"
           aria-hidden="true">add_shopping_cart</i>
        <span class="mdc-tab__icon-text">Select Products</span>
    </a>
    {{-- Purchase Selected Products --}}
    <a href="{{ url('/purchase/payment') }}"
       class="mdc-tab mdc-tab--with-icon-and-text mdc-ripple-upgraded {{ $payment_process['purchase'] }}">
        <i class="material-icons mdc-tab__icon {{ $payment_process['purchase'] }}" aria-hidden="true">card_giftcard</i>
        <span class="mdc-tab__icon-text">Payment Details</span>
    </a>
    {{-- Review Order --}}
    <a class="mdc-tab mdc-tab--with-icon-and-text mdc-ripple-upgraded {{ $payment_process['confirm'] }}">
        <i class="material-icons mdc-tab__icon {{ $payment_process['confirm'] }}" aria-hidden="true">verified_user</i>
        <span class="mdc-tab__icon-text">Review</span>
    </a>
</div>
