@extends('layouts.new-app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/promo-site/js/masterslider/style/masterslider.css')}}"/>
    <link href="{{ asset('assets/promo-site/js/animations/css/animations.min.css')}}" rel="stylesheet" type="text/css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('assets/promo-site/js/cubeportfolio/cubeportfolio.min.css')}}">
    <link href="{{ asset('assets/promo-site/js/owl-carousel/owl.carousel.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/promo-site/js/ytplayer/ytplayer.css')}}"/>
    <link href="https://vjs.zencdn.net/8.3.0/video-js.css" rel="stylesheet"/>
@endsection

@section('scripts')
    <script src="{{ asset('assets/promo-site/js/masterslider/masterslider.min.js')}}"></script>
    <script type="text/javascript">
        (function ($) {
            "use strict";
            var slider = new MasterSlider();
            // adds Arrows navigation control to the slider.
            slider.control('arrows');
            slider.control('bullets');

            slider.setup('masterslider', {
                width: 1600,    // slider standard width
                height: 650,   // slider standard height
                space: 0,
                speed: 45,
                layout: 'fullwidth',
                loop: true,
                preload: 0,
                autoplay: true,
                view: "parallaxMask"
            });
        })(jQuery);
    </script>
    <script src="{{ asset('assets/promo-site/js/owl-carousel/owl.carousel.js')}}"></script>
    <script src="{{ asset('assets/promo-site/js/owl-carousel/custom.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/promo-site/js/ytplayer/jquery.mb.YTPlayer.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/promo-site/js/ytplayer/elementvideo-custom.js')}}"></script>
    <script type="text/javascript" src="{{ asset('assets/promo-site/js/ytplayer/play-pause-btn.js')}}"></script>
    <script type="text/javascript"
            src="{{ asset('assets/promo-site/js/progress-circle/jquery.circlechart.js')}}"></script>
    <script src="{{ asset('assets/promo-site/js/animations/js/animations.min.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/promo-site/js/animations/js/appear.min.js')}}" type="text/javascript"></script>

    <script src="https://vjs.zencdn.net/8.3.0/video.min.js"></script>
@endsection

