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
    <section class="sec-padding testimonials">
        <div class="container">
            <div class="col-12 text-center">
                <h1 class="paddtop1 dosis font-weight-5 lspace-sm">Основные сведения</h1>
                <div class="title-line-4 align-center"></div>
                <h3 class="font-weight-5">ИП Пристинская Алена Алексеевна</h3>
                <h3 class="font-weight-5" style="margin-bottom: 50px; line-height: 1.2">
                    Лицензия на образовательную деятельность<br>№ ЛО35-01235-50/00956971 от
                    30.11.2023
                </h3>

                <h4 style="margin-bottom: 100px;">
                    <a href="{{asset("documents/01_Политика-в-области-персональных-данных.pdf")}}"
                       style="color: #0d75c1"
                       target="_blank">
                        Сведения об образовательной организации
                    </a>
                </h4>

                <h1 class="paddtop1 dosis font-weight-5 lspace-sm" style="margin-bottom: 100px">Документы</h1>
                <div class="text-left">
                    <h4>
                        <a href="{{asset("documents/01-dogovor-oferta.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Договор-оферта ЛингваКит
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/02-politika-v-oblasti-personalnyh-dannyh.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Политика в области персональных данных
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/03-rp.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            РП ЛингваКит
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/04-pravila-vnutrennego-rasporyadka-obuchayushchegosya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Правила внутреннего распорядка обучающегося (лингвакит)
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/05-pravila-vnutrennego-trudovogo-rasporyadka-dlya-rabotnikov-individualnogo-predprinimatelya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Правила внутреннего трудового распорядка для работников индивидуального предпринимателя
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/06-otchet-o-rezultatah-samoobsledovaniya-individualnogo-predprinimatelya-pristinskoĭ-aa.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Отчет о результатах самообследования Индивидуального предпринимателя Пристинской А.А.
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/07-polozhenie-o-rezhime-zanyatiĭ-obuchayushchihsya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Положение о режиме занятий обучающихся
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/08-formy-periodichnost-i-poryadok-tekushchego-kontrolya-uspevaemosti-i-promezhutochnoĭ-attestacii-obuchayushchihsya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Формы, периодичность и порядок текущего контроля успеваемости и промежуточной аттестации обучающихся
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/09-polozhenie-o-poryadke-i-osnovaniyah-perevoda-otchisleniya-i-vosstanovleniya-obuchayushchihsya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Положение о порядке и основаниях перевода, отчисления и восстановления обучающихся
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/10-pravila-priema-na-obuchenie-po-programmam-dopolnitelnogo-obrazovaniya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Правила приема на обучение по программам дополнительного образования
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/11-polozhenie-o-poryadke-i-osnovaniyah-perevoda-otchisleniya-i-vosstanovleniya-obuchayushchihsya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Положение о порядке и основаниях перевода, отчисления и восстановления обучающихся
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/12-pravila-okazaniya-platnyh-obrazovatelnyh-uslug.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Правила оказания платных образовательных услуг
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/13-ob-utverzhdenii-stoimosti-obucheniya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Об утверждении стоимости обучения
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/14-licenziya.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Лицензия
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/15-reestrovaya-vypiska.pdf")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Реестровая выписка
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/16-dogovor-okazaniya-distancionnyh-obrazovatelnyh-uslug-ip-pristinskaya.docx")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Договор оказания дистанционных образовательных услуг ИП Пристинская А.А.
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/17-prikaz-ob-otchislenii.docx")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Приказ об отчислении 8 сентября 2025 г.
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/18-prikaz-o-zachislenii.docx")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Приказ о зачислении 8 сентября 2025 г.
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/19-prikaz-o-zachislenii-26-avg.docx")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Приказ о зачислении от 26 августа 2025 г.
                        </a>
                    </h4>

                    <h4>
                        <a href="{{asset("documents/20-prikaz-o-zachislenii-ot-01-12.docx")}}"
                           style="color: #0d75c1"
                           target="_blank">
                            Приказ о зачислении от 1 декабря 2025 г.
                        </a>
                    </h4>
                </div>

            </div>
        </div>
    </section>
    <div class="clearfix"></div>
@endsection