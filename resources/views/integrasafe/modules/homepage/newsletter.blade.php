<section id="newsletter">
    <div class="integrasafe-newsletter-section">
        <div class="integrasafe-newsletter">
            <div class="container integrasafe-newsletter-text">
                <div class="mdl-typography--display-2 mdl-typography--font-thin">Sign up to our Newsletter!</div>
                <p class="mdl-typography--headline mdl-typography--font-thin">
                    Never miss an update and subscribe to receive product information, software updates,
                    updated company information, and more!
                </p>
                <form id="newsletter-form" action="{{ url('/newsletter') }}" method="post">
                    <div class="input-field inline">
                        <input id="email" name="email" type="email" class="validate" ga-on="click"
                               ga-event-category="Newsletter"
                               ga-event-action="Clicked into Email field">
                        <label for="email">Email Address</label>
                    </div>
                    <input type="checkbox" id="newsletter-interest" style="display: none" checked>
                    <button id="newsletter-submit" role="button" class="action-button" ga-on="click" type="submit"
                            ga-event-category="Newsletter" ga-event-action="Submit"
                            onclick="FB.AppEvents.logEvent('Signed up for Newsletter')">
                        Submit
                    </button>
                </form>
                <div id="newsletter-error" class="error">
                    Email Address is required!
                </div>
                <div id="newsletter-success" class="success"></div>
            </div>
        </div>
    </div>
</section>
