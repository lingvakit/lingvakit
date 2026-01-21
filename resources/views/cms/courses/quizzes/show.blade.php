@extends('layouts.cms')

@section('title', __("cms-pages.quiz-info"))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item active">{{ $quiz->title }}</li>
    </ul>
@endsection
@section('content')
    <div class="row flex-row">
        <div class="col-xl-12">
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                    <h4>{{ __("cms-pages.about-quiz") }}</h4>
                    <a href="{{ route('quizzes.edit', [$course, $stage, $quiz]) }}" type="button"
                       class="btn btn-primary mr-1 mb-2">{{ __("cms-pages.edit") }}</a>
                </div>
                <div class="widget-body">
                    <div class="row flex-row">
                        <div class="col-xl-3">
                            {{-- Quiz Image --}}
                            @if($quizImageUrl)
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-image">
                                        <img src="{{$quizImageUrl}}" alt="{{ $quizDto->getTitle() ?? '' }}">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="col-xl-9">
                            {{-- Quiz Title --}}
                            @if($quizDto->getTitle())
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-title"><h5>{{ __("cms-pages.title") }}:</h5></div>
                                    <div class="about-text">{{ $quizDto->getTitle() }}</div>
                                </div>
                            @endif

                            {{-- Quiz Description --}}
                            @if($quizDto->getDescription())
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-title"><h5>{{ __("cms-pages.description") }}:</h5></div>
                                    <div class="about-text">{!! $quizDto->getDescription() !!}</div>
                                </div>
                            @endif

                            {{-- Quiz Audio --}}
                            @if($quizAudioUrl)
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-text">
                                        <audio src="{{$quizAudioUrl}}" preload="auto" controls></audio>
                                    </div>
                                </div>
                            @endif

                            {{-- Quiz Video --}}
                            @if($quizVideoUrl)
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-text">
                                        <div id="player"
                                             data-id="{{$quizDto->getVideoId()}}"
                                             data-width="640"
                                             data-height="390"
                                        >
                                            <video src="{{$quizVideoUrl}}" controls></video>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Quiz Duration --}}
                            @if($quizDto->getTimeLimit() > 0)
                                {{-- Quiz Duration --}}
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-title"><h5>{{ __("cms-pages.quiz-duration") }}:</h5></div>
                                    <div class="about-text">{{ $quizTimeLimit }}</div>
                                </div>
                            @endif
                            @if($quiz->topic->passed_topics)
                                {{-- Quiz Duration --}}
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-title"><h5>{{ __("cms-pages.required-topics") }}:</h5></div>
                                    <div class="about-text">{{ $quiz->topic->getRequiredTopics() }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-12">
            <div class="widget has-shadow">
                <div class="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                    <h4>Вопросы теста (группы)</h4>
                    <div class="text-right">
                        <div class="actions dark">
                            <div class="dropdown">
                                <button type="button" class="btn btn-primary mr-1 mb-2" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false" class="dropdown-toggle">
                                    Добавить группу вопросов ...
                                </button>
                                <div class="dropdown-menu">
                                    @foreach($questionTypes as $type)
                                        <a href="{{ route('questionGroup.create', [$course, $stage, $quiz, $type->title]) }}"
                                           class="dropdown-item">
                                            <i class="la la-plus"></i>{{ __("cms-pages.".$type->title) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="table-responsive">
                        <table id="sorting-table" class="table mb-0">
                            <thead>
                            <tr>
                                <th>Группа</th>
                                <th>Тип вопросов</th>
                                <th>{{ __("cms-pages.actions") }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($quizDto->getQuestionGroups() as $group)
                                <tr>
                                    <td class="text-primary">{!! $group->getTitle() !!}</td>
                                    <td>{{ $group->getType()->getValue() }}</td>
                                    <td class="td-actions" style="width: 190px">
                                        <a href="{{ route('questionGroup.show', [$course, $stage, $quiz, $group->getUuid()]) }}"
                                           title="Просмотр группы"><i class="la la-eye edit"></i></a>

                                        <a href=""
                                           title="Добавить вопрос в группу"><i class="la la-plus edit"></i></a>

                                        <a href="{{--{{ route('questions.edit', [$course->id, $stage->id, $quiz->id, $question->id]) }}--}}"
                                           title="Редактирование группы"><i class="la la-edit edit"></i></a>

                                        <form style="display: inline-block" method="POST"
                                              action="{{--{{ route('questions.destroy', [$course->id, $stage->id, $quiz->id, $question->id]) }}--}}">
                                            @csrf @method('DELETE')
                                            <a href="{{--{{ route('questions.destroy', [$course->id, $stage->id, $quiz->id, $question->id]) }}--}}"
                                               onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                <i class="la la-close delete"></i>
                                            </a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    @include('layouts.cms.template-parts.scripts-forms')
    <script src="{{asset('assets/cms/js/components/audio/audioplayer.min.js')}}"></script>
    <script src="{{asset('assets/cms/vendors/js/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('assets/cms/js/youtube.min.js')}}"></script>
@endsection

