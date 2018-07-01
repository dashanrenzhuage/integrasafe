@extends('layouts.master')
@section('title', 'IntegraSafe')
@section('content')

    <style>

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

        .field {
            background: transparent;
            font-weight: 300;
            border: 0;
            color: black;
            outline: none;
            cursor: text;
            display: block;
            width: 100%;
            line-height: 32px;
            padding-bottom: 3px;
            transition: opacity 200ms ease-in-out;
        }

        .field::-webkit-input-placeholder {
            color: #8898AA;
        }

        .field::-moz-placeholder {
            color: #8898AA;
        }

        /* IE doesn't show placeholders when empty+focused */
        .field:-ms-input-placeholder {
            color: #424770;
        }

        .field.is-empty:not(.is-focused) {
            opacity: 0;
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

        .outcome {
            float: left;
            width: 100%;
            padding-top: 8px;
            min-height: 20px;
            text-align: center;
        }

        .success, .error {
            display: none;
            font-size: 15px;
        }

        .success.visible, .error.visible {
            display: inline;
        }

        .error {
            color: #E4584C;
        }

        .success {
            color: #34D08C;
        }

        .success .token {
            font-weight: 500;
            font-size: 15px;
        }
    </style>

    <form id="product-form" action="{{ url('/create/product') }}" method="post">
        {{ csrf_field() }}
        <div class="demo-grid mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                {{-- Payment Information --}}
                <div class="demo-cell mdc-layout-grid__cell mdc-layout-grid__cell--span-7">

                    <h3>Product Information</h3>

                    <label>
                        <input name="name" required/>
                        <span><span>Product Name</span></span>
                    </label>

                    <label>
                        <input name="caption" required/>
                        <span><span>Product Caption</span></span>
                    </label>

                    <label>
                        <input name="description" required/>
                        <span><span>Product Description</span></span>
                    </label>

                    <label>
                        <input name="price" required/>
                        <span><span>Product Price</span></span>
                    </label>

                    <label>
                        <input name="inventory" required/>
                        <span><span>Product Inventory</span></span>
                    </label>
                    {{-- Price and Purchase --}}
                    <div class="mdc-card demo-card">
                        <section class="mdc-card__actions">
                            <button id="submit-form" type="submit" class="submit-button">Create</button>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
