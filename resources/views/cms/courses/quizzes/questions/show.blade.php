@extends('layouts.cms')

@section('title', __("cms-pages.question-info"))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item"><a
                href="{{ route('quizzes.show', [$course->id, $stage->id, $quiz->id]) }}">{{ $quiz->title }}</a></li>
        <li class="breadcrumb-item active">{{ __("cms-pages.question") }}</li>
    </ul>
@endsection
@section('content')
    <div class="row flex-row">
        {{-- Question Info --}}
        <div class="col-xl-12">
            @include('layouts.cms.template-parts.course.question.show-question-info')
        </div>

        <div class="col-xl-12">
            {{-- Fill in the Gaps--}}
{{--            @if($question->type === 'fill_the_gaps')--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.filling')--}}
{{--            @endif--}}

            {{-- Single Choice --}}
            @if($questionData['type'] === 'single_choice')
                <div id="accordion" class="accordion">
                    <div class="widget has-shadow">
                        @include('cms.courses.quizzes.questions.conformity.layouts.widget-header')

                        <div class="widget-body">
                            <div class="table-responsive">
                                <table id="sorting-table" class="table mb-0">
                                    <thead>
                                    <tr>
                                        <th>{{ __("cms-pages.answer") }}</th>
                                        <th>{{ __("cms-pages.correct-answer") }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($questionData['options'] ?? [] as $option)
                                        <tr class="text-primary header">
                                            <td style="width: 70%"><h4>qqqq</h4>
                                            </td>
                                            <td class="td-actions text-right">
                                                <a href=""><i
                                                            class="la la-edit edit"></i></a>
                                                <form style="display: inline-block" method="POST"
                                                      action="">
                                                    @csrf @method('DELETE')

                                                    <a href=""
                                                       onclick="event.preventDefault();if(confirm('{{ __("cms-messages.delete") }}')){this.closest('form').submit();}">
                                                        <i class="la la-close delete"></i>
                                                    </a>
                                                </form>
                                            </td>

{{--                                            @include('cms.courses.quizzes.questions.conformity.layouts.action-buttons')--}}
                                        </tr>
                                        <tr class="border-bottom">
                                            <td class="text-primary" style="width: 50%">sdfa</td>
                                            <td>
                                                <form
                                                        {{--                                                    action="{{ route('options.change-is-correct', [$question->quiz->topic->stage->course->id, $question->quiz->topic->stage->id, $question->quiz->id, $question->id, $option->id]) }}"--}}
                                                        method="POST"> @csrf @method('PUT')
                                                    <div class="styled-radio">
                                                        <input type="radio" name="option_{{$option['id']}}"
                                                               id="option_{{$option['id']}}"
                                                               value="1"
                                                               @if($option['isCorrect']) checked @endif
                                                               onchange="event.preventDefault();this.closest('form').submit()">
                                                        <label
                                                                for="option_{{$option['id']}}">{{ __("cms-pages.is_true") }}</label>
                                                    </div>
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

{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.single')--}}
            @endif

            {{-- Multiple Choice--}}
{{--            @if($question->type === 'multiple_choice')--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.multiple')--}}
{{--            @endif--}}

            {{-- Logic Choice--}}
{{--            @if($question->type === 'logic_choice')--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.logic')--}}
{{--            @endif--}}

            {{-- Matching --}}
{{--            @if($question->type === 'matching')--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.matching')--}}
{{--            @endif--}}

            {{-- Make Sentence --}}
{{--            @if(in_array($question->type, ['make_sentence', 'listen_write']))--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.sentence')--}}
{{--            @endif--}}

            {{-- Make Text --}}
{{--            @if($question->type === 'make_text')--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.text')--}}
{{--            @endif--}}

            {{-- Short Answer --}}
{{--            @if($question->type === 'short_answer')--}}
{{--                @include('cms.courses.quizzes.questions.conformity.layouts.show.short')--}}
{{--            @endif--}}

        </div>
    </div>
@endsection

@section('page-scripts')
    @include('layouts.cms.template-parts.scripts-forms')
    <script src="{{asset('assets/cms/vendors/js/bootstrap-select/bootstrap-select.min.js')}}"></script>
@endsection

