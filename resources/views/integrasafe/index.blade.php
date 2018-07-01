@extends('layouts.master')
@section('title', 'IntegraSafe')
@section('content')

    {{-- Introduction to company --}}
    @include('integrasafe.modules.homepage.intro')
    {{-- inSight Section --}}
    @include('integrasafe.modules.homepage.products')
    {{-- Company newsletter form --}}
    @include('integrasafe.modules.homepage.newsletter')
    {{-- Company and product timelines --}}
    @include('integrasafe.modules.homepage.timeline')
    {{-- Company and product statistics --}}
    {{--@include('integrasafe.modules.statistics')--}}
    {{-- Download apps NOT READY --}}
    {{--@include('integrasafe.modules.apps')--}}

    @include('integrasafe.hiring.posting1')


    <script>
		$(document).ready(function(){
			$('.carousel.carousel-slider').carousel({fullWidth: true});
		});
    </script>

@endsection