@section('content')
    <!-- Hero -->
    <div class="master-slider ms-skin-default" id="masterslider">
        <div class="ms-slide slide-2" data-delay="9">
            <img src="{{ asset('assets/promo-site/js/masterslider/blank.gif') }}"
                 data-src="{{ asset('assets/promo-site/images/sliders/masterslider/slide1.jpg') }}" alt=""/>

            <h3 class="ms-layer text58"
                style="left: 230px;top: 200px;font-family: 'Nunito', sans-serif;"
                data-type="text"
                data-delay="500"
                data-ease="easeOutExpo"
                data-duration="1230"
                data-effect="scale(1.5,1.6)">ЛИНГВАКИТ</h3>

            <h3 class="ms-layer text59"
                style="left: 230px;top: 275px;font-family: 'Nunito', sans-serif;"
                data-type="text"
                data-delay="1000"
                data-ease="easeOutExpo"
                data-duration="1230"
                data-effect="scale(1.5,1.6)">Школа китайского языка 中文学校</h3>

            <a href="{{route('site.learning')}}"
               class="ms-layer sbut1"
               style="left: 230px; top: 420px;"
               data-type="text"
               data-delay="1500"
               data-ease="easeOutExpo"
               data-duration="1200"
               data-effect="scale(1.5,1.6)"> Выбрать курс </a>

            <a href="#testimonials"
               class="ms-layer sbut2"
               style="left: 430px; top: 420px;"
               data-type="text"
               data-delay="1500"
               data-ease="easeOutExpo"
               data-duration="1200"
               data-effect="scale(1.5,1.6)"> Отзывы </a>
        </div>
    </div>
    <div class="clearfix"></div>


    {{-- About me --}}
    <section class="sec-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-xs-12 bmargin">
                    <h3 class="uppercase less-mar2">
                        Меня зовут <span class="text-orange-2">Алёна Пристинская</span>
                    </h3>
                    <div class="clearfix"></div><br/>

                    <p>
                        Я преподаю китайский язык 23 года, дважды становилась «Учителем года», прошла стажировки в
                        ведущих университетах Китая. Моя онлайн-школа «ЛИНГВАКИТ» — это место, где китайский становится
                        живым и логичным, а подготовка к экзаменам приносит реальные результаты.
                    </p><br/>

                    <a href="{{route('site.about')}}" class="btn btn-orange-2 dark btn-round">Обо мне подробнее...</a>
                </div>

                <div class="col-md-6 col-sm-12 col-xs-12 bmargin">
                    <img src="{{ asset('assets/promo-site/images/teachers/teacher1.jpg') }}"
                         alt="Преподаватель китайского языка - Алёна Пристинская"
                         class="img-responsive"
                    />
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>

    {{-- Reviews --}}
    <section class="sec-padding testimonials" id="testimonials">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h1 class="paddtop1 dosis font-weight-5 lspace-sm">Отзывы наших студентов</h1>
                    <div class="title-line-4 align-center"></div>
                </div>

                <div class="col-md-4 col-sm-6 mb-5">
                    <div class="item">
                        <div class="text-box" style="height: auto">
                            <p class="collapsed">
                                Дочь в этом году закончила первый год обучения в школе «ЛИНГВАКИТ» и сдала экзамен HSK1
                                на максимальные 200 баллов. Всё благодаря профессиональному, творческому и
                                индивидуальному подходу преподавателя Алёны Алексеевны. Наши дети не только учат язык,но
                                и погружаются в культуру Китая, ее особенности, праздники, обычаи. Обучение не
                                постоянная скучная зубрежка, а интересное увлечение.<br>

                                В мае этого года моя дочь ездила в составе учебного лагеря Алёны Алексеевны в Сиань.
                                Ребята получили возможность прикоснуться к живому китайскому языку и своими глазами
                                увидеть другой мир. Тут не передать словами эмоции наши и ребенка. Поездка включала не
                                только обучение и живое общение с китайскими преподавателями в университете, а так же
                                посещение достопримечательностей, китайскую кухню, театр теней, центр изучения панд и
                                многое другое. После поездки дочь постоянно говорит, что хочет вновь посетить Китай.<br>

                                В конце учебного года в школе «ЛИНГВАКИТ» по традиции выпускной с интересными заданиями,
                                конкурсами, сладким столом, а так же вручение сертификатов.<br>

                                Алёна Алексеевна, спасибо Вам большое за то, что вкладываете душу в свою работу,
                                бесконечную любовь к детям и к своему делу!!!
                            </p>
                            <a href="#" class="text-orange-2 read-more">Показать больше</a>
                        </div>

                        <div class="image">
                            <img src="{{asset('assets/promo-site/images/reviews/review26.jpg')}}" alt/>
                        </div>
                        <div class="info">
                            <h5 class="less-mar1">Ольга Сергеевна Бирюкова и ее дочь Александра (12 лет)</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mb-5">
                    <div class="item">
                        <div class="text-box" style="height: auto">
                            <p class="collapsed">
                                Уважаемая Алёна Алексеевна! Наша семья хочет выразить Вам благодарность за обучение
                                китайскому языку нашего сына — Цепелева Дмитрия. Мы с Вами уже 2 года, два успешно
                                сданных теста HSK.
                                Программа выстроена логично — от простого к сложному, нет ощущения "сухости" — много
                                практики, диалогов, прививается любовь к иероглифам через каллиграфию, приятные сюрпризы
                                и подарки детям из Китая.<br>

                                Отдельная благодарность Вам за организацию поездки в Китай, где дети жили и общались с
                                носителями языка, узнали много о культуре и традициях Китая, научились разным приёмам в
                                изучении языка. С абсолютной уверенностью и легкостью, мне как родителю, было несложно
                                доверить Вам сына, зная то, что поездка будет для него мега-увлекательной и
                                познавательной и послужит мотивацией для дальнейшего изучения языка.
                            </p>
                            <a href="#" class="text-orange-2 read-more">Показать больше</a>
                        </div>

                        <div class="image">
                            <img src="{{asset('assets/promo-site/images/reviews/review27.jpg')}}" alt/>
                        </div>
                        <div class="info">
                            <h5 class="less-mar1">Виктория Валерьевна Цепелева и ее сын Дмитрий (13 лет)</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6 mb-5">
                    <div class="item">
                        <div class="text-box" style="height: auto">
                            <p class="collapsed">
                                Я благодарна, за Ваш креативный подход к обучению. Ребёнку, очень интересно изучать
                                китайский язык. Вы погружаете детей в Китайскую культуру, организовывая поездки в
                                языковой лагерь, организовывая занятия в интересных форматах.<br>

                                Ребёнок не просто изучает китайский язык, а знакомиться с культурой, поездка в Сиань
                                оставила очень приятные воспоминания. Понравилось, что ребёнок мог практиковать свои
                                знания с носителями языка, понравилось посещение достопримечательностей города, особенно
                                экскурсия в музей Терракотовой армии, также интересно было попробовать традиционную
                                китайскую кухню.
                            </p>
                            <a href="#" class="text-orange-2 read-more">Показать больше</a>
                        </div>

                        <div class="image">
                            <img src="{{asset('assets/promo-site/images/reviews/review28.jpg')}}" alt/>
                        </div>
                        <div class="info">
                            <h5 class="less-mar1">Майя Мусаева и ее дочь Сабина (16 лет)</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-5">
                <a href="{{route('site.reviews')}}" class="sh-btn sh-btn-orange sh-btn-medium sh-btn-round margin">
                    Больше отзывов
                </a>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>

    <section class="sec-tpadding-2">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2 class="section-title">Как я учу?</h2>
                    <p class="sub-title-left">
                        Главное, что отличает мои занятия, — <span class="text-orange-2">это опора на понимание</span>,
                        а не на заучивание.
                    </p>
                    <div class="clearfix"></div>
                    <div class="feature-box9 text-center active">
                        <div class="iconbox-smedium round left grayoutline2"><span class="icon-piechart"></span></div>
                        <div class="text-box-right">
                            <h4>Иероглифы с историей</h4>
                            <p>
                                Вместо заучивания иероглифов — я объясняю их происхождение, ключи и эволюцию, чтобы
                                каждый знак становился не набором чёрточек, а историей.
                            </p>
                        </div>
                    </div>
                    <br/>
                    <br/>

                    <div class="feature-box9 text-center active">
                        <div class="iconbox-smedium round left grayoutline2"><span class="icon-piechart"></span></div>
                        <div class="text-box-right">
                            <h4>Грамматика в контексте</h4>
                            <p>
                                Вместо сухих правил — я вплетаю грамматику в реальные диалоги и культурные контексты,
                                чтобы ученик не просто знал правило, а чувствовал, как и когда его применять.
                            </p>
                        </div>
                    </div>
                    <br/>
                    <br/>

                    <div class="feature-box9 text-center active">
                        <div class="iconbox-smedium round left grayoutline2"><span class="icon-piechart"></span></div>
                        <div class="text-box-right">
                            <h4>Запоминание через игру</h4>
                            <p>
                                Вместо механических упражнений — я использую ассоциации, мнемотехники и игры, которые
                                делают запоминание естественным и долгосрочным.
                            </p>
                        </div>
                    </div>
                    <br/>
                    <br/>

                    <div class="feature-box9 text-center active">
                        <div class="iconbox-smedium round left grayoutline2"><span class="icon-piechart"></span></div>
                        <div class="text-box-right">
                            <h4>Индивидуальный подход</h4>
                            <p>
                                Для каждого ученика — я подбираю темп и материал, потому что взрослые и дети, начинающие
                                и продолжающие требуют разного подхода. У меня есть программы для всех возрастов и
                                уровней.
                            </p>
                        </div>
                    </div>
                    <br/>
                    <br/>

                    <p>
                        Такой подход даёт результат: ученики не боятся говорить, сдают экзамены с высокими баллами и
                        продолжают учиться дальше уже с интересом, а не потому что их заставляют.
                    </p>

                    <br/>
                    <br/>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-5 col-sm-12 col-xs-12">
                    <div class="img-holder">
                        <img src="{{asset('assets/promo-site/images/ch_teacher1.jpg')}}"
                             alt=""
                             class="img-responsive"/>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>

    <section class="sec-padding testimonials">
        <div class="container">
            <div class="row">

                <div class="col-xs-12 text-center">
                    <h1 class="paddtop1 dosis font-weight-5 lspace-sm">Мои курсы</h1>
                    <div class="title-line-4 align-center"></div>
                </div>


                <div class="col-md-8">
                    <h3 class="section-title">Вводный фонетический курс</h3>
                    <p>Для тех, кто совсем с нуля. 8 занятий, на которых мы ставим произношение, разбираем тоны и
                        осваиваем первые слова и фразы. Это база, без которой двигаться дальше невозможно.</p>
                    <br/>
                    <br/>
                    <a class="btn btn-border orange-2 btn-round" href="{{route('site.learning')}}">Еще больше здесь</a>
                </div>
                <br/><br/>

                <div class="col-md-4">
                    <img src="{{asset('assets/promo-site/images/courses/01.jpeg')}}" alt="" class="img-responsive"/>
                </div>
                <br/>
                <br/>
                <br/>
                <br/>
                <div class="clearfix"></div>
                <div class="divider-line2"></div>
                <br/>
                <br/>
                <br/>
                <br/>

                <div class="col-md-4">
                    <img src="{{asset('assets/promo-site/images/courses/02.jpeg')}}" alt="" class="img-responsive"/>
                </div>
                <div class="col-md-8">
                    <h3 class="section-title">Основные курсы HSK‑1, HSK‑2, HSK‑3, HSK-4.</h3>
                    <p>Программы, полностью соответствующие новому формату экзамена. Каждый курс включает видеолекции с
                        моими подробными разборами, живые онлайн‑уроки в мини‑группах (до 7 человек), интерактивные
                        задания и проверку домашних работ. Доступ к материалам сохраняется навсегда.</p>
                    <br/>
                    <br/>
                    <a class="btn btn-border orange-2 btn-round" href="{{route('site.learning')}}">Еще больше здесь</a>
                </div>
                <br/>
                <br/>
                <br/>
                <br/>
                <div class="clearfix"></div>
                <div class="divider-line2"></div>
                <br/>
                <br/>
                <br/>
                <br/>

                <div class="col-md-8">
                    <h3 class="section-title">Курс «Пишу иероглифы красиво»</h3>
                    <p>Это мой авторский мини‑курс для тех, кто хочет разобраться с логикой иероглифов. 6 уроков, в
                        которых я рассказываю истории ключей, показываю, как менялись знаки на протяжении тысячелетий, и
                        даю простые приёмы для их запоминания.</p>
                    <br/>
                    <br/>
                    <a class="btn btn-border orange-2 btn-round" href="{{route('site.learning')}}">Еще больше здесь</a>
                </div>
                <br/><br/>

                <div class="col-md-4">
                    <img src="{{asset('assets/promo-site/images/courses/03.jpeg')}}" alt="" class="img-responsive"/>
                </div>
                <br/>
                <br/>
                <br/>
                <br/>
                <div class="clearfix"></div>
                <div class="divider-line2"></div>
                <br/>
                <br/>
                <br/>
                <br/>

                <div class="col-md-4">
                    <img src="http://placehold.it/300x300" alt="" class="img-responsive"/>
                </div>
                <div class="col-md-8">
                    <h3 class="section-title">Что дальше?</h3>
                    <p>Если вы хотите попробовать, познакомиться с моим подходом и понять, подходит ли он вам или вашему
                        ребёнку — напишите мне. Я отвечу на все вопросы, расскажу о ближайших группах и наборах</p>
                    <br/>
                    <br/>
                    <a class="btn btn-border orange-2 btn-round"
                       href="mailto:info@lingva-kit.ru"
                       target="_blank"
                    >Написать</a>
                </div>
                <br/>
            </div>
        </div>
    </section>
    <!--end section -->
    <div class="clearfix"></div>


    {{-- Documents --}}
    <section class="sec-padding testimonials">
        <div class="container">
            <div class="col-12 text-center">
                <h1 class="paddtop1 dosis font-weight-5 lspace-sm">Документы</h1>
                <div class="title-line-4 align-center"></div>

                <h4>
                    <a href="{{asset("documents/2026-2027/01 Договор-оферта ЛИНГВАКИТ 2026.docx")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Договор-оферта ЛИНГВАКИТ 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/02 РП ЛИНГВАКИТ-2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        РП ЛИНГВАКИТ 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/03-Политика в области персональных данных 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Политика в области персональных данных 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/04-Правила внутреннего распорядка обучающегося 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Правила внутреннего распорядка обучающегося 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/05-Правила внутреннего трудового распорядка для работников ИП 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Правила внутреннего трудового распорядка для работников ИП 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/06-Положение о режиме занятий обучающихся 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Положение о режиме занятий обучающихся 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/07-Формы, периодичность и порядок текущего контроля успеваемости и промежуточной аттестации обучающихся 2026 .pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Формы, периодичность и порядок текущего контроля успеваемости и промежуточной аттестации обучающихся 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/08-Положение о порядке и основаниях перевода, отчисления и восстановления обучающихся 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Положение о порядке и основаниях перевода, отчисления и восстановления обучающихся 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/09-Правила приема на обучение по программам дополнительного образования 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Правила приема на обучение по программам дополнительного образования 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/10-Положение о порядке и основаниях перевода, отчисления и восстановления обучающихся 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Положение о порядке и основаниях перевода, отчисления и восстановления обучающихся 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/11-Правила оказания платных образовательных услуг 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Правила оказания платных образовательных услуг 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/12-Об утверждении стоимости обучения 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Об утверждении стоимости обучения 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/13-Договор_Несовершеннолетние оказания_дистанционных_образовательных_услуг_ ИП_Пристинская 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Договор "Несовершеннолетние" оказания дистанционных образовательных услуг ИП Пристинская 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/14-Договор Совершеннолетние_оказания_дистанционных_образовательных_услуг_ИП_Пристинская 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Договор "Совершеннолетние" оказания дистанционных образовательных услуг ИП Пристинская 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/16-Отчет о результатах самообследования Индивидуального предпринимателя Пристинской А.А. 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Отчет о результатах самообследования Индивидуального предпринимателя Пристинской А.А. 2026
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/17-1-приказ об отчислении 2026.docx")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Приказ об отчислении 02.2026 г.
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/17-2-об отчислении 2026-avg.docx")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Приказ об отчислении 03.2026 г.
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/17-3-об отчислении 2026.docx")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Приказ об отчислении 04.2026 г.
                    </a>
                </h4>

                <h4>
                    <a href="{{asset("documents/2026-2027/03-Политика в области персональных данных 2026.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Приказ о зачислении от 26 августа 2025 г.
                    </a>
                </h4>

                <div style="margin-bottom: 100px;"></div>

                <h2 class="font-weight-5">ИП Пристинская Алена Алексеевна</h2>
                <h2 class="font-weight-5" style="margin-bottom: 50px; line-height: 1.2">
                    Лицензия на образовательную деятельность<br>№ ЛО35-01235-50/00956971 от
                    30.11.2023
                </h2>

                <h4 style="margin-bottom: 100px;">
                    <a href="{{route('site.documents-list')}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Сведения об образовательной организации
                    </a>
                </h4>

                <h3>ИНН 280111660440</h3>
                <h3 style="margin-bottom: 50px;">ОГРНИП 320508100275828</h3>

                <h4 style="margin-bottom: 100px;">
                    <a href="{{asset("documents/offer_agreement_lingvakit.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Публичная оферта — только для партнеров
                    </a>
                </h4>
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection