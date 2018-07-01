<div id="temporary-card" class="card container section" style="height: auto; width: auto">

    {{-- BETA TESTER --}}
    <div class="card-content">
        <span class="card-title">Interested in being a Beta Tester?</span>
        We're looking for direct user feedback to help refine our interface.
        <br><br>
        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="newsletter-interest">
            <input type="checkbox" id="beta-interest" name="beta-check"
                   ga-on="click" ga-event-category="Temporary Page" ga-event-action="Clicked on Beta Tester checkbox"/>
            <label for="beta-interest">I'm Interested</label>
        </label>
    </div>

    {{-- NEWSLETTER --}}
    <div class="card-content">
        <span class="card-title">Want More Information?</span>
        Receive company and product updates.
        <br><br>
        <label class="mdl-checkbox mdl-js-checkbox mdl-js-ripple-effect" for="newsletter-interest">
            <input type="checkbox" id="newsletter-interest" name="newsletter-check" checked="checked"
                   ga-on="click" ga-event-category="Temporary Page" ga-event-action="Clicked on Newsletter checkbox"/>
            <label for="newsletter-interest">I'm Interested</label>
        </label>
    </div>

    <hr>

    <div class="card-content">
        <form id="newsletter-form" action="{{ url('/newsletter') }}" method="post">
            <div class="mdc-layout-grid">
                <div class="mdc-layout-grid__inner">
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                        <div class="input-field">
                            <i class="material-icons prefix">email</i>
                            <input id="email" name="email" type="email" class="validate" ga-on="click"
                                   ga-event-category="Temporary Newsletter"
                                   ga-event-action="Clicked into Email field" autofocus>
                            <label for="email">Email Address</label>
                        </div>
                        <div id="newsletter-loading" class=""></div>
                    </div>
                    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                        <a id="newsletter-submit" role="button" class="action-button pulse" ga-on="click" type="submit"
                           ga-event-category="Temporary Newsletter or Tester Form" ga-event-action="Submit"
                           onclick="FB.AppEvents.logEvent('Signed up for Newsletter or Tester')">
                            Submit
                        </a>
                        <div id="newsletter-error" class="error">Email Address is required!</div>
                        <div id="newsletter-success" class="success"></div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
<script src="{{ asset('js/newsletter.js') }}" type="text/javascript" async></script>
