@extends('template')

@section('content')
    <section class="bg-light py-3 py-md-5 py-xl-8">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-7 col-xxl-6">
                    <h2 class="mb-4 display-5 text-center">{{ __("Welcome to the Users Administration Tool") }}</h2>
                    <p class="text-secondary mb-5 text-center lead fs-4">{{ __("My name is Konstantinos and this is my attempt at building a users administration tool") }}</p>
                    <hr class="w-50 mx-auto mb-5 mb-xl-9 border-dark-subtle">
                </div>
            </div>
        </div>
    </section>
@stop
