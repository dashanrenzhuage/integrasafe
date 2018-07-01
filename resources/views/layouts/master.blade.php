<!DOCTYPE html>
<html lang="en">

    @include('layouts._header')

    <body id="master_nav" class="pushable">

        @include('layouts.navigation.navbar')

        <main id="main-content">

            <div class="main-content">
                <div class="row" id="sticky_grid">
                    @yield('content')
                </div>
            </div>

            @include('layouts.footer')
        </main>

        <script>
            // Initialize Material Design's library for use
            window.mdc.autoInit();
            document.getElementById("master_nav").style.overflowY = "auto";
        </script>

    </body>
</html>
