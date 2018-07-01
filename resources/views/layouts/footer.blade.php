<section id="footer">
    <script type="text/javascript">
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.9";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <footer class="mdl-mega-footer footerTheme">
        <div class="mdl-mega-footer__middle-section">

            <div class="mdl-mega-footer__drop-down-section" itemscope itemtype="http://schema.org/LocalBusiness">
                <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                <h1 class="mdl-mega-footer__heading">Contact Us</h1>
                <ul class="mdl-mega-footer__link-list">
                    <li>
                        <span itemprop="name">Integrasafe, Inc.</span><br>
                        <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"></span>
                        <span itemprop="addressLocality">Evansville,</span>
                        <span itemprop="addressRegion">Indiana</span>
                        <span itemprop="postalCode">47715</span><br>
                        <span itemprop="telephone"><a href="tel:+18122205072">(812) 220-5072</a></span> (M-F 8AM-5PM CST)<br>
                        <a href="mailto:support@integrasafe.net" target="_top" itemprop="email">
                            Email: support@integrasafe.net</a>
                        <a href="https://integrasafe.net" itemprop="url"
                           style="display: none">https://integrasafe.net</a>
                    </li>
                </ul>
            </div>

            <div class="mdl-mega-footer__drop-down-section">
                <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                <h1 class="mdl-mega-footer__heading">Resources</h1>
                <ul class="mdl-mega-footer__link-list">
                    <li>
                        <a href="{{ url('/faqs') }}">FAQs</a>
                    </li>
                    <li>
                        {{--<a href="https://careers.smartrecruiters.com/IntegraSafeInc">Careers</a>--}}
                        <a href="{{ url('/careers') }}">Careers</a>
                    </li>
                </ul>
            </div>

            <div class="mdl-mega-footer__drop-down-section">
                <input class="mdl-mega-footer__heading-checkbox" type="checkbox" checked>
                <h1 class="mdl-mega-footer__heading">Payment Methods</h1>
                <ul class="mdl-mega-footer__link-list">
                    <li>
                        <dd class="p-icon">Visa, Mastercard, American Express, Discover</dd>
                    </li>
                </ul>
            </div>
        </div>

        <div class="mdl-mega-footer__bottom-section">
            <div class="mdl-logo">IntegraSafe, Inc.</div>
            <ul class="mdl-mega-footer__link-list">
                <li>© 2017 - <?php echo date('Y'); ?></li>
                <li>
                    <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
                </li>
                <li>
                    <a href="{{ url('/terms-of-service') }}">Terms of Service</a>
                </li>
            </ul>
        </div>
    </footer>
</section>
