@extends('layouts.master')
@section('title', 'IntegraSafe')
@section('content')

    @include('integrasafe.purchase.modules.payment_process')

    <div class="mdc-card demo-card">
        <section class="mdc-card__primary">
            <h1 class="mdc-card__title mdc-card__title--large"><font color="lime">Success!</font></h1>
            <h2 class="mdc-card__subtitle">Your order has been placed.</h2>
        </section>
        <section class="mdc-card__supporting-text">
            We have sent you an email confirming your purchase. If you have any questions, please feel free to contact
            us.
        </section>
        <section class="mdc-card__actions">
            <button class="mdc-button mdc-button--compact mdc-card__action">Action 1</button>
            <button class="mdc-button mdc-button--compact mdc-card__action">Action 2</button>
        </section>
    </div>

@endsection
