@extends('layouts.master')
@section('title', __('messages.policy.privacy-policy'))
@section('content')

    <link href="{{ URL::asset('css/source/documents.css') }}" type="text/css" rel="stylesheet"/>
    <section class="pad-div paper section" style="padding-top: 125px">
        <div class="row">
            <div class="col-sm-4">
                <ul class="privacy-links">
                    <li id="#app">Privacy Policy</li>
                    <li><a href="#infocollect">What information we collect</a></li>
                    <li><a href="#howcollect">How we use information we collect</a></li>
                    <li><a href="#share">Information you share</a></li>
                    <li><a href="#accessing">Accessing and updating your personal information</a></li>
                    <li><a href="#sharinginformation">Information we share</a></li>
                    <li><a href="#security">Information security and integrity</a></li>
                    <li><a href="#policyapplies">This Privacy Policy applies when</a></li>
                    <li><a href="#compliance">Compliance and cooperation with regulatory authorities</a></li>
                    <li><a href="#changes">Privacy Policy Changes</a></li>
                </ul>
            </div>
            <div class="col-sm-8">
                <div class="paper-content">
                    <h1>Welcome to our Privacy Policy</h1>
                    <p>This privacy policy (“Privacy Policy”) is meant to help you understand what information we
                        collect, why we collect it, and what we do with it at Eagle Eye Monitoring Inc. (“Eagle Eye
                        Monitoring”). When you use our Products and Services, you trust us with your information. We
                        want to be transparent, so we hope you take the time to read it carefully.</p>
                    <p><i>Last modified: March 7th, 2018</i></p>
                    <p>There are different ways our Products and Services can be used, and we want you to be clear how
                        your information is processed</p>
                    <p>If you’re not familiar with terms like, <a href="browsers">browsers</a>, <a
                                href="cookies">cookies</a>, <a href="IP addresses">IP addresses</a>, <a
                                href="local storage">local storage</a>, <a href="pixaltags">pixel tags</a>, <a
                                href="web beacons">web beacons</a>, <a href="UDI">UDI</a>, <a href="information cache">data
                            cache</a>, <a href="information">information</a> then it may be easier to read about the key
                        terms before continuing. There are choices that we offer which include how to access and update
                        information. If you have any questions regarding this document, feel free to <a
                                href="{{ url('experience-feedback') }}">contact us.</a></p>
                    <p>This Privacy Policy explains:</p>
                    <ul>
                        <li>What information we collect</li>
                        <li>Why we collect it.</li>
                        <li>How we use that information.</li>
                    </ul>


                    <h2 id="infocollect">What data we collect <a href="#app">Back to top</a></h2>
                    <p>We collect data to provide better Products and Services to all of our users - from figuring out
                        basic stuff like which language you speak, to more complex things like what items you find the
                        most useful, or understanding what content matters to you most.</p>
                    <p>There are several ways we collect information.</p>
                    <ul>
                        <li>
                            <p><strong>Information you provide to us.</strong> Our Products or Services may require you
                                to create an Eagle Eye Monitoring account. We may ask for personal information like your
                                credit card, company information, email address, name, or even a telephone number to
                                store with your account.</p>
                        </li>
                        <li>
                            <p><strong>• Information we get when you use our Products or Services</strong> We collect
                                data about the Products and Services that you use and how you use them, like the time of
                                day, or even when you interact with content. This information may include:</p>
                            <ul>
                                <li>
                                    <p><strong>Device</strong></p>
                                    <p>We collect device-specific information (such as your hardware model, OS version,
                                        phone number, screen size, touch screen capabilities and unique device
                                        identifiers).</p>
                                </li>
                                <li>
                                    <p><strong>Log</strong></p>
                                    <p>We automatically collect and store certain information. This can include:</p>
                                    <ul>
                                        <li><p>details of actions performed within our Products or Services</p></li>
                                        <li><p>telephony information like, number, forwarding numbers, date and time,
                                                duration, SMS routing information, and types.</p></li>
                                        <li><p>event information such as browser type, crashes, hardware settings,
                                                system activity, referral URL, and requests.</p></li>
                                        <li><p>cookies that may uniquely identify your browser or account.</p></li>
                                    </ul>
                                </li>
                                <li>
                                    <p><strong>Location</strong></p>
                                    <p>We use various technologies to determine location, including altitude, GPS,
                                        pressure, temperature, IP address, and other sensors that may, for example
                                        provide information on nearby devices, with wireless technology. We may collect
                                        and process this information.</p>
                                </li>

                                <li>
                                    <p><strong>UA numbers</strong></p>
                                    <p>Some Products and Services include a unique application number. This number and
                                        information about your installation (for example, application version number)
                                        may be collected when you install, update, or uninstall that service.</p>
                                </li>
                                <li>
                                    <p><strong>Local storage</strong></p>
                                    <p>We collect and store information locally on your device using web storages and
                                        information caches.</p>
                                </li>
                                <li>
                                    <p><strong>Cookies and similar technologies</strong></p>
                                    <p>We use cookies or similar technologies to identify, to collect, and store
                                        information when you interact with our Products and Services.</p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p>The data we collect, in addition to information we obtain from partners, may be associated with
                        your account. When information can be identified to your account, we treat it as personal
                        information.</p>


                    <h2 id="howcollect">How we use information we collect <a href="#app">Back to top</a></h2>
                    <p>We use information we collect to develop new ones, provide, protect, improve, and maintain, them.
                        We also use this information to offer you tailored content – like giving you more relevant
                        content and ads.</p>
                    <p>Across all of the Products and Services we offer, we may use the information you provide that
                        require an account so that you are represented consistently across all our Products and
                        Services.</p>
                    <p>If you have an account, we may display your information and actions you take (example: comments
                        and reviews you post) in our Products or Services, including displaying in ads and other
                        commercial contexts.</p>
                    <p>When reach out to communicate with us, to help solve any issues you might be facing, we may use
                        information to inform you about our Products or Services, such as letting you know about
                        upcoming changes or improvements.</p>
                    <p>We may combine information and activities on other apps, sites, and Products or Services, that
                        may be associated with your personal information in order to improve our Products and
                        Services.</p>
                    <p>We will ask for your consent before using information for a purpose other than those that are set
                        out in this Privacy Policy.</p>
                    <p>We may process your personal information on one of our many servers located worldwide, this may
                        include outside the country where you live.</p>

                    <h2 id="share">Information you share <a href="#app">Back to top</a></h2>
                    <p>Many of our Products and Services let you share information with others.</p>


                    <h2 id="accessing">Accessing and updating your personal information <a href="#app">Back to top</a>
                    </h2>
                    <p>Whenever you use our Products and Services, give you ways to update or delete it – unless we have
                        to keep that information for legitimate business or legal purposes. We may ask you to verify
                        your identity when updating your personal information.</p>

                    <p>We may reject requests that are unreasonably repetitive, require disproportionate technical
                        effort (for example, developing a new system or fundamentally changing an existing practice),
                        risk the privacy of others, or would be extremely impractical (for instance, requests concerning
                        information residing on backup systems).</p>
                    <p>Where we can provide information access and correction, we will do so for free, except where it
                        would require a disproportionate effort. We aim to maintain our Products and Services in a
                        manner that protects information from accidental or malicious destruction. Because of this,
                        after you delete information from our Products and Services, we may not immediately delete
                        residual copies from our active servers and may not remove information from our backup
                        systems.</p>

                    <h2 id="sharinginformation">Information we share <a href="#app">Back to top</a></h2>

                    <p>We do not share personal information with companies, organizations, and individuals outside of
                        Eagle Eye Monitoring unless:</p>

                    <ul>
                        <li>
                            <p><strong>Consent</strong></p>
                            <p>We do not share personal information with companies, organizations, and individuals
                                outside of Eagle Eye Monitoring unless:</p>
                        </li>
                        <li>
                            <p><strong>Processing</strong></p>
                            <p>We provide personal information to our affiliates or other trusted businesses or persons
                                to process it for us, based on our instructions and in compliance with our Privacy
                                Policy and any other appropriate confidentiality and security measures.</p>
                        </li>
                        <li>
                            <p><strong>Legal</strong></p>
                            <p>We will share personal information with companies, organizations or individuals if we
                                have a good-faith belief that access, use, preservation or disclosure of the information
                                is reasonably necessary to:</p>
                            <ul>
                                <li>
                                    <p>meet any applicable law, regulation, legal process or enforceable governmental
                                        request.</p>
                                </li>
                                <li>
                                    <p>enforce applicable Terms of Service, including investigation of potential
                                        violations.</p>
                                </li>
                                <li>
                                    <p>detect, prevent, or otherwise address fraud, security or technical issues.</p>
                                </li>
                                <li>
                                    <p>protect against harm to the rights, property or safety of Eagle Eye Monitoring
                                        our users or the public as required or permitted by law.</p>
                                </li>
                            </ul>
                        </li>
                    </ul>
                    <p>We may share non-personally identifiable information publicly and with our partners. For example,
                        we may share information publicly to show trends about the general use of our Products and
                        Services.</p>
                    <p>If Eagle Eye Monitoring is involved in a merger, acquisition or asset sale, we will continue to
                        ensure the confidentiality of any personal information and give affected users notice before
                        personal information is transferred or becomes subject to a different Privacy Policy.</p>

                    <h2 id="security">Information security and integrity <a href="#app">Back to top</a></h2>
                    <p>We protect our users from unauthorized access to or unauthorized alteration, disclosure or
                        destruction of information we hold:</p>
                    <ul>
                        <li>
                            <p>We encrypt many of our Products and Services using advance hashing, SSL, and similar
                                technologies.</p>
                        </li>
                        <li>
                            <p>We review our information collection, storage and processing practices, including
                                physical and virtual security measures, to guard against unauthorized access to our
                                systems.</p>
                        </li>
                        <li>
                            <p>We restrict access to personal information to employees, contractors and agents who need
                                to know that information in order to process it for us, and who are subject to strict
                                contractual confidentiality obligations and may be disciplined or terminated if they
                                fail to meet these obligations.</p>
                        </li>
                    </ul>

                    <h2 id="policyapplies">This Privacy Policy applies when <a href="#app">Back to top</a></h2>
                    <p>Our Privacy Policy applies to all of the Products and Services offered by Eagle Eye Monitoring
                        but excludes Products and Services that have separate privacy policies that do not incorporate
                        this Privacy Policy.</p>
                    <p>Our Privacy Policy does not apply to Products and Services offered by other companies or
                        individuals. Our Privacy Policy does not cover the information practices of other companies and
                        organizations who advertise our Products and Services and other technologies.</p>


                    <h2 id="compliance">Compliance and cooperation with regulatory authorities <a href="#app">Back to
                            top</a></h2>
                    <p>When we receive formal written complaints, we will follow up. We work with the appropriate
                        regulatory authorities, including local information protection authorities, to resolve any
                        complaints regarding the transfer of personal information that cannot be resolved with users
                        directly.</p>


                    <h2 id="changes">Privacy Policy Changes <a href="#app">Back to top</a></h2>
                    <p>Our Privacy Policy may change from time to time. We will not reduce your rights under this
                        Privacy Policy without your explicit consent. We will post any Privacy Policy changes on this
                        page and, if the changes are significant, we will provide a more prominent notice (including,
                        for certain Products and Services, email notification of Privacy Policy changes).</p>

                    <p>Thank you for using our products (“Products”) and services (“Services”). The Products and
                        Services are provided by Eagle Eye Monitoring Inc. (“Eagle Eye Monitoring”), located at 5500 Oak
                        Hill Road, Evansville, Indiana 47711, United States</p>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/source/smoothScrollHighlight.min.js') }}" async></script>
    <script src="{{ asset('js/source/smooth_scroll.min.js') }}" async></script>

@endsection

