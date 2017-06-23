<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/component.css') }}" rel="stylesheet">
    <link href="{{ asset('css/normalize.css') }}" rel="stylesheet">
    <!-- Datepicker for Bootstrap -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/css/bootstrap-datepicker.min.css">
    <!-- font-awesome -->
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
      <div id="st-container" class="st-container container">
        <div class="st-pusher">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/home') }}">
                        {{ config('app.name', 'U2-System') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    @unless (Auth::guest())
                    <ul class="nav navbar-nav">
                        <li>
                          <a href="{{ action('ClientsController@create') }}">
                            新規登録
                          </a>
                        </li>
                        <li>
                          <a href="{{ action('RequestsController@index') }}">
                            依頼一覧
                          </a>
                        </li>
                    </ul>
                    @endunless

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li>
                              <a href="{{ route('login') }}">Login</a>
                            </li>
                            <li>
                              <a href="{{ route('register') }}">新規スタッフ登録</a>
                            </li>
                        @else
                          @if ( Auth::user()->role==1) {{-- @TODO config設定 定数--}}
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    リスト <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                  <li>
                                    <a href="{{ action('UsersController@index') }}">スタッフリスト</a>
                                  </li>
                                  <li>
                                    <a href="{{ action('BaseTypesController@index') }}">拠点リスト</a>
                                  </li>
                                  <li>
                                    <a href="{{ action('RoutesController@index') }}">流入サイトリスト</a>
                                  </li>
                                  <li>
                                    <a href="{{ action('ItemCategoriesController@index') }}">商品カテゴリーリスト</a>
                                  </li>
                                  <li>
                                    <a href="{{ action('ItemMakersController@index') }}">メーカーリスト</a>
                                  </li>
                                  <li>
                                    <a href="{{ action('CategoryMakerController@index') }}">カテゴリー・メーカーリスト</a>
                                  </li>
                                </ul>
                            </li>
                          @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                  @if ( Auth::user()->role==1) {{-- @TODO config設定 定数 1->マスター --}}
                                    <li>
                                      <a href="{{ route('register') }}">スタッフ登録</a>
                                    </li>
                                    <li>
                                      <a href="{{ action('BaseTypesController@create') }}">拠点登録</a>
                                    </li>
                                    <li>
                                      <a href="{{ action('RoutesController@create') }}">流入サイト登録</a>
                                    </li>
                                    <li>
                                      <a href="{{ action('ItemCategoriesController@create') }}">商品カテゴリー登録</a>
                                    </li>
                                    <li>
                                      <a href="{{ action('ItemMakersController@create') }}">メーカー登録</a>
                                    </li>
                                  @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            ログアウト
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @yield('content')
        </div><!-- /st-pusher -->
        @yield('search')
      </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/item_ctrl.js') }}"></script>
    <script src="{{ asset('js/classie.js') }}"></script>
    <script src="{{ asset('js/sidebarEffects.js') }}"></script>
    <script src="{{ asset('js/postal_code_to_address.js') }}"></script>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <!-- Datepicker for Bootstrap -->
     <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/js/bootstrap-datepicker.min.js"></script>
     <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.1/locales/bootstrap-datepicker.ja.min.js"></script>
    <!-- bootstrap-datepicker -->
     <script>
       $('.input-daterange').datepicker({
         format: "yyyy/mm/dd",
         language: "ja",
         autoclose: true, //日付選択で自動的にカレンダーを閉じる
         orientation:'bottom right' //カレンダーの位置
       });
     </script>

</body>
</html>
