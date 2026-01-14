<div class="widget has-shadow">
    <div class="widget-header bordered no-actions d-flex align-items-center">
        <h4>{{ __("cms-pages.question-form") }}</h4>
    </div>
    <div class="widget-body">

        {{-- Question: Title --}}
        <div class="form-group row d-flex align-items-center mb-5">
            <label class="col-lg-3 form-control-label">{{ __("cms-pages.question") }}<span
                        class="text-danger ml-2">*</span></label>
            <div class="col-lg-9">
                <textarea name="title" class="form-control" rows="8">{{old('title')}}</textarea>
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Question Font Size --}}
        <div class="form-group row d-flex align-items-center mb-5">
            <label class="col-lg-3 form-control-label">{{ __("cms-pages.font-size") }}</label>
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-xl-2">
                        <div class="mb-3">
                            <div class="styled-radio">
                                <input type="radio" name="font_size" id="normal" value="normal"
                                       checked>
                                <label for="normal">{{ __("cms-pages.font-normal") }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="mb-3">
                            <div class="styled-radio">
                                <input type="radio" name="font_size" id="large" value="large">
                                <label for="large">{{ __("cms-pages.font-large") }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2">
                        <div class="mb-3">
                            <div class="styled-radio">
                                <input type="radio" name="font_size" id="huge" value="huge">
                                <label for="huge">{{ __("cms-pages.font-huge") }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Question Image --}}
        <div class="form-group row d-flex align-items-center mb-5">
            <label class="col-lg-3 form-control-label">{{ __("cms-pages.main-image") }}</label>
            <div class="col-lg-9">
                <div class="form-group preview">
                    <div class="current-item">
                        <img src="{{asset('assets/cms/img/no-image.jpg')}}" width="240" alt>
                    </div>
                </div>
                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach" data-type="image"
                        data-var="question_image" data-toggle="modal" data-target="#modal-files">
                    {{__("cms-pages.choose")}}
                </button>
            </div>
        </div>

        {{-- Question Audio --}}
        <div class="form-group row d-flex align-items-center mb-5">
            <label class="col-lg-3 form-control-label">{{ __("cms-pages.audio") }}</label>
            <div class="col-lg-9">
                <div class="form-group preview"></div>
                <button type="button" class="btn btn-primary square mr-1 mb-2 btn-attach" data-type="audio"
                        data-var="question_audio" data-toggle="modal" data-target="#modal-files">
                    {{__("cms-pages.choose")}}
                </button>
            </div>
        </div>

        {{-- Question: Explanation --}}
        <div class="form-group row d-flex align-items-center mb-5">
            <label class="col-lg-3 form-control-label">{{ __("cms-pages.explanation") }}</label>
            <div class="col-lg-9">
                <textarea id="explanation" name="explanation" class="form-control"
                          rows="3">{{old('explanation')}}</textarea>
                @error('explanation')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

    </div>
</div>
