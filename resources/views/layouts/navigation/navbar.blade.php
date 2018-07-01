<header class="mdc-toolbar mdc-toolbar--fixed mdc-toolbar--fixed-lastrow-only mdc-toolbar--waterfall mdc-toolbar--flexible
            mdc-toolbar--flexible-default-behavior mdc-toolbar--flexible-space-maximized" style="transform: translateY(0px);">
    <div class="mdc-toolbar__row demo-toolbar__row--with-image" style="height: auto;">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start container blue-gradient">
            <div class="mdc-toolbar__title">
                <img height="125" src="{{ asset('img/integrasafe-logo-enchanted-horizontal.png') }}">
            </div>
        </section>
    </div>
    <div class="mdc-toolbar__row mdc-elevation--z5 toolbar-main">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start" role="toolbar">
            <a href="#" class="material-icons mdc-toolbar__menu-icon toolbar-links">menu</a>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end">
            <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
               href="{{ url('/') }}">Home</a>

            @if (Auth::check())
                <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
                   href="{{ url('/profile/'.Auth::user) }}">My Profile</a>
            @else
                <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
                href="{{ url('/signin') }}">Sign in</a>
            @endif

            <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
               href="{{ url('/purchase') }}">Purchase</a>
            <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links" href="{{ url('/faqs') }}">FAQs</a>

            @if (Auth::check())
                <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
                   href="{{ url('/logout') }}">Logout</a>
            @endif

            <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
               href="{{ url('/purchase/payment') }}">Cart</a>
            <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
               href="{{ url('/product') }}">Our Product</a>
            <a class="mdc-toolbar__icon mdc-ripple-upgraded--unbounded mdc-ripple-upgraded toolbar-links"
            href="{{ url('/productdetail') }}">Product Detail</a>
        </section>
    </div>
</header>
<script>
	$(document).ready(function() {
		var toolbarEl = document.querySelector('.mdc-toolbar');
		var toolbar = mdc.toolbar.MDCToolbar.attachTo(toolbarEl);
		toolbar.fixedAdjustElement = document.querySelector('.mdc-toolbar-fixed-adjust');
	});
</script>
