<div class="mdl-layout__drawer">
    <span class="mdl-layout-title">Navigation
        <button id="drawer-close" class="mdl-button mdl-js-button mdl-button--icon mdl-button--colored">
          <i class="material-icons">clear</i>
        </button>
    </span>
    <nav class="mdl-navigation">

        {{-- EEMINC --}}
        @if (Auth::check() && (Session::get('renderer')->domain === 'eeminc'))
            <a class="mdl-menu__item" href="{{ url('/') }}">Home</a>

            {{-- Account details for VMI, Profile details for PCB --}}
            @if (!Auth::user()->hasRole('manager') || !Auth::user()->hasRole('admin') || !Auth::user()->hasRole('super'))
                <a class="mdl-navigation__link " href="{{ url('/create/business') }}">Create a Business Account</a>
            @elseif (Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))
                <a class="mdl-navigation__link " href="{{ url('/account/'.Auth::user()->account_id) }}">VMI Account
                    details</a>
            @elseif (Auth::user()->hasRole('user'))
                <a class="mdl-navigation__link " href="{{ url('/profile/'.Auth::user()->id) }}">My Profile</a>
            @endif

            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider"
               href="{{ url('settings') }}">Settings</a>

            {{-- Main Tab Buttons --}}
            <a class="mdl-navigation__link " href="{{ url('/machine') }}">Machines</a>
            <a class="mdl-navigation__link " href="{{ url('/stock') }}">Warehouse Stock</a>

            <a class="mdl-navigation__link " href="{{ url('/product') }}">Product List</a>
            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider"
               href="{{ url('/route') }}">Routes</a>

            @if (Auth::user()->hasRole('super'))
                <a class="mdl-navigation__link " href="{{ url('/collector') }}">Bills</a>
            @endif

            {{-- Sales Menu Items --}}
            <a class="mdl-navigation__link" href="{{ url('/sales/create') }}">Create Sales</a>
            <a class="mdl-navigation__link" href="{{ url('/sales') }}">Sales Log</a>
            <a class="mdl-navigation__link" href="{{ url('/sales/inventory') }}">Per-Product</a>
            <a class="mdl-navigation__link" href="{{ url('/sales/inventory_machine') }}">Per-Machine</a>
            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider"
               href="{{ url('/sales/daily_totals') }}">Daily Totals</a>

            {{-- Reports Menu Items--}}
            <a class="mdl-navigation__link" href="{{ url('/report/expiry') }}">Expired Machines</a>
            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider"
               href="{{ url('/report/stock') }}">Shopping List</a>

            {{-- Admin Items --}}
            @if (Auth::check() && Auth::user()->hasRole('admin'))
                <a class="mdl-navigation__link" href="{{ url('/admin/accounts') }}">Global Business Accounts </a>
                <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider"
                   href="{{ url('/admin/machine/pending') }}">Pending machines</a>
            @endif

            <a class="mdl-menu__item" href="{{ url('logout') }}">Logout</a>

            {{-- CUSTOM PCB --}}
        @elseif (Session::get('renderer')->domain === 'custompcb')
            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider" href="{{ url('/') }}">Home</a>
            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider"
               href="{{ url('order-online') }}">Buy PrototypePCB</a>
            <a class="mdl-navigation__link" href="{{ url('feedback') }}">Feedback</a>
            <a class="mdl-navigation__link" href="{{ url('subscribe') }}">Subscribe</a>
            <a class="mdl-navigation__link" role="button" data-toggle="modal" data-target="#contactModal">Contact Us</a>

            {{-- INTEGRASAFE --}}
        @elseif (Session::get('renderer')->domain === 'integrasafe')
            <a class="mdl-navigation__link" href="{{ url('/') }}" ga-on="click" ga-event-category="Navbar Drawer"
               ga-event-action="Home link">Home</a>

            @if (!Auth::check())
                <a class="mdl-navigation__link" href="{{ url('/signin') }}" ga-on="click"
                   ga-event-category="Navbar Drawer"
                   ga-event-action="Sign in link">Sign in</a>
            @endif

            <a class="mdl-navigation__link" href="{{ url('/purchase') }}" ga-on="click"
               ga-event-category="Navbar Drawer"
               ga-event-action="Purchase link">Purchase</a>
            <a class="mdl-navigation__link" href="{{ url('/faqs') }}" ga-on="click" ga-event-category="Navbar Drawer"
               ga-event-action="FAQs link">FAQs</a>

            @if (Auth::check())
                <a class="mdl-navigation__link" href="{{ url('/logout') }}" ga-on="click"
                   ga-event-category="Navbar Drawer"
                   ga-event-action="Logout link">Logout</a>
            @endif

            {{-- OTHER --}}
        @else
            <a class="mdl-navigation__link mdl-navigation__link--full-bleed-divider" href="{{ url('/') }}">Home</a>
            <a class="mdl-navigation__link" href="{{ url('/feedback') }}" ga-on="click"
               ga-event-category="Navbar Drawer"
               ga-event-action="Feedback link">Feedback</a>
            <a class="mdl-navigation__link" role="button" data-toggle="modal" data-target="#contactModal" ga-on="click"
               ga-event-category="Navbar Drawer" ga-event-action="Contact Us link">Contact Us</a>
        @endif
    </nav>
</div>
