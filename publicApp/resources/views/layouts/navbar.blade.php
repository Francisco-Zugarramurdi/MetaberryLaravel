
@extends('layouts.app')

    @if(session()->has('authenticated'))
    <header>

        <nav>

            <div class="log-in-header-nav-container-1">

                <a class="profile-image" href="/user"><img src="http://127.0.0.1:8005/img/public_images/{{$data['photo']}}"></a>
                <a href="/user" class="username">{{$data['name']}}</a>
                <a href="/"><span class="material-symbols-outlined">star</span></a>
                <a href="/"><span class="material-symbols-outlined">scoreboard</span></a>
                <a href="/"><span class="material-symbols-outlined">notifications</span></a>

            </div>

            <a href="/" class="nav-logo"><img src="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2020.png"></a>

            <div class="log-in-header-nav-container-2">

                <form action="" class="nav-searchbar">

                    <input type="text" placeholder="Search..." name="search">
                    <button type="submit"><span class="material-symbols-outlined">search</span></button>

                </form>

            </div>

        </nav>

    </header>
    @else
    <header>

        <nav>

            <div class="header-nav-container-1">

                <a href="/"><img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2019.png?raw=true"></a>
                <a href="/scores">Scores</a>

            </div>

            <div class="header-nav-container-2">

                <a href="/login" class="login-btn">Login</a>
                <a href="/signup" class="signup-btn">Create an Account</a>

            </div>

        </nav>

    </header>
    @endif