@extends('layouts.site')

@section('page-styles')
    <link rel="stylesheet" href="{{asset('assets/site/css/owl-carousel/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/site/css/owl-carousel/owl.theme.min.css')}}">
@endsection
@section('title', __("site-pages.bug-work"))
@section('header-tools')
    <div class="page-header-tools">
        <a class="btn btn-success"
           href="{{ route('site.testing', [$course->id, $topic->id, $quiz->id]) }}">{{ __("site-pages.retake-quiz") }}</a>
        <a class="btn btn-shadow"
           href="{{ route('site.course-show', $course->id) }}">{{ __("site-pages.course-plan") }}</a>
    </div>
@endsection
@section('content')
    <div class="row flex-row">
        <div class="col-12">

            @foreach($questions as $key => $question)
                {{-- Work on Bugs --}}
                <div class="widget widget-12 has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                        <h3 class="{{$question->getFontSize()}}">{{$key+1}}. {!! $question->title !!}</h3>
                        @if($question->explanation)
                            <button type="button" class="btn btn-secondary" data-toggle="modal"
                                    data-target="#modal_{{$question->id}}">{{__("site-pages.explanation")}}</button>
                        @endif
                    </div>

                    <div class="widget-body">
                        {{-- Question: Single Choice --}}
                        @if($question->type === 'single_choice')
                            @foreach($question->conformities as $key => $conformity)
                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div
                                            class="widget-header no-actions d-flex align-items-center justify-content-between">
                                            <h4 class="{{$question->getFontSize()}}">{{$key+1}}
                                                . {{$conformity->title}}</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    @if($conformity->audio)
                                                        <div class="about-infos d-flex mb-3">
                                                            <div class="about-text">
                                                                <audio src="{{$conformity->getAudio()}}" preload="auto"
                                                                       controls></audio>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($conformity->image)
                                                        <div class="about-infos d-flex mb-5">
                                                            <div class="about-text">
                                                                <img src="{{$conformity->getImage()}}" width="300"
                                                                     alt="{{ $conformity->title }}">
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @foreach($conformity->options as $option)
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <div class="styled-radio radio-disabled">
                                                                <input type="radio"
                                                                       name="conformity_{{$conformity->id}}"
                                                                       id="option_{{$option->id}}"
                                                                       value="{{$option->id}}" disabled
                                                                       @if($option->getUserAnswer($user)) checked @endif>
                                                                <label
                                                                    class="{{$question->getFontSize()}} {{$option->getClassByAnswer($user)}}"
                                                                    for="option_{{$option->id}}">{{$option->value}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Question: Multiple Choice --}}
                        @if($question->type === 'multiple_choice')
                            @foreach($question->conformities as $key => $conformity)
                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div
                                            class="widget-header no-actions d-flex align-items-center justify-content-between">
                                            <h4 class="{{$question->getFontSize()}}">{{$key+1}}
                                                . {{$conformity->title}}</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="row">
                                                @foreach($conformity->options as $option)
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            @if($question->type == 'multiple_choice')
                                                                <div class="styled-checkbox checkbox-disabled">
                                                                    <input type="checkbox"
                                                                           name="conformity_{{$conformity->id}}[]"
                                                                           id="answer_{{$option->id}}"
                                                                           value="{{$option->id}}" disabled
                                                                           @if($option->getUserAnswer($user)) checked @endif>
                                                                    <label
                                                                        class="{{$question->getFontSize()}} {{$option->getClassByAnswer($user)}}"
                                                                        for="answer_{{$option->id}}">{{$option->value}}</label>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Question: Matching --}}
                        @if($question->type === 'matching')
                            <div class="form-group row d-flex align-items-center mb-5">
                                <div class="col-lg-12">
                                    <div class="source-list">
                                        @foreach($question->conformities as $conformity)
                                            <div class="question-container" data-id="{{$conformity->id}}">
                                                @if($question->conformityHasImage())
                                                    <div class="question-body" style="height:100px;">
                                                        <img src="{{ $conformity->getImage() }}" height="100"
                                                             alt="{{ $quiz->title }}">
                                                    </div>
                                                @endif
                                                <div class="question-body m-3 {{$question->getFontSize()}}">
                                                    {{ $conformity->title }}
                                                </div>
                                                <div class="draggable-field m-3" data-option="{{$conformity->id}}">
                                                    <div
                                                        class="list-item m-3 {{$question->getFontSize()}} {{$conformity->getClassByAnswer($user)}}"
                                                        draggable="true"
                                                        data-option="{{$conformity->getOptionIdByAnswer($user)}}">
                                                        {{ $conformity->getOptionValueByAnswer($user) }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                        {{-- Question: Fill in the Gaps --}}
                        @if($question->type === 'fill_the_gaps')
                            @foreach($question->conformities as $key => $conformity)
                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div
                                            class="widget-header no-actions d-flex align-items-center justify-content-between">
                                            <h4 class="{{$question->getFontSize()}}">
                                                {{$key+1}}. {!! $conformity->getSentenceForBugQuiz($user) !!}
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Question: Logic Choice --}}
                        @if($question->type === 'logic_choice')
                            @foreach($question->conformities as $key => $conformity)
                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div
                                            class="widget-header no-actions d-flex align-items-center justify-content-between">
                                            <h4 class="{{$question->getFontSize()}}">{{$key+1}}
                                                . {{$conformity->title}}</h4>
                                        </div>
                                        <div class="widget-body">
                                            <div class="row">
                                                @foreach($conformity->options as $option)
                                                    <div class="col-xl-3">
                                                        <div class="mb-3">
                                                            <div class="styled-radio radio-disabled">
                                                                <input type="radio"
                                                                       name="conformity_{{$conformity->id}}"
                                                                       id="option_{{$option->id}}"
                                                                       value="{{$option->id}}" disabled
                                                                       @if($option->getUserAnswer($user)) checked @endif>
                                                                <label
                                                                    class="{{$question->getFontSize()}} {{$option->getClassByAnswer($user)}}"
                                                                    for="option_{{$option->id}}">{{__("cms-pages.logic-".$option->value)}}</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Question: Make Sentence & Make Text --}}
                        @if(in_array($question->type, ['make_sentence', 'make_text']))



                            @foreach($question->conformities as $key => $conformity)

                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div class="source-list">
                                            @foreach($conformity->answersByUser($result) as $answer)
                                                <div class="question-container make-sentence"
                                                     data-id="{{$answer->id }}">
                                                    <div class="draggable-field field-word m-3">
                                                        <div
                                                            class="list-item item-word m-3 {{$answer->getClassByValue()}} {{$question->getFontSize()}}"
                                                            draggable="true">
                                                            {{ $answer->getOptionValue($user) }}
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="option_{{$answer->id}}" value="">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        {{-- Question: Listen and Write --}}
                        @if($question->type === 'listen_write')
                            @foreach($question->conformities as $key => $conformity)
                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div
                                            class="widget-header no-actions d-flex align-items-center justify-content-between">
                                            <h4 class="{{$question->getFontSize()}}">{{$key+1}}.</h4>
                                        </div>
                                        <input type="text" name="conformity_{{$conformity->id}}"
                                               class="form-control {{$conformity->getClassByAnswer($user)}} {{$question->getFontSize()}}"
                                               value="{{$conformity->getAnswerByUser($user)}}">
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        {{-- Question: Short Answer --}}
                        @if($question->type === 'short_answer')
                            @foreach($question->conformities as $key => $conformity)
                                <div class="form-group row d-flex align-items-center mb-5">
                                    <div class="col-lg-12">
                                        <div
                                            class="widget-header no-actions d-flex align-items-center justify-content-between">
                                            <h4 class="{{$question->getFontSize()}}">{{$key+1}}
                                                . {!! $conformity->title !!}</h4>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-4 col-lg-6 col-md-12">
                                                <input type="text" name="conformity_{{$conformity->id}}"
                                                       class="form-control {{$conformity->getClassByAnswer($user)}} {{$question->getFontSize()}}"
                                                       value="{{$conformity->getAnswerByUser($user)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('modal')
    @foreach($questions as $key => $question)
        @if($question->explanation)
            <div id="modal_{{$question->id}}" class="modal fade">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">{!! $question->title !!}</h4>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                                <span class="sr-only">close</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @if($quiz->audios)
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-text">
                                        <audio src="{{$quiz->getAudio()}}" preload="auto" controls></audio>
                                    </div>
                                </div>
                            @endif
                            @if($quiz->video)
                                <div class="about-infos d-flex flex-column mb-3">
                                    <div class="about-text">
                                        <div id="player" data-id="{{$quiz->getVideoId()}}"
                                             data-width="100%" data-height="390"></div>
                                    </div>
                                </div>
                            @endif

                            @if($question->audios)
                                @foreach($question->audios as $audio)
                                    <div class="about-infos d-flex flex-column mb-3">
                                        <div class="about-text">
                                            <audio src="{{$audio->getAudio()}}" preload="auto" controls></audio>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <p>{!! $question->explanation !!}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                    data-dismiss="modal">{{__("site-pages.close")}}</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
@endsection
@section('page-scripts')
    <script src="{{asset('assets/site/vendors/js/progress/circle-progress.min.js')}}"></script>
    <script src="{{asset('assets/site/vendors/js/chart/chart.min.js')}}"></script>
    <script src="{{asset('assets/site/vendors/js/calendar/moment.min.js')}}"></script>
    <script src="{{asset('assets/site/vendors/js/calendar/fullcalendar.min.js')}}"></script>
    <script src="{{asset('assets/site/vendors/js/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('assets/site/js/dashboard/db-default.js')}}"></script>
@endsection
