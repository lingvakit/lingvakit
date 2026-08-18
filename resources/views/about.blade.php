@extends('layouts.new-app')

@section('content')
    <section>
        <div class="header-inner two">
            <div class="inner text-center">
                <h4 class="title text-white uppercase">Обо мне</h4>
            </div>
            <div class="overlay bg-opacity-5"></div>
            <img src="{{asset('assets/promo-site/images/reviews-bg.jpg')}}" alt="" class="img-responsive"/></div>
    </section>
    <div class="clearfix"></div>

    <section>
        <div class="pagenation-holder">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Отзывы клиентов</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <div class="pagenation_links">
                            <a href="{{route('site.index')}}">Главная</a><i> / </i>
                            Обо мне
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>

    <section class="sec-tpadding-2">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 text-center">
                    <h2 class="section-title">Обо мне</h2>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <div class="clearfix"></div>

    <section class="sec-bpadding-2 mt-1">
        <div class="container">
            <div class="row">
                <div class="col-md-6 bmargin nopadding ">
                    <img src="{{ asset('assets/promo-site/images/teachers/teacher1.jpg') }}"
                         alt="Преподаватель китайского языка - Алёна Пристинская"
                         class="img-responsive"
                    />
                </div>

                <div class="col-md-6 bmargin padding-left-5">
                    <div class="item-holder">
                        <p>Здравствуйте!</p>

                        <p>Я окончила Благовещенский педагогический университет по специальности «учитель иностранных
                            языков (английский, китайский) в 2005 году. Преподавала в школе 10 лет, а затем полностью
                            сосредоточилась на своей частной практике.</p>

                        <p>Сейчас я веду онлайн‑занятия и разрабатываю собственные курсы.</p>

                        <p>Ежегодно повышаю квалификацию: проходила обучение в Пекинском университете языка и культуры,
                            Шаньдунском педагогическом университете, изучала методику преподавания китайского как
                            иностранного на различных курсах в китайских университетах.</p>

                        <p>Постоянно участвую в вебинарах и семинарах по преподаванию китайского языка, слежу за
                            изменениями в формате экзамена HSK и обновляю свои программы в соответствии с новыми
                            требованиями.</p><br>

                        <p>
                            <strong>Моя миссия — показать, что китайский язык доступен каждому, кто готов увидеть за
                                иероглифами логику, культуру и живую историю. Не талант, а интерес и правильный подход
                                ведут к результату.</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>

    <section class="sec-padding">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 text-center">
                    <h2 class="section-title">
                        Дипломы и сертификаты
                    </h2>
                </div>

                <div class="col-md-4 col-sm-6 mt-2">
                    <div class="team-holder7 two bmargin">
                        <div class="team-member">
                            <img src="{{asset('assets/promo-site/images/certificates/cert1.jpg')}}"
                                 alt=""
                                 class="img-responsive"
                            />
                        </div>
                        <div class="info-box text-center">
                            <h4 class="uppercase oswald font-weight-3 less-mar2">
                                Certificate of Achievement
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mt-2">
                    <div class="team-holder7 two bmargin">
                        <div class="team-member">
                            <img src="{{asset('assets/promo-site/images/certificates/cert2.jpg')}}"
                                 alt=""
                                 class="img-responsive"
                            />
                        </div>
                        <div class="info-box text-center">
                            <h4 class="uppercase oswald font-weight-3 less-mar2">
                                Grade Transcrypt
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mt-2">
                    <div class="team-holder7 two bmargin">
                        <div class="team-member">
                            <img src="{{asset('assets/promo-site/images/certificates/cert6.jpg')}}"
                                 alt=""
                                 class="img-responsive"
                            />
                        </div>
                        <div class="info-box text-center">
                            <h4 class="uppercase oswald font-weight-3 less-mar2">
                                Certificate of Completion
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mt-2">
                    <div class="team-holder7 two bmargin">
                        <div class="team-member">
                            <img src="{{asset('assets/promo-site/images/certificates/cert3.jpg')}}"
                                 alt=""
                                 class="img-responsive"
                            />
                        </div>
                        <div class="info-box text-center">
                            <h4 class="uppercase oswald font-weight-3 less-mar2">
                                Certificate of Completion
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mt-2">
                    <div class="team-holder7 two bmargin">
                        <div class="team-member">
                            <img src="{{asset('assets/promo-site/images/certificates/cert4.jpg')}}"
                                 alt=""
                                 class="img-responsive"
                            />
                        </div>
                        <div class="info-box text-center">
                            <h4 class="uppercase oswald font-weight-3 less-mar2">
                                Certificate of Completion
                            </h4>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mt-2">
                    <div class="team-holder7 two bmargin">
                        <div class="team-member">
                            <img src="{{asset('assets/promo-site/images/certificates/cert5.jpg')}}"
                                 alt=""
                                 class="img-responsive"
                            />
                        </div>
                        <div class="info-box text-center">
                            <h4 class="uppercase oswald font-weight-3 less-mar2">
                                Удостоверение о повышении квалификации
                            </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection

@section('scripts')
    <script type="text/javascript"
            src="{{asset('assets/promo-site/js/cubeportfolio/jquery.cubeportfolio.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/promo-site/js/cubeportfolio/main.js')}}"></script>
@endsection