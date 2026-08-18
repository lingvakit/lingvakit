<div class="topbar primary-bg topbar-padding">
    <div class="container">
        <div class="topbar-left-items">
            <ul class="toplist toppadding pull-left paddtop1">
                <li><a href="tel:+79856483542">+7 (985) 648-35-42</a></li>
            </ul>
        </div>
        <!--end left-->

        <div class="topbar-right-items pull-right">
            <ul class="toplist toppadding">
                @auth()
                    <li>
                        <a href="{{route('site.learning')}}">Личный кабинет</a>
                    </li>
                @else
                    <li class="lineright">
                        <a href="{{route('login')}}">Войти</a>
                    </li>
                    <li class="lineright">
                        <a href="{{route('register')}}">Регистрация</a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div id="header">
    <div class="container">
        <div class="navbar navbar-default yamm">
            <div class="navbar-header">
                <button type="button" data-toggle="collapse" data-target="#navbar-collapse-grid"
                        class="navbar-toggle two three">
                    <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button>
                <a href="{{url('/')}}" class="navbar-brand">
                    <img src="{{asset('assets/site/img/logo.svg')}}" alt="Лингва-Кит"/>
                </a>
            </div>
            <div id="navbar-collapse-grid" class="navbar-collapse collapse pull-right">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{route('site.about')}}">Обо мне</a>
                    </li>
                    <li>
                        <a href="{{route('site.reviews')}}">Отзывы</a>
                    </li>
                    <li>
                        <a href="{{route('site.learning')}}" class="dropdown-toggle">Курсы</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--end menu-->
<div class="clearfix"></div>