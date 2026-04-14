@extends('layouts.app')

@section('template-main-style')
    <link rel="stylesheet" href="{{asset('assets/cms/vendors/css/base/elisyam-1.5.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/cms/css/datatables/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/cms/css/custom.css')}}">
@endsection

@section("body-id", "page-top")
@section('page-content')
    <div class="page">
        @include('layouts.cms.header')

        <div class="page-content d-flex align-items-stretch">
            @include('layouts.cms.sidebar')

            <div class="content-inner">
                <div id="react-root" class="container-fluid"></div>

                @include('layouts.cms.footer')
            </div>
        </div>
    </div>
@endsection

@section('template-scripts')
    <script src="{{asset('assets/cms/vendors/js/nicescroll/nicescroll.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/inputmask/jquery.inputmask.min.js')}}"></script>
@endsection

@section('custom-scripts')
    @viteReactRefresh
    @vite('resources/js/admin/app/app.tsx')
@endsection
