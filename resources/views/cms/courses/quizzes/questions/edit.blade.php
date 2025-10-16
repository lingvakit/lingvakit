@extends('layouts.cms')

@section('title', __("cms-pages.edit-question"))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('quizzes.show', [$course->id, $stage->id, $quiz->id]) }}">{{ $quiz->title }}</a></li>
        <li class="breadcrumb-item active">{{ __("cms-pages.edit-question") }}</li>
    </ul>
@endsection
@section('content')
    <form id="form-update" class="form-horizontal" method="POST"
          action="{{ route('questions.update', [$course->id, $stage->id, $quiz->id, $question->id]) }}"
          enctype="multipart/form-data"> @csrf @method('PUT')

        <div class="row flex-row">
            <div class="col-12">
                <div class="widget has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center">
                        <h4>{{ __("cms-pages.question-form") }}</h4>
                    </div>
                    <div class="widget-body">
                        {{-- Question: Title --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.question") }}</label>
                            <div class="col-lg-9">
                                <textarea name="title" class="form-control"
                                          rows="8">{!! $question->title !!}</textarea>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Question Font Size --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.font-size") }}</label>
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <div class="mb-3">
                                            <div class="styled-radio">
                                                <input type="radio" name="font_size" id="normal" value="normal"
                                                       @if($question->font_size == 'normal') checked @endif>
                                                <label for="normal">{{ __("cms-pages.font-normal") }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="mb-3">
                                            <div class="styled-radio">
                                                <input type="radio" name="font_size" id="large" value="large"
                                                       @if($question->font_size == 'large') checked @endif>
                                                <label for="large">{{ __("cms-pages.font-large") }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-2">
                                        <div class="mb-3">
                                            <div class="styled-radio">
                                                <input type="radio" name="font_size" id="huge" value="huge"
                                                       @if($question->font_size == 'huge') checked @endif>
                                                <label for="huge">{{ __("cms-pages.font-huge") }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Question Image --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.main-image") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    <div class="current-item">
                                        <img src="{{ $question->getImage() }}" width="240" alt="{{ $question->title }}">
                                        @if($question->image)
                                            <div class="small file-remove" data-method="PUT"
                                                 data-delete="{{route('questions.image.remove', [$course->id, $stage->id, $quiz->id, $question->id])}}">
                                                {{ __("cms-pages.remove") }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="image" data-var="image" data-toggle="modal"
                                        data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                            </div>
                        </div>
                        {{-- Question Audios[] --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.audio") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    @if($question->audios)
                                        @foreach($question->audios as $audio)
                                            <div class="current-item mb-2">
                                                <audio src="{{$audio->getAudio()}}" controls></audio>
                                                <div class="small file-remove" data-method="DELETE"
                                                     data-delete="{{route('questions.audio.remove', [$course->id, $stage->id, $quiz->id, $question->id, $audio->id])}}">
                                                    {{ __("cms-pages.remove") }}
                                                </div>
                                                <input type="hidden" name="question_audios[]" value="{{ $audio->audio }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="audio" data-var="question_audio" data-toggle="modal"
                                        data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                            </div>
                        </div>
                        {{-- Question: Explanation --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.explanation") }}</label>
                            <div class="col-lg-9">
                                <textarea id="explanation" name="explanation" class="form-control"
                                          rows="3">{!! $question->explanation !!}</textarea>
                                @error('explanation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
        $(document).ready(function (){
            CKEDITOR.replace('title');
            CKEDITOR.replace('explanation', {
                filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
        });
    </script>
    <script src="{{asset('assets/cms/js/ajax-store.js')}}"></script>
@endsection
