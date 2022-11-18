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
                       <p class="event-score">{{$info['teams'][0]['points']}} - {{$info['teams'][1]['points']}}</p>
                    </div>

                    <div class="team-holder">

                    <img src="http://127.0.0.1:8005/img/public_images/{{$info['teams'][1]['photo']}}" class="team-logo">
                    <a href="" class="team-name">{{$info['teams'][1]['name']}}</a>

                    </div>

                </div>

            </div>
    </section>

    <section class="innerNav teams">
        <button type="button" id="timeline-btn">Timeline</button>
        <button type="button" id="lineup-btn">Lineup</button>
    </section>

    <section class="display">

            <div class="renderArea" id="timeline">
                @foreach($info['teams'] as $team)
                <div class="card">
                    <div class="title">
                        <p>Score</p>
                        <p>{{$team['name']}}</p>
                    </div>
                    @foreach($team['result'] as $result)
                    <p class="info">{{$result ['namePlayer']}} {{$result['surnamePlayer']}} scored {{$result['point']}} points </p>
                   @endforeach
                </div>
                @endforeach
                @foreach($info['sanctions'] as $sanctions)
                <div class="card">
                    <div class="title sanction">
                        <p>Penalization</p>
                        <p class="minuto">{{$sanctions['minute']}}'</p>
                    </div>
                    <p class="info">{{$sanctions['sanction']}} for {{$sanctions['name']}} {{$sanctions['surname']}}</p>
                </div>
                @endforeach

            </div>

            <div class="renderArea" id="lineup">

                @foreach($info['teams'] as $team)
                <div class="card team">
                    <div class="title"><p>{{$team['name']}} </p></div>
                        <ul>
                            @foreach($team['player'] as $player)
                            <li>
                                <img src="http://127.0.0.1:8005/img/public_images/{{$player['photo']}}" class="team-logo">  
                                <p>{{$player['name']}} {{$player['surname']}}</p>
                            </li>
                            @endforeach
                        </ul>
                </div>
                @endforeach

            </div>
                
            <div class="sideData">
                <div class="sideData">
                    <div class="about">
                        <h3>About the event<span class="material-symbols-outlined">info</span></h3>
                        <div class="details-container">
                            <p class="details-data">Event Date</p>
                            <p class="details">{{$info['date']}}</p>
                        </div>
                        <div class="title-container">
                            <p class="title-data">Event Name</p>
                            <p class="title">{{$info['name']}}</p>
                        </div>
                        <div class="details-container">
                            <p class="details-data">Event Details</p>
                            <p class="details">{{$info['details']}}</p>
                        </div>
                        @if(session()->has('authenticated'))
                        <form method="POST" action="/user/follow">
                            @csrf
                            <input type="hidden" name="event_id" value="{{$info['id']}}">
                            <button type="submit" class="follow-event">Follow event</button>
        
                        </form>
                        @endif
                    </div>
                    <div class="ads">
                        <div class="desktopAds" id="Small"></div>
                        <div class="mobileAds" id="Small"></div>
                    </div>
                </div>
            <div class="ads">
                <div class="desktopAds" id="Small"></div>
                <div class="mobileAds" id="Small"></div>
            </div>
        </div>
    </section>
</main>

<script>

    $(document).ready(function(){

        $("#lineup").hide();

    });

    $("#timeline-btn").click(function(){

        if($("#lineup").is(":hidden")){

            $("#lineup").show();
            $("#timeline").hide();

        }else if($("#lineup").is(":visible")){

            $("#timeline").show();
            $("#lineup").hide();

        }

    });

    $("#lineup-btn").click(function(){

        if($("#timeline").is(":hidden")){

            $("#timeline").show();
            $("#lineup").hide();

        }else if($("#timeline").is(":visible")){

            $("#lineup").show();
            $("#timeline").hide();

        }

    });

</script>

@if(!session()->has('user_sub'))
        <script>
            jQuery(document).ready(function() {

                if(window.innerWidth > 768){
                
                    let ads = document.getElementsByClassName("desktopAds")
                    Object.keys(ads).forEach(ad=>{
                        
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        })
                        jQuery.ajax({
                            url: "{{ url('http://localhost:8003/api/ad/') }}",
                            method: 'POST',
                            data: {
                                size: ads[ad].id,
                                tag: "{{$info['sport']}}"
                            },

                            success: function(adResult) {
                                
                                if(adResult != "Error, no ads available"){
                                    ads[ad].innerHTML = `
                                    <a href="${adResult.url}" target="_blank"><img src="http://127.0.0.1:8005/img/public_images/${adResult.image}"></a>
                                    `
                                }
                            }
                        });
                        
                    
                    })

                    let mobileAds = document.getElementsByClassName("mobileAds")
                    Object.keys(mobileAds).forEach(ad=>{
                        mobileAds[ad].style.display = "none";
                    })

                }else{
                    let ads = document.getElementsByClassName("mobileAds")
                    Object.keys(ads).forEach(ad=>{
                        
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        })
                        jQuery.ajax({
                            url: "{{ url('http://localhost:8003/api/ad/') }}",
                            method: 'POST',
                            data: {
                                size: ads[ad].id,
                                tag: "{{$info['sport']}}"
                            },

                            success: function(adResult) {
                               
                                if(adResult != "Error, no ads available"){
                                    ads[ad].innerHTML = `
                                    <a href="${adResult.url}" target="_blank"><img src="http://127.0.0.1:8005/img/public_images/${adResult.image}"></a>
                                    `
                                }   
                            }
                        });


                    
                    })
                    
                    let desktopAds = document.getElementsByClassName("desktopAds")
                    Object.keys(desktopAds).forEach(ad=>{
                        desktopAds[ad].style.display = "none";
                    })
                }

            })

            
        </script>
@endif
</body>
</html>