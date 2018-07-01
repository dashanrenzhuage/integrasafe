@extends('layouts.master')
@section('title', 'IntegraSafe - Products')
@section('content')

    <style>

        * {
            box-sizing: border-box;
        }

        /* Create three columns of equal width */
        .columns {
            float: left;
            width: 33.3%;
            padding: 8px;
        }

        /* Style the list */
        .price {
            list-style-type: none;
            border: 1px solid #eee;
            margin: 0;
            padding: 0;
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }

        /* Pricing header */
        .price .header {
            background-color: #111;
            color: white;
            font-size: 25px;
        }

        /* List items */
        .price li {
            border-bottom: 1px solid #eee;
            padding: 20px;
            text-align: center;
        }

        /* Grey list item */
        .price .grey {
            background-color: #eee;
            font-size: 20px;
        }

        /* Change the width of the three columns to 100%
        (to stack horizontally on small screens) */
        @media only screen and (max-width: 600px) {
            .columns {
                width: 100%;
            }
        }

        .out-of-stock {
            color: red;
            font-style: italic;
        }

        .mdc-list-item {
            font-size: 19px;
        }

        .mdc-card__media .mdc-card__title {
            font-size: 25px;
        }

        form {
            width: 1000px;
            margin: 20px auto;
            font-family: 'Helvetica Neue', Helvetica, sans-serif;
            font-size: 19px;
        }

        label {
            height: 35px;
            position: relative;
            color: #8798AB;
            display: block;
            margin-top: 30px;
            margin-bottom: 20px;
        }

        label > span {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            font-weight: 300;
            line-height: 32px;
            color: #8798AB;
            border-bottom: 1px solid #586A82;
            transition: border-bottom-color 200ms ease-in-out;
            cursor: text;
            pointer-events: none;
        }

        label > span span {
            position: absolute;
            top: 0;
            left: 0;
            transform-origin: 0% 50%;
            transition: transform 200ms ease-in-out;
            cursor: text;
        }

        label .field.is-focused + span span,
        label .field:not(.is-empty) + span span {
            transform: scale(0.68) translateY(-36px);
            cursor: default;
        }

        label .field.is-focused + span {
            border-bottom-color: #34D08C;
        }

        .submit-button {
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

        button:focus {
            background: #24B477;
        }

        button:active {
            background: #159570;
        }
    </style>

    <style>
        .product-price {
            color: #B12704 !important;
            font-size: 16px;
            font-weight: 700;
            margin-top: 8px;
        }

        .float-star {
            float: left;
            padding: 0 1px;
            margin-left: -1px;
        }

        .float-star:first-child {
            padding: 0;
        }

        .stars-reviews {
            font-size: 12px;
            display: inline-block;
            padding: 3px 2px;
            color: #444;
        }

        .more-button {
            color: #3a3a3a !important;
            float: right;
            -o-transition: all 218ms ease-in-out;
            -moz-transition: all 218ms ease-in-out;
            -webkit-transition: all 218ms ease-in-out;
            transition: all 218ms ease-in-out;
            color: rgb(204, 204, 240);
            border-color: #42ac6e;
            box-shadow: #42ac6e 0 0 0 0 inset;
            margin: 0 16px;
            border: 2px solid #e9e9e9;
            border-radius: 2px;
            line-height: 35px;
            margin: 6px 0 16px;
        }

        .more-button:hover {
            background: #137cc1;
            color: #fff !important;
            opacity: 1 !important;
            color: rgb(204, 204, 240);
            border-color: #00a04f;
            box-shadow: #00a04f 0 0 0 70px inset;
        }

        .more-arrow {
            float: right;
            margin: 6px 0 0 10px;
            font-size: 20px;
        }

        .demo-card__16-9-media {
            /*background-image: url(img/no-image.webp);*/
            /*background-size: cover;*/
            /*background-repeat: no-repeat;*/
            /*height: 210px;*/
            /*margin-top: -36px;*/
            padding: 30px 0;
            background: #6c6c6c;
        }

        .demo-card__16-9-media i {
            color: #fff;
            font-size: 60px;
            margin: 0 auto;
            /*display: none;*/
        }

        .hl-item__deal-price {
            font-size: 15px;
            margin-top: 6px;
        }

        .hl-item del {
            color: #767676;
        }

        .hl-item del {
            color: #767676;
        }

        .hl-item__separator {
            color: #767676;
            margin-left: 10px;
            margin-right: 10px;
        }

        .clipped {
            border: 0;
            clip: rect(1px 1px 1px 1px);
            clip: rect(1px, 1px, 1px, 1px);
            height: 1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
        }

        .button-product {
            border-radius: 3px;
            border: 1px solid;
            background: linear-gradient(to bottom, #f7dfa5, #f0c14b);
            color: #000 !important;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .4) inset;
            border-color: #a88734 #9c7e31 #846a29;
            padding: 0 15px;
        }

        .button-out-of-stock {
            border-radius: 3px;
            border: 1px solid;
            background: linear-gradient(to bottom, #f1f1f1, #ff3d00);
            color: #000 !important;
            box-shadow: 0 1px 0 rgba(255, 255, 255, .4) inset;
            padding: 0 15px;
        }

    </style>

    @include('integrasafe.purchase.modules.payment_process')
    @include('integrasafe.dialogs.loading')

    <section id="products" style="width: 100%">
        <div class="integrasafe-insight-text">
            <div class="container-fluid product-container" style="max-width: 1600px;">
                <div class="mdl-grid">
                    @forelse ($product_skus as $sku)

                        <div class="mdl-cell mdl-cell--3-col">
                            <div class="mdc-card mdc-elevation--z2">
                                <section class="mdc-card__media demo-card__16-9-media">
                                    <i class="material-icons">camera_alt</i>
                                </section>
                                <section class="mdc-card__supporting-text extra-card-text hl-item">
                                    <h3>{{ $sku->name }}</h3>
                                    @if ($sku->stock === 0)
                                        <div class="product-price out-of-stock">Out of Stock</div>
                                    @else
                                        <div class="product-price">${{ $sku->price }}</div>
                                    @endif
                                    <div class="hl-item__deal-price">
                                        {{--@include('integrasafe.reviews.stars')--}}
                                    </div>
                                    <div class="subscription">
                                        @if ($sku->subscription !== false)
                                            <p>
                                                Subscription:
                                                ${{ substr($sku->subscription->amount, 0, -2).".".substr($sku->subscription->amount, 1) }}
                                                per {{ $sku->subscription->interval }}
                                            </p>
                                        @else
                                            <p>No Subscription Plan</p>
                                        @endif
                                    </div>
                                </section>
                                <section class="mdc-card__actions">
                                    @if ($sku->stock === 0)
                                        <button class="mdc-button mdc-button--compact mdc-card__action button-out-of-stock"
                                                disabled>
                                            Out of Stock
                                        </button>
                                    @else
                                        <button class="mdc-button mdc-button--compact mdc-card__action button-product"
                                                value="{{ $sku->product_sku }}" onclick="addToCart(this)">
                                            Add to cart
                                        </button>
                                    @endif
                                </section>
                            </div>
                        </div>
                    @empty
                </div>
                <div class="mdc-card mdc-elevation--z4" style="background-color: white" align="center">
                    <section class="mdc-card__primary">
                        <h1 class="mdc-card__title mdc-card__title--large">
                            No Products available yet!
                        </h1>
                    </section>
                    <section class="mdc-card__supporting-text">
                        We're hard at work making great products and services for you.
                    </section>
                    @endforelse
                </div>
            </div>
            <br>
        </div>
    </section>

    <script src="{{ asset('js/cart.js') }}" type="text/javascript" async></script>

@endsection
