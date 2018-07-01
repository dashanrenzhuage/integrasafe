@extends('layouts.master')
@section('title', 'IntegraSafe - Review')
@section('content')

    <style>
        .mdc-card {
            background-color: white;
        }

        .total-class {
            font-size: 20px;
        }

        .purchase-button {
            float: left;
            display: block;
            background: #34D08C;
            color: white;
            border-radius: 2px;
            border: 0;
            margin-top: 20px;
            font-size: 19px;
            font-weight: 400;
            width: 100%;
            height: 47px;
            line-height: 45px;
            outline: none;
        }

        .edit-button {
            float: left;
            display: block;
            background: dodgerblue;
            color: white;
            border-radius: 2px;
            border: 0;
            margin-top: 20px;
            font-size: 19px;
            font-weight: 400;
            width: 100%;
            height: 47px;
            line-height: 45px;
            outline: none;
        }
    </style>

    @include('integrasafe.purchase.modules.payment_process')
    @include('integrasafe.dialogs.loading')

    <br>

    <div class="container">
        <div class="mdc-card mdc-elevation--z4">
            <section class="mdc-card__primary">
                <h1 class="mdc-card__title mdc-card__title--large">Summary: Order #{{ $order_id[1] }}</h1>
            </section>

            {{-- Selected Products --}}
            <section class="mdc-card__supporting-text">
                <table class="table">
                    <thead>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    </thead>
                    @forelse ($skus as $sku)
                        <tr>
                            <td>{{ $sku->name }}</td>
                            <td>{{ $sku->quantity }}</td>
                            <td>${{ $sku->price }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                No Products Selected!
                            </td>
                        </tr>
                    @endforelse
                </table>
            </section>
        </div>

        <br>

        <div class="mdc-card mdc-elevation--z4">
            {{-- Payment Information --}}
            <section class="mdc-card__primary">
                <h1 class="mdc-card__title mdc-card__title--large">Payment Information</h1>
            </section>
            <section class="mdc-card__supporting-text">
                <table class="table">
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Name:</td>
                        <td>{{ $customer['sources']['data'][0]['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Email Address:</td>
                        <td>{{ $customer['email'] }}</td>
                    </tr>
                    {{-- Billing --}}
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Billing Address:</td>
                        <td>{{ $billing_address->address }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Billing City:</td>
                        <td>{{ $billing_address->city }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Billing Country:</td>
                        <td>{{ $billing_address->country }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Billing Zip Code:</td>
                        <td>{{ $billing_address->zipcode }}</td>
                    </tr>
                    {{-- Shipping --}}
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Shipping Address:</td>
                        <td>{{ $shipping_address->address }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Shipping City:</td>
                        <td>{{ $shipping_address->city }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Shipping Country:</td>
                        <td>{{ $shipping_address->country }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Shipping Zip Code:</td>
                        <td>{{ $shipping_address->zipcode }}</td>
                    </tr>
                    {{-- Payment --}}
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Card Number:</td>
                        <td>
                            {{ $customer['sources']['data'][0]['brand'] }} {{ $customer['sources']['data'][0]['funding'] }}
                            ****************{{ $customer['sources']['data'][0]['last4'] }}
                        </td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Card Expiration:</td>
                        <td>{{ $customer['sources']['data'][0]['exp_month'] }}
                            /{{ $customer['sources']['data'][0]['exp_year'] }}</td>
                    </tr>
                    <tr>
                        <td class="mdl-data-table__cell--non-numeric">Card Zip Code:</td>
                        <td>{{ $customer['sources']['data'][0]['address_zip'] }}</td>
                    </tr>
                </table>
            </section>
        </div>

        <br>

        <div class="mdc-card mdc-elevation--z4">
            {{-- Total --}}
            <section class="mdc-card__primary">
                <h1 class="mdc-card__title mdc-card__title--large">Total</h1>
                <ul class="mdc-list demo-list">
                    <li class="mdc-list-item">
                        Products
                        <span class="mdc-list-item__meta">${{ $product_total }}</span>
                    </li>
                    <li class="mdc-list-item">
                        Subscription
                        <span class="mdc-list-item__meta">$9.99</span>
                    </li>
                    <li class="mdc-list-item">
                        Shipping
                        <span class="mdc-list-item__meta">${{ $shipping_price }}</span>
                    </li>
                    <li class="mdc-list-item">
                        Tax
                        <span class="mdc-list-item__meta">${{ $tax }}</span>
                    </li>
                    <li class="mdc-list-divider" role="separator"></li>
                    <li class="mdc-list-item total-class">
                        <strong>Total</strong>
                        <span class="mdc-list-item__meta">
                                <strong>${{ $total }}</strong>
                            </span>
                    </li>
                </ul>
            </section>

            {{-- Modify the existing Order or charge the Customer for the Order --}}
            <section class="mdc-card__actions">
                <button class="edit-button mdc-button--compact mdc-card__action"
                        onclick="window.location.replace('https://dev.integrasafe.net/purchase/payment');">Edit
                </button>
                <form id="review-payment-form" action="{{ url('/purchase/review') }}" method="post"
                      style="width: 100%">
                    {{ csrf_field() }}
                    <input type="hidden" name="stripe_order_id" value="{{ $order_id[1] }}">
                    <input type="hidden" name="order_id" value="{{ $order_id[0] }}">
                    <input type="hidden" name="email" value="{{ $customer['email'] }}">
                    <button id="review-purchase" class="purchase-button mdc-button--compact mdc-card__action">
                        Purchase
                    </button>
                </form>
            </section>
        </div>

    </div>

    <br>

    <script src="{{ asset('js/checkout.js') }}" type="text/javascript" async></script>
@endsection
