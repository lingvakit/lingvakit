@extends('layouts.cms')

@section('title', __("cms-pages.new-question.".$questionType))
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item"><a
                    href="{{ route('quizzes.show', [$course->id, $stage->id, $quiz->id]) }}">{{ $quiz->title }}</a></li>
        <li class="breadcrumb-item active">Создание группы вопросов</li>
    </ul>
@endsection
@section('content')
    <form class="form-horizontal" method="POST"
          action="{{ route('questions.store', [$course->id, $stage->id, $quiz->id, $questionType]) }}"
          enctype="multipart/form-data">
        @csrf

        <div class="row flex-row">
            {{-- QUESTION FORM --}}
            <div class="col-12">
                @include('layouts.cms.template-parts.course.question.question-form')
            </div>

            {{-- MATCHING FORM --}}
            <div class="@if(!in_array($questionType, ['make_sentence','make_text', 'listen_write', 'attach_file'])) col-8 @else col-12 @endif">
                @include('layouts.cms.template-parts.course.question.matching-form')
            </div>
            {{-- MATCHING OPTION FORM --}}
            <div class="col-4">
                {{-- Fill in the Gaps--}}
                @if($questionType === 'fill_the_gaps')
                    @include('cms.courses.quizzes.questions.conformity.layouts.create.filling')
                @endif
                {{-- Single Choice --}}
                @if($questionType === 'single_choice')
                    @include('cms.courses.quizzes.questions.conformity.layouts.create.single')
                @endif
                {{-- Multiple Choice--}}
                @if($questionType === 'multiple_choice')
                    @include('cms.courses.quizzes.questions.conformity.layouts.create.multiple')
                @endif
                {{-- Logic Choice--}}
                @if($questionType === 'logic_choice')
                    @include('cms.courses.quizzes.questions.conformity.layouts.create.logic')
                @endif
                {{-- Matching --}}
                @if($questionType === 'matching')
                    @include('cms.courses.quizzes.questions.conformity.layouts.create.matching')
                @endif
                {{-- Short Answer --}}
                @if($questionType === 'short_answer')
                    @include('cms.courses.quizzes.questions.conformity.layouts.create.short')
                @endif
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
            CKEDITOR.replace('explanation', {
                filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });

            /* Logic Switcher */
            let $trueFalseSwitcher = $('input.logic_switcher');
            let $trueFalseInput = '<input type="hidden" name="question_option[]" class="form-control" value="no_answer">' +
                '<input class="input-is-correct" type="radio" name="is_correct_3" id="is_correct_3" value="1">' +
                '<label for="is_correct_3">{{__("cms-pages.logic-no_answer")}}</label>';

            $trueFalseSwitcher.change(function () {
                if ($(this).attr('value') == 1) {
                    $('#place_for_input').html($trueFalseInput);
                } else {
                    $('#place_for_input input').remove('input');
                    $('#place_for_input label').remove('label');
                }
            });
        });
    </script>
    <script src="{{asset('assets/cms/js/ajax-store.js')}}"></script>
@endsection
