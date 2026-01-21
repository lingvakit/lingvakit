<div class="widget has-shadow">
    <div class="widget-header bordered no-actions d-flex align-items-center justify-content-between">
        <h4>Группа вопросов [{{ $questionGroupDto->getType()->getValue() }}]</h4>
        <a href="{{route('questionGroup.edit', [$course, $stage, $quiz, $questionGroupDto->getUuid()])}}"
           type="button"
           class="btn btn-primary mr-1 mb-2"
        >Редактировать группу</a>
    </div>
    <div class="widget-body">
        <div class="row flex-row">
            <div class="col-xl-12">
                {{-- Question Title --}}
                <div class="about-infos d-flex flex-column mb-3">
                    <div class="about-title"><h5>Общий вопрос для группы (описание группы):</h5></div>
                    <div class="about-text">{!! $questionGroupDto->getTitle() !!}</div>
                </div>
{{--                @if($question->image)--}}
{{--                    --}}{{-- Question Image --}}
{{--                    <div class="form-group">--}}
{{--                        <img src="{{ $question->getImage() }}" width="300" alt="{{ $question->title }}">--}}
{{--                    </div>--}}
{{--                @endif--}}

                {{-- Question Audios[] --}}
{{--                @if($question->audios)--}}
{{--                    @foreach($question->audios as $audio)--}}
{{--                        <div class="about-infos d-flex flex-column mb-3">--}}
{{--                            <div class="about-text">--}}
{{--                                <audio src="{{$audio->getAudio()}}" preload="auto" controls></audio>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                @endif--}}
            </div>
        </div>
    </div>
</div>
