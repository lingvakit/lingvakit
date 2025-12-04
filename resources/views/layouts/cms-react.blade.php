@extends('layouts.app')

@section('template-main-style')
    <link rel="stylesheet" href="{{asset('assets/cms/vendors/css/base/elisyam-1.5.min.css')}}">
@endsection
@section('template-styles')
    @yield('page-styles')
    <link rel="stylesheet" href="{{asset('assets/cms/css/custom.css')}}">
@endsection

@section("body-id", "page-top")
@section('page-content')
    <div class="page">
        <!-- Begin PageHeader -->
        @include('layouts.cms.header')

        <!-- Begin Page Content -->
        <div class="page-content d-flex align-items-stretch">
            <!-- Begin Left Sidebar -->
            @include('layouts.cms.sidebar')

            <div id="app-admin-content" class="content-inner"></div>
            @vite('resources/js/admin/main.jsx')

            {{-- TODO: Clear comments --}}
{{--            <!-- Begin Content -->--}}
{{--            <div class="content-inner">--}}
{{--                <!-- Begin Page Content -->--}}
{{--                <div class="container-fluid">--}}
{{--                    @include('layouts.cms.template-parts.page-header')--}}
{{--                    @yield('content')--}}
{{--                </div>--}}

{{--                <!-- Begin Page Footer-->--}}
{{--                @include('layouts.cms.footer')--}}
{{--            </div>--}}

            <!-- Begin Centered Modal -->
            @yield('modal')
        </div>
    </div>
@endsection

@section('template-scripts')
    <script src="{{asset('assets/cms/vendors/js/nicescroll/nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/inputmask/jquery.inputmask.min.js')}}"></script>
    @yield('page-scripts')
@endsection
@section('custom-scripts')
        <script src="{{asset('assets/cms/js/custom.min.js')}}"></script>
        <script src="{{asset('assets/cms/js/search-media.min.js')}}"></script>
@endsection
