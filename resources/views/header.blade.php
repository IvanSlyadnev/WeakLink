<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{route('index')}}">
            Главная старница
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <div class="">
                    <a href="{{route('users.index')}}">
                        <button class="btn btn">Пользователи</button>
                    </a>
                    <a href="{{route('question.index')}}">
                        <button class="btn btn">Вопросы</button>
                    </a>
                    @if($game = \App\Models\Game::whereNull('winner_id')->first())
                        <a href="{{route('game.statistics', ['game' => $game->id])}}">
                            <button class="btn btn">Статстика игры</button>
                        </a>
                    @endif
                </div>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
            </ul>
        </div>
    </div>
</nav>
