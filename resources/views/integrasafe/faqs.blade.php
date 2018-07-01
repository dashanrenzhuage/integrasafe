@extends('layouts.master')
@section('title', 'IntegraSafe - FAQs')
@section('content')

    <div id="faqs-grid" class="mdc-layout-grid" style="padding-top: 120px">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-8">
                <ul class="collapsible popout collapsible-accordion" data-collapsible="accordion">
                    <li class="active" ga-on="click" ga-event-category="FAQs"
                        ga-event-action="Clicked on 'What is InSight?' Tab">
                        <div class="collapsible-header active" style="font-size: large"><i class="material-icons">help</i>
                            What is the InSight?
                        </div>
                        <div class="collapsible-body" style="display: block; font-size: large">
                        <span>
                            The InSight is a portable Air Quality Monitoring System which can be used wherever you live, work, or travel.
                        </span>
                        </div>
                    </li>
                    <li ga-on="click" ga-event-category="FAQs"
                        ga-event-action="Clicked on 'What does the InSight measure?' Tab">
                        <div class="collapsible-header" style="font-size: large"><i class="material-icons">timeline</i>
                            What does the InSight measure?
                        </div>
                        <div class="collapsible-body" style="display: none; font-size: large">
                        <span>
                            The Insight accurately measures Temperature and Humidity. Concerning thresholds for Carbon Monoxide (CO) are also detected, to keep your family safe.
                        </span>
                        </div>
                    </li>
                    <li ga-on="click" ga-event-category="FAQs" ga-event-action="Clicked on 'How is it used?' Tab">
                        <div class="collapsible-header" style="font-size: large"><i class="material-icons">announcement</i>
                            How is it used?
                        </div>
                        <div class="collapsible-body" style="display: none; font-size: large">
                        <span>
                            The base model can simply be placed on your countertop, table, or desk to monitor indoor air quality. Our Modular Add-On system allows various attachments to be used in more specific cases.
                            <br>
                            For example, the Carseat Occupancy Sensor assists with monitoring the wellbeing of an infant or young child while you travel or conduct your daily commute.
                        </span>
                        </div>
                    </li>
                    <li ga-on="click" ga-event-category="FAQs"
                        ga-event-action="Clicked on 'Who has access to my data?' Tab">
                        <div class="collapsible-header" style="font-size: large"><i class="material-icons">account_box</i>
                            Who has access to my data?
                        </div>
                        <div class="collapsible-body" style="display: none; font-size: large">
                        <span>
                            Just IntegraSafe and you! We do not share or sell device-specific data with any third parties. We work hard to ensure that our infrastructure is not only reliable, but also secure.
                        </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div id="faqs" class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
                @include('integrasafe.modules.email_signup')
            </div>
        </div>
    </div>

    <script>
		$(document).ready(function () {
			$('.collapsible').collapsible();
			document.getElementById("email").focus();
		});
    </script>

@endsection
