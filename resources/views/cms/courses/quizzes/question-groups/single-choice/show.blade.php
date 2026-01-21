@extends('layouts.cms')

@section('title', "{$questionGroupDto->getTitle()}")
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                <i class="ti ti-home"></i>
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('courses.index') }}">
                {{ __("cms-pages.courses") }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('courses.show', $course) }}">
                {{ $course->title }}
            </a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('quizzes.show', [$course, $stage, $quiz]) }}">
                {{ $quiz->title }}
            </a>
        </li>
        <li class="breadcrumb-item active">
            Группа вопросов (ред.)
        </li>
    </ul>
@endsection
@section('content')
    <div class="row flex-row">
        <div class="col-xl-12">
            @include('layouts.cms.template-parts.course.question.show-question-info')
            <div id="accordion" class="accordion">
                <div class="widget has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center justify-content-between">
                        <h4>Вопросы</h4>
                        <a href="#" type="button"
                           class="btn btn-primary mr-1 mb-2"
                        >Добавить вопрос</a>
                    </div>

                    <div class="widget-body">
                        <div class="table-responsive">
                            <table id="sorting-table" class="table mb-0">
                                <tbody>
                                @foreach($questionGroupDto->getQuestions() ?? [] as $qKey => $questionDto)
                                    <tr class="text-primary header">
                                        <td style="width: 70%">
                                            <h4>Вопрос {{ $qKey + 1 }}. {{ $questionDto->getText() }}</h4>
                                        </td>
                                        <td class="td-actions text-right">
                                            <a href="">
                                                <i class="la la-edit edit"></i>
                                            </a>
                                            <form style="display: inline-block" method="POST"
                                                  action="">
                                                @csrf @method('DELETE')

                                                <a href=""
                                                   onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                    <i class="la la-close delete"></i>
                                                </a>
                                            </form>
                                        </td>

                                        {{--                                                                                    @include('cms.courses.quizzes.questions.conformity.layouts.action-buttons')--}}
                                    </tr>

                                    @foreach($questionDto->getOptions() ?? [] as $oKey => $optionDto)
                                        <tr class="border-bottom">
                                            <td class="text-primary" style="width: 50%">{{ $optionDto->getText() }}</td>
                                            <td>
                                                <form action="{{--{{ route('options.change-is-correct', [$question->quiz->topic->stage->course->id, $question->quiz->topic->stage->id, $question->quiz->id, $question->id, $option->id]) }}--}}"
                                                      method="POST"> @csrf @method('PUT')
                                                    <div class="styled-radio">
                                                        <input type="radio" name="{{--option_{{$option['id']}}--}}"
                                                               id="option_{{ $qKey . $oKey }}"
                                                               value="1"
                                                               @if($questionDto->getAnswer() && $optionDto->getUuid() === $questionDto->getAnswer()->getValue()) checked
                                                               @endif
                                                               onchange="event.preventDefault();this.closest('form').submit()">
                                                        <label for="option_{{ $qKey . $oKey }}">
                                                            {{ __("cms-pages.is_true") }}
                                                        </label>
                                                    </div>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach




                                {{--                                @foreach($questionData['options'] ?? [] as $option)--}}
                                {{--                                    <tr class="text-primary header">--}}
                                {{--                                        <td style="width: 70%"><h4>qqqq</h4>--}}
                                {{--                                        </td>--}}
                                {{--                                        <td class="td-actions text-right">--}}
                                {{--                                            <a href=""><i--}}
                                {{--                                                        class="la la-edit edit"></i></a>--}}
                                {{--                                            <form style="display: inline-block" method="POST"--}}
                                {{--                                                  action="">--}}
                                {{--                                                @csrf @method('DELETE')--}}

                                {{--                                                <a href=""--}}
                                {{--                                                   onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">--}}
                                {{--                                                    <i class="la la-close delete"></i>--}}
                                {{--                                                </a>--}}
                                {{--                                            </form>--}}
                                {{--                                        </td>--}}

                                {{--                                                                                    @include('cms.courses.quizzes.questions.conformity.layouts.action-buttons')--}}
                                {{--                                    </tr>--}}
                                {{--                                    <tr class="border-bottom">--}}
                                {{--                                        <td class="text-primary" style="width: 50%">sdfa</td>--}}
                                {{--                                        <td>--}}
                                {{--                                            <form--}}
                                {{--                                                                                                        action="{{ route('options.change-is-correct', [$question->quiz->topic->stage->course->id, $question->quiz->topic->stage->id, $question->quiz->id, $question->id, $option->id]) }}"--}}
                                {{--                                                    method="POST"> @csrf @method('PUT')--}}
                                {{--                                                <div class="styled-radio">--}}
                                {{--                                                    <input type="radio" name="option_{{$option['id']}}"--}}
                                {{--                                                           id="option_{{$option['id']}}"--}}
                                {{--                                                           value="1"--}}
                                {{--                                                           @if($option['isCorrect']) checked @endif--}}
                                {{--                                                           onchange="event.preventDefault();this.closest('form').submit()">--}}
                                {{--                                                    <label--}}
                                {{--                                                            for="option_{{$option['id']}}">{{ __("cms-pages.is_true") }}</label>--}}
                                {{--                                                </div>--}}
                                {{--                                            </form>--}}
                                {{--                                        </td>--}}
                                {{--                                    </tr>--}}
                                {{--                                @endforeach--}}

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--        <div class="col-xl-12">--}}
        {{--            <div id="accordion" class="accordion">--}}
        {{--                <div class="widget has-shadow">--}}
        {{--                    --}}{{--                    @include('cms.courses.quizzes.questions.conformity.layouts.widget-header')--}}

        {{--                    <div class="widget-body">--}}
        {{--                        <div class="table-responsive">--}}
        {{--                            <table id="sorting-table" class="table mb-0">--}}
        {{--                                <thead>--}}
        {{--                                <tr>--}}
        {{--                                    <th>{{ __("cms-pages.answer") }}</th>--}}
        {{--                                    <th>{{ __("cms-pages.correct-answer") }}</th>--}}
        {{--                                </tr>--}}
        {{--                                </thead>--}}
        {{--                                <tbody>--}}

        {{--                                --}}{{--                                @foreach($questionData['options'] ?? [] as $option)--}}
        {{--                                --}}{{--                                    <tr class="text-primary header">--}}
        {{--                                --}}{{--                                        <td style="width: 70%"><h4>qqqq</h4>--}}
        {{--                                --}}{{--                                        </td>--}}
        {{--                                --}}{{--                                        <td class="td-actions text-right">--}}
        {{--                                --}}{{--                                            <a href=""><i--}}
        {{--                                --}}{{--                                                        class="la la-edit edit"></i></a>--}}
        {{--                                --}}{{--                                            <form style="display: inline-block" method="POST"--}}
        {{--                                --}}{{--                                                  action="">--}}
        {{--                                --}}{{--                                                @csrf @method('DELETE')--}}

        {{--                                --}}{{--                                                <a href=""--}}
        {{--                                --}}{{--                                                   onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">--}}
        {{--                                --}}{{--                                                    <i class="la la-close delete"></i>--}}
        {{--                                --}}{{--                                                </a>--}}
        {{--                                --}}{{--                                            </form>--}}
        {{--                                --}}{{--                                        </td>--}}
        {{--                                --}}{{--                                    </tr>--}}
        {{--                                --}}{{--                                    <tr class="border-bottom">--}}
        {{--                                --}}{{--                                        <td class="text-primary" style="width: 50%">sdfa</td>--}}
        {{--                                --}}{{--                                        <td>--}}
        {{--                                --}}{{--                                            <form method="POST"> @csrf @method('PUT')--}}
        {{--                                --}}{{--                                                <div class="styled-radio">--}}
        {{--                                --}}{{--                                                    <input type="radio" name="option_{{$option['id']}}"--}}
        {{--                                --}}{{--                                                           id="option_{{$option['id']}}"--}}
        {{--                                --}}{{--                                                           value="1"--}}
        {{--                                --}}{{--                                                           @if($option['isCorrect']) checked @endif--}}
        {{--                                --}}{{--                                                           onchange="event.preventDefault();this.closest('form').submit()">--}}
        {{--                                --}}{{--                                                    <label--}}
        {{--                                --}}{{--                                                            for="option_{{$option['id']}}">{{ __("cms-pages.is_true") }}</label>--}}
        {{--                                --}}{{--                                                </div>--}}
        {{--                                --}}{{--                                            </form>--}}
        {{--                                --}}{{--                                        </td>--}}
        {{--                                --}}{{--                                    </tr>--}}
        {{--                                --}}{{--                                @endforeach--}}

        {{--                                </tbody>--}}
        {{--                            </table>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </div>--}}
    </div>
@endsection

@section('page-scripts')
    @include('layouts.cms.template-parts.scripts-forms')
    <script src="{{asset('assets/cms/vendors/js/bootstrap-select/bootstrap-select.min.js')}}"></script>
@endsection

