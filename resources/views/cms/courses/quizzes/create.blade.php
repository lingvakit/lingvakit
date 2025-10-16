@extends('layouts.cms')

@section('title', __("cms-pages.new-quiz"))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item active">{{ __("cms-pages.new-quiz") }}</li>
    </ul>
@endsection
@section('content')
    <form class="form-horizontal" method="POST" action="{{ route('quizzes.store', [$course->id, $stage->id]) }}"
          enctype="multipart/form-data">
        @csrf

        <div class="row flex-row">
            <div class="col-12">
                <div class="widget has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center">
                        <h4>{{ __("cms-pages.quiz-form") }}</h4>
                    </div>
                    <div class="widget-body">

                        {{-- Quiz Category --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.category") }}</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <select id="category_select" name="category_id"
                                                class="custom-select form-control">
                                            <option value="" selected disabled>{{ __("cms-pages.category") }}</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                            <option value="0">{{ __("cms-pages.other") }}</option>
                                        </select>
                                        @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="new_category" class="col-lg-6">
                                        <input type="text" name="category" class="form-control"
                                               placeholder="{{ __("cms-pages.new-category") }}"
                                               value="{{old('category')}}" disabled>
                                        @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Quiz Title --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.title") }}<span
                                        class="text-danger ml-2">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" name="title" class="form-control"
                                       placeholder="{{ __("cms-pages.title") }}" value="{{old('title')}}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Quiz Description--}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.description") }}</label>
                            <div class="col-lg-9">
                                <textarea id="description" name="description" class="form-control" rows="3"
                                          placeholder="{{ __("cms-pages.description") }}">{{old('description')}}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Quiz Image --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.main-image") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    <div class="current-item">
                                        <img src="{{asset('assets/cms/img/no-image.jpg')}}" width="100" alt>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="image"
                                        data-var="image" data-toggle="modal" data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                            </div>
                        </div>
                        {{-- Quiz Audio --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.audio") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview"></div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="audio"
                                        data-var="audio" data-toggle="modal" data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                            </div>
                        </div>
                        {{-- Quiz Video --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.video") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview"></div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="video"
                                        data-var="video" data-toggle="modal" data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                                <input type="text" name="youtube" class="form-control"
                                       placeholder="{{ __("cms-pages.video-link") }}" value="{{old('video')}}">
                            </div>
                        </div>
                        {{-- Quiz Duration --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.quiz-duration") }}
                                , {{ __("min") }}</label>
                            <div class="col-lg-9">
                                <input type="number" name="duration" class="form-control" placeholder="10" value="10">
                                @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Quiz Passing Score --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.passing-score") }}, %</label>
                            <div class="col-lg-9">
                                <input type="number" name="passing_score" class="form-control" placeholder="80"
                                       value="80">
                                @error('passing_score')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Quiz Required Topics Must Be Passed --}}
                        <div class="form-group row mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.required-topics") }}</label>
                            <div class="col-lg-9 select">
                                <select name="passed_topics[]" multiple class="custom-select form-control">
                                    @foreach($course->stages as $key => $stage)
                                        @foreach($stage->topics as $topicKey => $topic)
                                            <option value="{{$topic->id}}">
                                                @if($topic->name === 'quiz' && $topic->quiz)
                                                    {{($key+1).'.'.($topicKey+1).'. '.$topic->quiz->title}}
                                                @elseif($topic->name === 'lesson' && $topic->lesson)
                                                    {{($key+1).'.'.($topicKey+1).'. '.$topic->lesson->title}}
                                                @endif
                                            </option>
                                        @endforeach
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.cms.template-parts.form-buttons')
    </form>
@endsection
@section('modal')
    @include('layouts.cms.template-parts.modals.upload-and-choose-files')
@endsection
@section('page-scripts')
    @include('layouts.cms.template-parts.scripts-forms')
    <script src="{{asset('assets/cms/vendors/js/ckeditor/ckeditor.js')}}"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace('description', {
                filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
    <script src="{{asset('assets/cms/js/youtube.min.js')}}"></script>
    <script src="{{asset('assets/cms/js/ajax-store.js')}}"></script>
@endsection
