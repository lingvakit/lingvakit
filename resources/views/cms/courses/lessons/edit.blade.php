@extends('layouts.cms')

@section('title', __("cms-pages.edit-lesson"))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item active">{{ __("cms-pages.edit-lesson") }}</li>
    </ul>
@endsection
@section('content')
    <div class="row flex-row">
        <div class="col-12">
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center">
                    <h4>{{ __("cms-pages.lesson-form") }}</h4>
                </div>
                <div class="widget-body">
                    <form id="form-update" class="form-horizontal" method="POST"
                          action="{{ route('lessons.update', [$course->id, $stage->id, $lesson->id]) }}"
                          enctype="multipart/form-data">
                        @csrf @method('PUT')

                        {{-- Lesson Title --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.title") }}<span
                                        class="text-danger ml-2">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" name="title" class="form-control"
                                       placeholder="{{ __("cms-pages.title") }}" value="{{$lesson->title}}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Lesson Description--}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.description") }}</label>
                            <div class="col-lg-9">
                                <textarea id="description" name="description" class="form-control" rows="3"
                                          placeholder="{{ __("cms-pages.description") }}">{!! old('description', $lesson->description) !!}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Lesson Image --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.main-image") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    <div class="current-item">
                                        <img src="{{ $lesson->getImage() }}" width="240" alt="{{ $lesson->title }}">
                                        @if($lesson->image)
                                            <div class="small file-remove" data-method="PUT"
                                                 data-delete="{{route('lessons.image.remove', [$course->id, $stage->id, $lesson->id])}}">
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
                                    @if($lesson->audios)
                                        @foreach($lesson->audios as $audio)
                                            <div class="current-item mb-2">
                                                <audio src="{{$audio->getAudio()}}" controls></audio>
                                                <div class="small file-remove" data-method="DELETE"
                                                     data-delete="{{route('lessons.audio.remove', [$course->id, $stage->id, $lesson->id, $audio->id])}}">
                                                    {{ __("cms-pages.remove") }}
                                                </div>
                                                <input type="hidden" name="question_audios[]"
                                                       value="{{ $audio->audio }}">
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

                        {{-- Lesson Audio --}}
                        {{--<div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.audio") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    @if($lesson->audio)
                                        <div class="current-item">
                                            <audio src="{{$lesson->getAudio()}}" controls></audio>
                                            <div class="small file-remove" data-method="PUT"
                                                 data-delete="{{route('lessons.audio.remove', [$course->id, $stage->id, $lesson->id])}}">
                                                {{ __("cms-pages.remove") }}
                                            </div>
                                            <input type="hidden" name="audio" value="{{ $lesson->audio }}">
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="audio" data-var="audio" data-toggle="modal"
                                        data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                            </div>
                        </div>--}}
                        {{-- Lesson Video --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.video") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    @if($lesson->video)
                                        <div class="current-item">
                                            @if($lesson->isExternalVideo())
                                                <div id="player" data-id="{{$lesson->getVideoId()}}"
                                                     data-width="240" data-height="180"></div>
                                            @else
                                                <video src="{{$lesson->getVideo()}}" width="240" controls></video>
                                            @endif
                                            <div class="small file-remove" data-method="PUT"
                                                 data-delete="{{route('lessons.video.remove', [$course->id, $stage->id, $lesson->id])}}">
                                                {{ __("cms-pages.remove") }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="video" data-var="video" data-toggle="modal"
                                        data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                                <input type="text" name="youtube" class="form-control"
                                       placeholder="{{ __("cms-pages.video-link") }}"
                                       value="@if($course->isExternalVideo()){{$course->video}}@endif">
                            </div>
                        </div>

                        {{-- Additional videos --}}
                        @if($lesson->additionalVideos->count())
                            <div class="form-group row d-flex align-items-center mb-5">
                                <div class="col-lg-9 offset-lg-3">
                                    <div class="form-group preview">
                                        @foreach($lesson->additionalVideos as $video)
                                            <div class="current-item">
                                                <video
                                                        src="{{asset($video->getVideoPath())}}"
                                                        width="240"
                                                        controls
                                                        poster="{{$video->getPosterPath()}}"
                                                ></video>
                                                <div class="small">
                                                    <a href="{{route('lessons.video.detach', [$course, $stage, $lesson, $video])}}">
                                                        Удалить
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Files --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.file") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    @if($files)
                                        @foreach($files as $file)
                                            @if($file->document && $file->document->type === 'file')
                                                <div id="item-{{ $file->file_id }}" class="current-item">
                                                    <span>{{ $file->document->title }}</span>
                                                    <div class="small file-remove" data-method="PUT"
                                                         data-delete="{{route('lessons.file.remove', [$course->id, $stage->id, $lesson->id, $file->id])}}">
                                                        {{ __("cms-pages.remove") }}
                                                    </div>
                                                    <input type="hidden" name="files[]" value="{{ $file->id }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="file"
                                        data-var="file" data-toggle="modal" data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
                            </div>
                        </div>
                        {{-- Lesson Duration --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.lesson-duration") }}
                                , {{ __("min") }}</label>
                            <div class="col-lg-9">
                                <input type="number" name="duration" class="form-control" placeholder="10"
                                       value="{{$lesson->duration}}">
                                @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        @include('layouts.cms.template-parts.form-buttons')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    @include('layouts.cms.template-parts.modals.upload-and-choose-files')
@endsection
@section('page-scripts')
    @include('layouts.cms.template-parts.scripts-forms')
    <script src="{{asset('assets/cms/vendors/js/ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('assets/cms/js/ckeditor-custom.js')}}"></script>
    <script src="{{asset('assets/cms/js/youtube.min.js')}}"></script>
    <script src="{{asset('assets/cms/js/ajax-store.js')}}"></script>
@endsection
