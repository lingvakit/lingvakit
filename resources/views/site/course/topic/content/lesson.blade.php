@if(session('upload_success'))
    <div class="alert alert-success">
        {{session('upload_success')}}
    </div>
@endif

<div class="widget widget-12 has-shadow">
    <div class="widget-body sliding-tabs">
        <ul class="nav nav-tabs" id="example-one" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="base-tab-lesson" data-toggle="tab" href="#tab-lesson" role="tab"
                   aria-controls="tab-lesson" aria-selected="true">Урок</a>
            </li>
            <li class="nav-item @if(!$lesson->presentation) disabled @endif">
                <a class="nav-link" id="base-tab-video" data-toggle="tab"
                   href="#tab-video" role="tab" aria-controls="tab-video" aria-selected="false">Аудио/Видео</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(!$lesson->presentation) disabled @endif" id="base-tab-pres" data-toggle="tab"
                   href="#tab-pres" role="tab"
                   aria-controls="tab-pres" aria-selected="false">Презентация</a>
            </li>
            <li class="nav-item @if(!$lesson->presentation) disabled @endif">
                <a class="nav-link" id="base-tab-file" data-toggle="tab"
                   href="#tab-file" role="tab" aria-controls="tab-file" aria-selected="false">Файлы</a>
            </li>
            <li class="nav-item @if(!$lesson->homeWork) disabled @endif">
                <a class="nav-link" id="base-tab-hw" data-toggle="tab"
                   href="#tab-hw" role="tab" aria-controls="tab-hw" aria-selected="false">Домашнее задание</a>
            </li>
        </ul>
        <div class="tab-content pt-3">
            <div class="tab-pane fade show active" id="tab-lesson" role="tabpanel" aria-labelledby="base-tab-lesson">
                @if($lesson->image)
                    <div class="about-infos d-flex flex-column mb-3">
                        <div class="about-text">
                            <img src="{{$lesson->getImage()}}" style="max-width:400px;"
                                 alt="{{$lesson->getImageAlt()}}">
                        </div>
                    </div>
                @endif

                <div class="about-infos d-flex flex-column mt-3">
                    <div class="about-text">
                        {!! $lesson->description !!}
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tab-video" role="tabpanel" aria-labelledby="base-tab-video">
                @if($lesson->audios)
                    @foreach($lesson->audios as $audio)
                        <div class="about-infos d-flex flex-column mb-3">
                            <audio src="{{$audio->getAudio()}}" controls></audio>
                        </div>
                    @endforeach
                @endif
                @if($lesson->video)
                        @if($lesson->isExternalVideo())
                            <div id="player" data-id="{{$lesson->getVideoId()}}"
                                 data-width="640" data-height="390"></div>
                        @else
                            {{--TODO: Fix if does not exists--}}
{{--                            <video src="{{$lesson->getVideo()}}" width="640" controls></video>--}}
                        @endif

