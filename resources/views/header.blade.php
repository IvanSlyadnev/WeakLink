<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{route('index')}}">
            Главная старница
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                <div class="">
                    <a href="{{route('user.index')}}">
                        <button class="btn btn">Пользователи</button>
                    </a>
                    <a href="{{route('question.index')}}">
                        <button class="btn btn">Вопросы</button>
                    </a>
                </div>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
            </ul>
        </div>
    </div>
</nav>
