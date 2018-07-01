<aside id="payment-dialog"
       class="mdc-dialog"
       role="alertdialog"
       aria-hidden="true"
       aria-labelledby="mdc-dialog-default-label"
       aria-describedby="mdc-dialog-default-description">
    <div class="mdc-dialog__surface">

        {{-- Header Text --}}
        <header class="mdc-dialog__header">
            <h2 id="progress-dialog-header" class="mdc-dialog__header__title"></h2>
        </header>

        <section id="dialog-body" class="mdc-dialog__body">
            {{-- Progress Bar --}}
            <div id="progressbar" role="progressbar" class="mdc-linear-progress mdc-linear-progress--indeterminate">
                <div class="mdc-linear-progress__buffering-dots"></div>
                <div class="mdc-linear-progress__buffer"></div>
                <div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar">
                    <span class="mdc-linear-progress__bar-inner"></span>
                </div>
                <div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar">
                    <span class="mdc-linear-progress__bar-inner"></span>
                </div>
            </div>

            {{-- Added Item --}}
            @if(Route::current()->getName() !== 'integrasafe:payment[get]' || Route::current()->getName() !== 'integrasafe:review[get]')
                <div id="added-sku" style="width: auto;">
                    @include('integrasafe.dialogs.modules.selected')
                </div>

        </section>

        {{-- Available Buttons --}}
        <footer id="dialog-buttons" class="mdc-dialog__footer">
            @include('integrasafe.dialogs.modules.footer')
        </footer>

        @else
        </section>
        @endif
    </div>
    <div class="mdc-dialog__backdrop"></div>
</aside>
