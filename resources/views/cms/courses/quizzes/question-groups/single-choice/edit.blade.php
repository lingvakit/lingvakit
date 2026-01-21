@extends('layouts.cms')

@section('title', "Редактирование группы вопросов с одиночным выбором")
@section('header-tools')
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.index') }}">{{ __("cms-pages.courses") }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('courses.show', $course->id) }}">{{ $course->title }}</a></li>
        <li class="breadcrumb-item"><a
                    href="{{ route('quizzes.show', [$course->id, $stage->id, $quiz->id]) }}">{{ $quiz->title }}</a></li>
        <li class="breadcrumb-item active">Группа вопросов (ред.)</li>
    </ul>
@endsection
@section('content')
    <form class="form-horizontal" method="POST"
          action="{{ route('questionGroup.update', [$course, $stage, $quiz, $questionGroupDto->getUuid()]) }}"
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row flex-row">
            {{-- Group data --}}
            <div class="col-12">
                <div class="widget has-shadow">
                    <div class="widget-header bordered no-actions d-flex align-items-center">
                        <h4>Данные о группе вопросов</h4>
                    </div>

                    <div class="widget-body">
                        {{-- Question group title --}}
                        <x-cms.form.textarea
                                name="question_group_title"
                                label="Название группы"
                                required
                                rows="2"
                                placeholder="Описание группы"
                                value="{{ $questionGroupDto->getTitle() }}"
                        />

                        {{-- Question group description --}}
                        <x-cms.form.textarea
                                name="question_group_description"
                                label="Описание группы"
                                rows="3"
                                placeholder="Здесь можно дополнительно дать описание для группы вопросов"
                                value="{{ $questionGroupDto->getDescription() }}"
                        />

                        {{-- Question group mediafiles --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">Медиафайлы</label>

                            {{-- Question group image --}}
                            <div class="col-lg-9">
                                <div class="form-group preview">
                                    <div class="current-item">
                                        <img src="{{asset('assets/cms/img/no-image.jpg')}}" width="100" alt>
                                    </div>
                                </div>
                                <button type="button"
                                        class="btn btn-primary btn-sm square mr-1 mb-2 btn-attach"
                                        data-type="image"
                                        data-var="question_group_image"
                                        data-toggle="modal"
                                        data-target="#modal-files"
                                >Прикрепить изображение</button>
                            </div>

                            {{-- Question group audio --}}
                            <div class="col-lg-9 offset-lg-3">
                                <div class="form-group preview mt-3"></div>
                                <button type="button"
                                        class="btn btn-primary btn-sm square mr-1 mb-2 btn-attach"
                                        data-type="audio"
                                        data-var="question_audio"
                                        data-toggle="modal"
                                        data-target="#modal-files"
                                >Прикрепить аудиофайл</button>
                            </div>
                        </div>

                        {{-- Question group attributes --}}
                        <div class="form-group row d-flex align-items-center mb-5">
                            <label class="col-lg-3 form-control-label">Дополнительные атрибуты</label>
                            <div class="col-lg-9">
                                @php
                                    $fontSize = $questionGroupDto->getMeta()?->getStyle()['fontSize'] ?? null;
                                @endphp

                                <x-cms.form.radio-group
                                        name="font_size"
                                        label="Размер шрифта"
                                        :options="[
                                            'normal' => __('cms-pages.font-normal'),
                                            'large' => __('cms-pages.font-large'),
                                            'huge' => __('cms-pages.font-huge'),
                                        ]"
                                        :selected="$fontSize"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-right">
            <button class="btn btn-gradient-01" type="submit">{{ __("cms-pages.save") }}</button>
            <button class="btn btn-shadow" type="reset">{{ __("cms-pages.cancel") }}</button>
        </div>
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
            CKEDITOR.replace('question_group_description', {
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
