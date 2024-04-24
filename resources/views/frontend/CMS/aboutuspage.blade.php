@extends('frontend.layouts.app')
@section('content')
<!-- Start Banner Area -->
<section class="banner-area organic-breadcrumb">
    <div class="container">
        <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
            <div class="col-first">
                <h1>{{ $AboutUs->title }}</h1>
            </div>
        </div>
    </div>
</section>
<!-- End Banner Area -->

<!-- Start Content Area -->

<section class="about-sec py-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <p>
                    {!! $AboutUs->content !!}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- End Content Area -->

@endsection