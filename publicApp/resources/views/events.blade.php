<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}" />
    <link rel="icon"
        href="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/icon.ico">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('/assets/css/event-by-score-css.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Livescore - Events</title>
</head>
<body>

    @if(session()->has('authenticated')){
        @include('layouts.navbar',$data)
    }
    @else
        @include('layouts.navbar')
    @endif

<main>

    <section class="resultDisplay">
            <div class="event-container">

                <div class="event-holder">

                    <div class="team-holder">

                        <img src="http://127.0.0.1:8005/img/public_images/{{$info['teams'][0]['photo']}}" class="team-logo">
                        <a href="" class="team-name">{{$info['teams'][0]['name']}}</a>

                    </div>

                    <div class="score-holder">

                        <p class="event-score">{{$info['resultwin']}}</p>

                    </div>

                    <div class="team-holder">

                    <img src="http://127.0.0.1:8005/img/public_images/{{$info['teams'][1]['photo']}}" class="team-logo">
                    <a href="" class="team-name">{{$info['teams'][1]['name']}}</a>

                    </div>

                </div>

            </div>
    </section>

    <section class="innerNav">
        <ul>
            <li>Timeline</li>
        </ul>
    </section>

    <section class="display">
            <div class="renderArea">
                @foreach($info['result'] as $result)
                <div class="card">
                   
                    <div class="title">
                    
                        <p>Anotación: {{$result['teamName']}}</p>
                    </div>
                    <p class="info">{{$result['name']}} {{$result['surname']}} anoto: {{$result['point']}} </p>
                   
                </div>
                @endforeach
                @foreach($info['sanctions'] as $sanctions)
                <div class="card">
                    <div class="title">
                        <p>Penalization</p>
                        <p class="minuto">Minuto: {{$sanctions['minute']}}</p>
                    </div>
                    <p class="info">{{$sanctions['sanction']}} para {{$sanctions['name']}} {{$sanctions['surname']}}</p>
                </div>
                @endforeach
            </div>
                
        <div class="sideData">
            <div class="about">
                <h3>About the event<span class="material-symbols-outlined">
                        info
                    </span></h3>
                <p>{{$info['details']}}</p>
            </div>
        </div>
    </section>
</main>


    <footer>

        <img src="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2022white.png">

        <div class="texts">

            <a href="./index.html#aboutSection">How does it work?</a>
            <a href="./scores.html">Scores</a>

        </div>

        <p class="copyright">All Rights Reserved. 2022 Metaberry</p>

    </footer>

</body>

<script>
    
</script>



</html>