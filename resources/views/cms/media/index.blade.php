@extends('layouts.cms')

@section('page-styles')
    @include('layouts.cms.template-parts.styles-index')
@endsection
@section('title', __("cms-pages.media-files"))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item active">{{ __("cms-pages.media-files") }}</li>
    </ul>
@endsection
@section('content')
    <div class="row flex-row">
        <div class="col-xl-9">
            <!-- Sorting -->
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                    <h4>{{ __("cms-pages.filter") }}</h4>
                    <button type="button" class="btn btn-primary mr-1 mb-2" data-toggle="modal"
                            data-target="#modal-upload">
                        {{ __("cms-pages.upload-files") }}
                    </button>
                </div>
                <div class="widget-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="image-tab" data-toggle="tab" href="#image-area" role="tab"
                               aria-controls="image-area" aria-selected="true">
                                <i class="ion-image mr-2"></i>{{__("cms-pages.images")}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="audio-tab" data-toggle="tab" href="#audio-area" role="tab"
                               aria-controls="audio-area" aria-selected="false">
                                <i class="ion-music-note mr-2"></i>{{__("cms-pages.audio-files")}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="video-tab" data-toggle="tab" href="#video-area" role="tab"
                               aria-controls="video-area" aria-selected="false">
                                <i class="ion-videocamera mr-2"></i>{{__("cms-pages.video-files")}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="file-tab" data-toggle="tab" href="#file-area" role="tab"
                               aria-controls="file-area" aria-selected="false">
                                <i class="ion-archive mr-2"></i>{{__("cms-pages.files")}}
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        {{-- Image Area--}}
                        <div class="tab-pane fade show active" id="image-area" role="tabpanel"
                             aria-labelledby="image-tab">
                            <div class="row">
                                @foreach($images as $image)
                                    <div class="col-xl-2">
                                        <div class="file-wrap">
                                            <img class="file" src="{{$image->getSmallImage()}}" style="width: 100%"
                                                 alt="{{$image->alt}}" data-title="{{$image->title}}"
                                                 data-id="{{$image->id}}">

                                            <div class="file-icons">
                                                <form style="display: inline-block" method="POST"
                                                      action="{{ route('media.destroy', $image->id) }}">
                                                    @csrf @method('DELETE')

                                                    <a href="{{ route('media.destroy', $image->id) }}"
                                                       class="file-icon delete"
                                                       onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                        <i class="la la-close delete"></i>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="about-infos d-flex flex-column mt-2 mb-2">
                                            <div class="about-title">
                                                <h5 class="text-center" data-id="{{$image->id}}">{{$image->title}}</h5>
                                            </div>
                                        </div>
                                        <div class="about-infos d-flex flex-column mt-2 mb-2">
                                            <a href="{{ route('media.download', $image) }}">Download</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination --}}
                            @if($images->lastPage() > 1)
                                <div class="form-group">
                                    @if(request()->page && request()->page != 1)
                                        <a href="{{ $images->previousPageUrl() }}" class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                        <a href="{{ $images->url(1) }}" class="btn btn-secondary mr-1 mb-2">
                                            1
                                        </a>
                                    @endif
                                    <a href="{{ $images->url($images->currentPage()) }}"
                                       class="btn btn-primary mr-1 mb-2">
                                        {{ $images->currentPage() }}
                                    </a>
                                    @if(request()->page != $images->lastPage())
                                        <a href="{{ $images->url($images->lastPage()) }}"
                                           class="btn btn-secondary mr-1 mb-2">
                                            {{ $images->lastPage() }}
                                        </a>
                                        <a href="{{ $images->nextPageUrl() }}" class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        {{-- Audio Area--}}
                        <div class="tab-pane fade" id="audio-area" role="tabpanel" aria-labelledby="audio-tab">
                            <div class="row">
                                @foreach($audioFiles as $audio)
                                    <div class="col-xl-2">
                                        <div class="file-wrap audio">
                                            <div class="play-pause"></div>
                                            <audio class="file" src="{{$audio->getPath()}}"
                                                   data-title="{{$audio->title}}" data-id="{{$audio->id}}">
                                            </audio>

                                            <div class="file-icons">
                                                <form style="display: inline-block" method="POST"
                                                      action="{{ route('media.destroy', $audio->id) }}">
                                                    @csrf @method('DELETE')

                                                    <a href="{{ route('media.destroy', $audio->id) }}"
                                                       class="file-icon delete"
                                                       onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                        <i class="la la-close delete"></i>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="about-infos d-flex flex-column mt-2 mb-2">
                                            <div class="about-title">
                                                <h5 class="text-center" data-id="{{$audio->id}}">{{$audio->title}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination --}}
                            @if($audioFiles->lastPage() > 1)
                                <div class="form-group">
                                    @if(request()->page && request()->page != 1)
                                        <a href="{{ $audioFiles->previousPageUrl() }}"
                                           class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                        <a href="{{ $audioFiles->url(1) }}" class="btn btn-secondary mr-1 mb-2">
                                            1
                                        </a>
                                    @endif
                                    <a href="{{ $audioFiles->url($audioFiles->currentPage()) }}"
                                       class="btn btn-primary mr-1 mb-2">
                                        {{ $audioFiles->currentPage() }}
                                    </a>
                                    @if(request()->page != $audioFiles->lastPage())
                                        <a href="{{ $audioFiles->url($audioFiles->lastPage()) }}"
                                           class="btn btn-secondary mr-1 mb-2">
                                            {{ $audioFiles->lastPage() }}
                                        </a>
                                        <a href="{{ $audioFiles->nextPageUrl() }}" class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        {{-- Video Area--}}
                        <div class="tab-pane fade" id="video-area" role="tabpanel" aria-labelledby="video-tab">
                            <div class="row">
                                @foreach($videoFiles as $video)
                                    <div class="col-xl-2">
                                        <div class="file-wrap audio">
                                            <div class="play-pause"></div>
                                            <audio class="file" src="{{$video->getPath()}}"
                                                   data-title="{{$video->title}}" data-id="{{$video->id}}">
                                            </audio>

                                            <div class="file-icons">
                                                <form style="display: inline-block" method="POST"
                                                      action="{{ route('media.destroy', $video->id) }}">
                                                    @csrf @method('DELETE')

                                                    <a href="{{ route('media.destroy', $video->id) }}"
                                                       class="file-icon delete"
                                                       onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                        <i class="la la-close delete"></i>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="about-infos d-flex flex-column mt-2 mb-2">
                                            <div class="about-title">
                                                <h5 class="text-center" data-id="{{$video->id}}">{{$video->title}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination --}}
                            @if($videoFiles->lastPage() > 1)
                                <div class="form-group">
                                    @if(request()->page && request()->page != 1)
                                        <a href="{{ $videoFiles->previousPageUrl() }}"
                                           class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                        <a href="{{ $videoFiles->url(1) }}" class="btn btn-secondary mr-1 mb-2">
                                            1
                                        </a>
                                    @endif
                                    <a href="{{ $videoFiles->url($videoFiles->currentPage()) }}"
                                       class="btn btn-primary mr-1 mb-2">
                                        {{ $videoFiles->currentPage() }}
                                    </a>
                                    @if(request()->page != $videoFiles->lastPage())
                                        <a href="{{ $videoFiles->url($videoFiles->lastPage()) }}"
                                           class="btn btn-secondary mr-1 mb-2">
                                            {{ $videoFiles->lastPage() }}
                                        </a>
                                        <a href="{{ $videoFiles->nextPageUrl() }}" class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        {{-- Files Area--}}
                        <div class="tab-pane fade" id="file-area" role="tabpanel" aria-labelledby="file-tab">
                            <div class="row">
                                @foreach($files as $file)
                                    <div class="col-xl-2">
                                        <div class="file-wrap file">
                                            <div class="document"></div>

                                            <div class="file" src="{{$file->getPath()}}"
                                                 data-title="{{$file->title}}" data-id="{{$file->id}}"></div>

                                            <div class="file-icons">
                                                <form style="display: inline-block" method="POST"
                                                      action="{{ route('media.destroy', $file->id) }}">
                                                    @csrf @method('DELETE')

                                                    <a href="{{ route('media.destroy', $file->id) }}"
                                                       class="file-icon delete"
                                                       onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                        <i class="la la-close delete"></i>
                                                    </a>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="about-infos d-flex flex-column mt-2 mb-2">
                                            <div class="about-title">
                                                <h5 class="text-center" data-id="{{$file->id}}">{{$file->title}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            {{-- Pagination --}}
                            @if($files->lastPage() > 1)
                                <div class="form-group">
                                    @if(request()->page && request()->page != 1)
                                        <a href="{{ $files->previousPageUrl() }}" class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                        <a href="{{ $files->url(1) }}" class="btn btn-secondary mr-1 mb-2">
                                            1
                                        </a>
                                    @endif
                                    <a href="{{ $files->url($files->currentPage()) }}"
                                       class="btn btn-primary mr-1 mb-2">
                                        {{ $files->currentPage() }}
                                    </a>
                                    @if(request()->page != $files->lastPage())
                                        <a href="{{ $files->url($files->lastPage()) }}"
                                           class="btn btn-secondary mr-1 mb-2">
                                            {{ $files->lastPage() }}
                                        </a>
                                        <a href="{{ $files->nextPageUrl() }}" class="btn btn-secondary mr-1 mb-2">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3">
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center flex-wrap">
                    <input id="search" class="form-control mb-3" type="search" name="search"
                           placeholder="{{__("cms-pages.search")}}">
                </div>
                <div class="widget-body">

                    <div id="no-file-selected" class="info">Файл не выбран</div>

                    <form id="file-form" action="#" method="POST" class="hide">
                        @csrf @method('PUT')

                        {{-- Preview Container for Media Files --}}
                        <div id="preview"></div>

                        {{-- File Size --}}
                        <div class="about-infos mb-3 mt-3">
                            <div class="about-title"><h5>{{ __("cms-pages.file-size") }}:</h5></div>
                            <div title="file-size" class="about-text"></div>
                        </div>

                        {{-- File Duration --}}
                        <div class="about-infos mb-3">
                            <div class="about-title"><h5>{{ __("cms-pages.file-duration") }}:</h5></div>
                            <div title="file-duration" class="about-text"></div>
                        </div>

                        {{-- File Title --}}
                        <div class="form-group row d-flex align-items-center mb-3">
                            <div class="col-12">
                                <label class="form-control-label">{{__("cms-pages.title")}}</label>
                                <input type="text" name="title" placeholder="{{__("cms-pages.title")}}"
                                       class="form-control">
                            </div>
                        </div>
                        {{-- File Alt --}}
                        <div class="form-group row d-flex align-items-center mb-3">
                            <div class="col-12">
                                <label class="form-control-label">{{__("cms-pages.alt-attr")}}</label>
                                <input type="text" name="alt" placeholder="{{__("cms-pages.alt-attr")}}"
                                       class="form-control">
                            </div>
                        </div>

                        {{-- File link --}}
                        <div class="about-infos mb-3 mt-3">
                            <div class="about-title"><h5>Ссылка:</h5></div>
                            <div title="file-link" class="about-text"></div>
                        </div>
                        <div class="alert alert-success hide"></div>

                        <div class="text-right">

                        </div>
                        <div class="text-right">
                            <a href="#" id="download-link" class="btn btn-shadow">{{ __("cms-pages.download") }}</a>
                            <button id="ajax-submit" class="btn btn-gradient-01"
                                    type="submit">{{ __("cms-pages.save") }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('modal')
    <form class="form-horizontal" method="POST" action="{{ route('media.store')}}" enctype="multipart/form-data">
        @csrf

        <div id="modal-upload" class="modal fade">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__("cms-pages.upload-files")}}</h4>
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">close</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-12 mb-3">
                                <label class="form-control-label">
                                    {{ __("cms-pages.upload") }}<span class="text-danger ml-2">*</span>
                                </label>
                                <input type="file" name="filename[]" class="form-control" multiple
                                       placeholder="{{ __("cms-pages.filename") }}" value="{{old('filename')}}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-gradient-01" type="submit">{{ __("cms-pages.save") }}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('page-scripts')
    @include('layouts.cms.template-parts.scripts-index')
    <script src="{{asset('assets/cms/js/components/audio/audioplayer.min.js')}}"></script>
    <script src="{{asset('assets/cms/js/ajax-media.js')}}"></script>
@endsection