{{--                    @if(strpos($lesson->video, 'rutube') !== false)--}}
{{--                        <iframe class="rutube-frame"--}}
{{--                                src="{{ 'https://rutube.ru/play/embed/' . str_replace('https://rutube.ru/video/', '',$lesson->video) }}"--}}
{{--                                frameBorder="0" allow="clipboard-write; autoplay" webkitAllowFullScreen--}}
{{--                                mozallowfullscreen--}}
{{--                                allowFullScreen></iframe>--}}
{{--                    @else--}}
{{--                        <div class="about-infos d-flex flex-column mb-3">--}}
{{--                            <div class="about-text">--}}
{{--                                <div id="player" data-id="{{$lesson->getVideoId()}}"--}}
{{--                                     data-width="640" data-height="390"></div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                @endif

                @if($lesson->additionalVideos)
                    @foreach($lesson->additionalVideos as $video)
                        <div class="current-item mb-4">
                            <video
                                    src="{{asset($video->getVideoPath())}}"
                                    width="600"
                                    controls
                                    poster="{{$video->getPosterPath()}}"
                            ></video>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="tab-pane fade" id="tab-pres" role="tabpanel" aria-labelledby="base-tab-pres">
                @if($lesson->presentation)
                    @if($lesson->presentation->slides->count())
                        <div class="row">
                            <div class="col-lg-10">
                                <div class="presentation owl-carousel">
                                    @foreach($lesson->presentation->slides as $slide)
                                        <div class="swiper-slide">
                                            <img src="{{ $slide->slideImage->getLargeImage() }}"
                                                 alt="{{ $slide->title }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="presentation-thumbs">
                                    @foreach($lesson->presentation->slides as $key => $slide)
                                        <div class="thumb" data-slide-index="{{$key}}">
                                            <img src="{{ $slide->slideImage->getSmallImage() }}"
                                                 alt="{{ $slide->title }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="tab-pane fade" id="tab-file" role="tabpanel" aria-labelledby="base-tab-file">
                @if($files)
                    <div class="about-title mt-3 mb-3">
                        <h3>{{__("site-pages.additional-materials")}}</h3>
                    </div>
                    <div class="about-infos d-flex justify-content-start">
                        @foreach($files as $file)
                            @if($file->document && $file->document->type === 'file')
                                <div class="about-text m-3">
                                    <div class="about-icon {{$file->getFileType($file->document->filename)}} mb-2"></div>
                                    <a href="{{route('media.download', $file->file_id)}}">{{$file->document->title}}</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="tab-pane fade" id="tab-hw" role="tabpanel" aria-labelledby="base-tab-hw">
                @if($lesson->homeWork)
                    <div class="about-title mt-3 mb-4">
                        <h3>{{__("site-pages.homework")}}</h3>
                    </div>
                    <div class="about-infos d-flex justify-content-start mb-5">
                        <a href="{{asset('uploads/'.$lesson->homeWork->file_path)}}" class="btn btn-primary"
                           target="_blank">
                            Скачать ДЗ
                        </a>
                    </div>

                    @if(! $lesson->homeWork->finishedTask)
                        <div class="about-title mt-3 mb-4">
                            <h3>Загрузить домашнее задание</h3>
                        </div>
                        <div class="about-infos d-flex justify-content-start">
                            <form class="form-horizontal" method="POST"
                                  action="{{route('site.homework.send', [$lesson->topic->stage->course, $lesson->topic])}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="row flex-row">
                                    <div class="col-12">
                                        <div class="widget has-shadow">
                                            <div class="widget-body">
                                                {{-- Home Work File --}}
                                                <div class="form-group mb-5">
                                                    <label class="form-control-label" for="student_file_path">
                                                        Домашняя работа
                                                    </label>
                                                    <input type="file" name="student_file_path" id="student_file_path"
                                                           class="form-control">
                                                </div>
                                                {{-- Lesson Description--}}
                                                <div class="form-group mb-5">
                                                    <label class="form-control-label"
                                                           for="student_comment">{{ __("cms-pages.comment") }}</label>
                                                    <textarea id="student_comment" name="student_comment"
                                                              class="form-control" rows="5"
                                                              placeholder="{{ __("cms-pages.comment") }}">{{old('student_comment')}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-gradient-01">Загрузить</button>
                            </form>
                        </div>
                    @else
                        @if($lesson->homeWork->finishedTask->isChecked())
                            <div class="about-title mt-3 mb-4">
                                <h3>Домашнее задание проверено преподавателем</h3>
                            </div>
                            <div class="about-infos">
                                <p>Ваша оценка: </p>
                                <span style="font-size: 50px;" class="text-primary">
                                    {{$lesson->homeWork->finishedTask->assessment}}
                                </span>
                            </div>
                        @else
                            <div class="about-title mt-3 mb-4">
                                <h3>Вы загрузили домашнее задание</h3>
                            </div>
                            <div class="about-infos d-flex justify-content-start">
                                <p>Домашняя работа успешно загружена, но преподаватель еще не успел проверить ее.</p>
                            </div>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
