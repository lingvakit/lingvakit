@extends('layouts.cms')

@section('title', $article->title)
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</a></li>
        <li class="breadcrumb-item active">{{$article->title}}</li>
    </ul>
@endsection
@section('content')
    <form id="form-update" class="form-horizontal" method="POST" action="{{ route('articles.update', $article) }}" enctype="multipart/form-data">
        @csrf @method('put')
        <div class="row flex-row">
            <div class="col-12">
                <div class="widget has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center">
                        <h4>{{ __("cms-pages.course-form") }}</h4>
                    </div>
                    <div class="widget-body">
                        {{-- Article Rubric --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">Рубрика</label>
                            <div class="col-lg-9">
                                <select id="category_select" name="rubric_id"
                                        class="custom-select form-control">
                                    <option value="" selected disabled>Рубрика</option>
                                    @foreach($rubrics as $rubric)
                                        <option value="{{ $rubric->id }}" @if($rubric->id===$article->rubric_id) selected @endif>
                                            {{ $rubric->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rubric_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Article Title --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">Заголовок<span
                                        class="text-danger ml-2">*</span></label>
                            <div class="col-lg-9">
                                <input type="text" name="title" class="form-control"
                                       placeholder="Заголовок" value="{{old('title', $article->title)}}">
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Article Description--}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.description") }}</label>
                            <div class="col-lg-9">
                                <textarea id="description" name="content" class="form-control" rows="3"
                                          placeholder="{{ __("cms-pages.description") }}">{{old('content', $article->content)}}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- Article Image --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">{{ __("cms-pages.main-image") }}</label>
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    <div class="current-item">
                                        <img src="{{ $article->getImage() }}" width="240" alt="{{ $article->title }}">
                                        @if($article->image)
                                            <div class="small file-remove" data-method="PUT"
                                                 data-delete="{{route('articles.image.remove', $article->id)}}">
                                                {{ __("cms-pages.remove") }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach"
                                        data-type="image" data-var="image" data-toggle="modal" data-target="#modal-files">
                                    {{__("cms-pages.choose")}}
                                </button>
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
