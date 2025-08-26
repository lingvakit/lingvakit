@extends('layouts.site')

@section('seo-title', 'ЛИНГВАКИТ - школа китайского языка')
@section('seo-description', 'Изучение иностранных языков')
@section('page-styles')
    <link rel="stylesheet" href="{{asset('assets/cms/css/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/cms/css/owl-carousel/owl.theme.min.css')}}">
@endsection
@section('title', __("site-pages.all-courses"))
@section('content')

    <div class="row flex-row">
        @foreach($courses as $course)
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                <div class="widget widget-12 has-shadow">
                    <div class="widget-body">
                        <div class="tile-image-container">
                            <img src="{{$course->getImage()}}" alt="{{$course->title}}" style="width: 100%">
                        </div>
                        <div class="infos">
                            <div class="about-infos d-flex flex-column mt-3">
                                <div class="about-infos">{!! $course->getReleaseDate() !!}</div>
                            </div>
                            <div class="about-infos d-flex flex-column mt-3">
                                <div class="about-infos">{{ __("Teacher: ") . $course->author->getFullName() }}</div>
                            </div>
                            <div class="about-infos d-flex flex-column mt-3">
                                <div class="about-title"><a
                                            href="{{ route('site.course-show', $course->id) }}">{{ $course->title }}</a>
                                </div>
                            </div>
                            <div class="about-infos d-flex flex-column mt-3">
                                <div class="about-title">
                                    <h3>{!! $course->getPrice() !!}</h3>
                                </div>
                            </div>
                            <div class="about-infos d-flex flex-column mt-3">
                                {!! $course->getActiveButton() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
@section('page-scripts')
    <script src="{{asset('assets/cms/vendors/js/chart/chart.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/calendar/moment.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/calendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/cms/js/dashboard/db-default.js')}}"></script>
@endsection
