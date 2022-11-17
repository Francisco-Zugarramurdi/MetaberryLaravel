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
    <link rel="stylesheet" href="{{ asset('/assets/css/event-by-mark.css') }}">
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
    <div class="results">
        
                <ul>
                    @foreach($info['result'] as $i => $result)
                    @if($i <= 5)
                        @if( $result['position'] >= 1)
                            <li> {{$result['position']}}.
                                <div class="event-image-container"><img src="http://127.0.0.1:8005/img/public_images/{{$result['teamPhoto']}}"></div> 
                                <p class="name">{{$result['teamName']}}</p>
                                <p class="time">{{$result['result']}}'</p>
                            </li>
                        @endif
                    @endif
                    @endforeach
                </ul>

    </div>
        

    </section>

    <section class="innerNav">
        <ul>
            <li>Timeline</li>
        </ul>
    </section>

    <section class="display">
            <div class="renderArea">
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
                    <p>Name: {{$info['name']}}</p>
                <p>Details: {{$info['details']}}</p>
            </div>
            <div class="ads">
                <div class="desktopAds" id="Small"></div>
                <div class="mobileAds" id="Small"></div>
            </div>
        </div>
    </section>
</main>

</body>

<script>
    
</script>

@if(!session()->has('user_sub'))
        <script>
            jQuery(document).ready(function() {

                if(window.innerWidth > 768){
                
                    let ads = document.getElementsByClassName("desktopAds")
                    console.log(typeof(ads))
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
                    console.log(typeof(ads))
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

</html>