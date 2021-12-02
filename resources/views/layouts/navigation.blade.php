@php($currentUrl = Request::segment(1))
<div class="ui secondary  menu">
    <a class="item" href="/">
        Home
    </a>
    @if($currentUrl === "task")
        <a class="item active" href="{{route('task.index')}}">
            Tasks
        </a>
        <a href="{{route('task.create')}}" class="item">
            <button type="button" class="ui teal basic button">
                Добавить
            </button>
        </a>
    @else
        <a class="item" href="{{route('task.index')}}">
            Tasks
        </a>
    @endif
    <div class="right menu">
        <div class="item">
            <a class="ui item">
                @if (Route::has('login'))
                    @auth
                            <div class="ui basic blue button">
                                <div class="ui inline dropdown">
                                    <div class="text">
                                        <img class="ui avatar image" src="{{auth()->user()->profile_photo_path}}">
                                        {{auth()->user()->name}}
                                    </div>
                                    <i class="dropdown icon"></i>
                                    <div class="menu">
                                        <div class="item">
                                            <form action="{{route('user.logout')}}">
                                                <button class="ui red basic button">Выйти</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @else
                        <script async src="https://telegram.org/js/telegram-widget.js?15"
                                data-telegram-login="ParserMarketPlaceBot" data-size="medium"
                                data-auth-url="telegram_auth"></script>
                    @endauth
                @endif
            </a>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        $('.ui .dropdown').dropdown();
    };
</script>
