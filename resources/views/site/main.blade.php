@extends('layouts.new')

@section('content')
    <div class="navbar-container ">
        <nav class="navbar navbar-expand-lg justify-content-between navbar-light border-bottom-0 bg-white" data-sticky="top">
            <div class="container">
                <div class="col flex-fill px-0 d-flex justify-content-between">
                    <a class="navbar-brand mr-0 fade-page" href="index.html">
                        <img src="assets/img/logo.svg" alt="Leap">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                        <svg class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 17C3 17.5523 3.44772 18 4 18H20C20.5523 18 21 17.5523 21 17V17C21 16.4477 20.5523 16 20 16H4C3.44772 16 3 16.4477 3 17V17ZM3 12C3 12.5523 3.44772 13 4 13H20C20.5523 13 21 12.5523 21 12V12C21 11.4477 20.5523 11 20 11H4C3.44772 11 3 11.4477 3 12V12ZM4 6C3.44772 6 3 6.44772 3 7V7C3 7.55228 3.44772 8 4 8H20C20.5523 8 21 7.55228 21 7V7C21 6.44772 20.5523 6 20 6H4Z"
                                  fill="#212529" />
                        </svg>

                    </button>
                </div>






                <div class="collapse navbar-collapse justify-content-end col flex-fill px-0"><a href="#" class="btn btn-primary ml-lg-3">Войти</a>

                </div>
            </div>
        </nav>
    </div>

    <section class="has-divider">
        <div class="container">
            <div class="row align-items-center justify-content-between o-hidden">
                <div class="col-md-6 order-sm-2 mb-5 mb-sm-0" data-aos="fade-left">
                    <img src="assets/img/saas-3.svg" alt="Image">
                </div>
                <div class="col-md-6 pr-xl-5 order-sm-1">
                    <h1 class="display-4">User-Agent.cc</h1>
                    <p class="lead">Пожалуй, лучший сервис для идентификации пользователей на вашем сайте.</p>
                    <span class="text-small text-muted">Для получения логин-пароля напишите в телеграмм-бот <a href="https://t.me/uaidbot" target="_blank">uaidbot</a>
            </span>
                    <form class="d-sm-flex mb-2 mt-4" action="/tglogin" method="post">
                        @csrf
                        <input type="text" class="form-control form-control-lg mr-sm-2 mb-2 mb-sm-0" placeholder="Например, idISkskdl"  name="code">
                        <button class="btn btn-lg btn-primary" type="submit">Войти</button>
                    </form>
                    <span class="text-small text-muted">В следующий раз заходите используя этот же ключ-пароль. <br> Для смены пароля зайдите в бот и снова нажмите /start.
            </span>
                </div>
            </div>
        </div>

    </section>



    <section class="p-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-7 col-md-8 mb-lg-n7 layer-2">
                    <img src="assets/img/saas-1.svg" alt="Image" data-aos="fade-up">
                </div>
            </div>
        </div>
    </section>
    <section class="bg-primary text-light has-divider">
        <div class="divider flip-y">
            <svg width="100%" height="100%" version="1.1" viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="none">
                <path d="M0,0 C6.83050094,50 15.1638343,75 25,75 C41.4957514,75 62.4956597,0 81.2456597,0 C93.7456597,0 99.9971065,0 100,0 L100,100 L0,100" fill="#ffffff"></path>
            </svg>
        </div>
        <div class="container">
            <div class="row justify-content-center mb-0 mb-md-3">
                <div class="col-xl-6 col-lg-8 col-md-10 text-center">
                    <h3 class="h3">Напишите в telegramm bot = uaidbot</h3>
                </div>
            </div>
            <div class="row justify-content-center text-center">
                <div class="col-xl-6 col-lg-7 col-md-9">
                    <form class="d-md-flex mb-3 justify-content-center" action="/tglogin" method="post">
                        @csrf
                        <input type="text" class="mx-1 mb-2 mb-md-0 form-control form-control-lg" placeholder="dskIUhhhuk5" name="code">
                        <button class="mx-1 btn btn-primary-3 btn-lg" type="submit">Войти</button>
                    </form>
                    <div class="text-small text-muted mx-xl-6">
                        Для получения уникального ключа авторизации!
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="pb-4 bg-primary-3 text-light" id="footer">
        <div class="container">

            <div class="row mb-5">
                <div class="col-6 col-lg">
                    <h5>Контакты</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex">
                            <svg class="icon" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Icon For Marker#1</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect opacity="0" x="0" y="0" width="24" height="24"></rect>
                                    <path d="M5,10.5 C5,6 8,3 12.5,3 C17,3 20,6.75 20,10.5 C20,12.8325623 17.8236613,16.03566 13.470984,20.1092932 C12.9154018,20.6292577 12.0585054,20.6508331 11.4774555,20.1594925 C7.15915182,16.5078313 5,13.2880005 5,10.5 Z M12.5,12 C13.8807119,12 15,10.8807119 15,9.5 C15,8.11928813 13.8807119,7 12.5,7 C11.1192881,7 10,8.11928813 10,9.5 C10,10.8807119 11.1192881,12 12.5,12 Z"
                                          fill="#000000" fill-rule="nonzero"></path>
                                </g>
                            </svg>
                            <div class="ml-3">
                  <span>Татарстан,
                    г.Тетюши</span>
                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <svg class="icon" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Icon For Call#1</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect opacity="0" x="0" y="0" width="24" height="24"></rect>
                                    <path d="M11.914857,14.1427403 L14.1188827,11.9387145 C14.7276032,11.329994 14.8785122,10.4000511 14.4935235,9.63007378 L14.3686433,9.38031323 C13.9836546,8.61033591 14.1345636,7.680393 14.7432841,7.07167248 L17.4760882,4.33886839 C17.6713503,4.14360624 17.9879328,4.14360624 18.183195,4.33886839 C18.2211956,4.37686904 18.2528214,4.42074752 18.2768552,4.46881498 L19.3808309,6.67676638 C20.2253855,8.3658756 19.8943345,10.4059034 18.5589765,11.7412615 L12.560151,17.740087 C11.1066115,19.1936265 8.95659008,19.7011777 7.00646221,19.0511351 L4.5919826,18.2463085 C4.33001094,18.1589846 4.18843095,17.8758246 4.27575484,17.613853 C4.30030124,17.5402138 4.34165566,17.4733009 4.39654309,17.4184135 L7.04781491,14.7671417 C7.65653544,14.1584211 8.58647835,14.0075122 9.35645567,14.3925008 L9.60621621,14.5173811 C10.3761935,14.9023698 11.3061364,14.7514608 11.914857,14.1427403 Z"
                                          fill="#000000"></path>
                                </g>
                            </svg>
                            <div class="ml-3">
                                <span>+79377799906</span>

                            </div>
                        </li>
                        <li class="mb-3 d-flex">
                            <svg class="icon" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <title>Icon For Mail</title>
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect opacity="0" x="0" y="0" width="24" height="24"></rect>
                                    <path d="M5,6 L19,6 C20.1045695,6 21,6.8954305 21,8 L21,17 C21,18.1045695 20.1045695,19 19,19 L5,19 C3.8954305,19 3,18.1045695 3,17 L3,8 C3,6.8954305 3.8954305,6 5,6 Z M18.1444251,7.83964668 L12,11.1481833 L5.85557487,7.83964668 C5.4908718,7.6432681 5.03602525,7.77972206 4.83964668,8.14442513 C4.6432681,8.5091282 4.77972206,8.96397475 5.14442513,9.16035332 L11.6444251,12.6603533 C11.8664074,12.7798822 12.1335926,12.7798822 12.3555749,12.6603533 L18.8555749,9.16035332 C19.2202779,8.96397475 19.3567319,8.5091282 19.1603533,8.14442513 C18.9639747,7.77972206 18.5091282,7.6432681 18.1444251,7.83964668 Z"
                                          fill="#000000"></path>
                                </g>
                            </svg>
                            <div class="ml-3">
                                <a href="#">mail@natfullin.ru</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

@endsection
