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
    <link rel="stylesheet" href="{{ asset('assets/css/scores-css.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <title>Livescore - Scores</title>

    <style>
        @media (min-width: 600px) {
        
        }
    </style>
</head>

<body>

    @if(session()->has('authenticated')){
        @include('layouts.navbar',$data)
    }
    @else
        @include('layouts.navbar')
    @endif

    <div class="space"></div>
    
    <div class="ads">
        <div class="desktopAds" id="Wide"></div>

        <div class="mobileAds" id="Small"></div>
    </div>

    <main>

        <div class="sport-nav-section">

            <div class="sport-group-container" id="sportsContainer"></div>

        </div>

        <div class="scores-section">

            <div class="form-filter-section">

                <form action="">

                    <label for="event-date" class="event-date-label">

                        Event Country
                        <select name="country" id="countriesContainer" class="event-country">

                        </select>
                        Event Date
                        <input type="date" id="eventDate" name="event-date" class="event-date">

                    </label>

                </form>

            </div>

            <div class="default-main-section">

                <h1>International Events</h1>

                <div class="event-group-container" id="eventsContainer">





                </div>

            </div>

        </div>


    </main>

    <div class="ads">
        <div class="desktopAds" id="Wide"></div>

        <div class="mobileAds" id="Small"></div>
    </div>
    
</body>


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
                                tag: "Main"
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
                                tag: "Main"
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

    

<script>
    jQuery(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/sports') }}",
            method: 'POST',
            success: function(sports) {
                sports.forEach(sport => {
                    document.getElementById('sportsContainer').innerHTML +=
                        `
                        <div class="sport-container" onClick="getEventsBySport(${sport['id']})">

                            <div class="sport-icon">

                                <span class="material-symbols-outlined">${sport['icon']}</span>

                            </div>
                            <p class="sport-name">${sport['sport']}</p>

                        </div>
                    
                    `
                });
            }
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/countries') }}",
            method: 'POST',
            success: function(countries) {
                countries.forEach(country => {
                    document.getElementById('countriesContainer').innerHTML +=
                        `
                    <option value='${country["id"]}'>${country['country']}</option>
                    `;

                });
            }
        });
    });
</script>

<script>

    jQuery(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ url('/events') }}",
            method: 'POST',
            success: function(events) {

                events.forEach(event => {

                    if (event['type'] == "results_points") {
                        
                        document.getElementById('eventsContainer').innerHTML += loadPoints(event);
                    }
                    if (event['type'] == "results_downward") {
                        
                        document.getElementById('eventsContainer').innerHTML += loadMarkDown(event);
                    }
                    if(event['type'] == "results_upward"){
                    
                        document.getElementById('eventsContainer').innerHTML += loadMarkUp(event);
                    }
                    if(event['type'] == "points_sets"){
                        
                        document.getElementById('eventsContainer').innerHTML += loadSets(event);

                    }

                });
            }
        });

        
    });

    function loadSets(event) {

        if(event['teams'][0]['result'].length === 0){
            return `
            
                <div class="event-container">

                    <div class="event-title-holder">

                        <a href="./event/set/${event['id']}" class="event-title">${event['name']}</a>
                        <p class="event-state">${event['date']}</p>

                    </div>

                    <div class="event-holder no-result">
                        
                        <div class="team-holder-container">

                            <div class="team-holder">

                                <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][0]["photo"]}' class="team-logo"></div>
                                <p class="sets"><a href="" class="team-name">${event["teams"][0]["name"]}</a></p>

                                <div class="team-set">
                                    
                                    <p>0</p>
                                    <p>0</p>
                                    <p>0</p>

                                </div>

                            </div>

                            <div class="team-holder">

                                <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][1]["photo"]}' class="team-logo"></div>
                                <p class="sets"><a href="" class="team-name">${event["teams"][1]["name"]}</a></p>
                            
                                <div class="team-set">
                                    
                                    <p>0</p>
                                    <p>0</p>
                                    <p>0</p>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
                
                `;
            }
        return `
                <div class="event-container">

                    <div class="event-title-holder">

                        <a href="./event/set/${event['id']}" class="event-title">${event['name']}</a>
                        <p class="event-state">${event['date']}</p>

                    </div>

                    <div class="event-holder set">
                            
                        <div class="team-holder-container">

                            <div class="team-holder">

                                <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][0]["photo"]}' class="team-logo"></div>
                                <p class="sets"><a href="" class="team-name">${event["teams"][0]["name"]}</a></p>

                                <div class="team-set" id="team-set">

                                    ${showTeamSet(event, 0)}

                                </div>

                            </div>

                            <div class="team-holder">

                                <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][1]["photo"]}' class="team-logo"></div>
                                <p class="sets"><a href="" class="team-name">${event["teams"][1]["name"]}</a></p>

                                <div class="team-set">
                                        
                                    ${showTeamSet(event, 1)}

                                </div>
                                
                            </div>

                        </div>

                    </div>

                </div>
                `
    
    }
    
    function showTeamSet(event, teamNumber){

        let limit = event['teams'][0]['result'].length;
        result = "";

        for(let i = 0; i < limit; i++){
                    
            result += `<p>${event['teams'][teamNumber]['result'][i].point}</p>`

            if(i == 2)
                return result
        }
                
        return result

    }

        function loadMarkUp(event) {

            return `
                <div class="event-container">

                    <div class="event-title-holder">

                        <a href="./event/mark/${event['id']}" class="event-title">${event['name']}</a>
                        <p class="event-state">${event['date']}</p>

                    </div>

                    <div class="event-mark-holder">
                        ${markUp(event)}                    
                    </div>

                </div>
            `
        }

        function markUp(event) {

            teams = event['teams'];

            console.log(event)
            
            if(teams[0].result.length === 0){

                let limit = teams.length;

                let teamName = '';

                for(let i = 0; i < limit; i++){

                    teamName += `

                        <div class="team-holder">
                            <a href="" class="team-name">${teams[i]['name']}</a>
                            <p class="time"> NA </p>    
                        </div>

                    `;

                }

                return teamName
                
            }
            
            teams = orderUp(teams);
            result = "";

            for(let i = 0;i<teams.length;i++){
                result += `
                <div class="team-holder">
                    <a href="" class="team-name">${teams[i]['name']}</a>
                    <p class="time">${teams[i]['result'][0]['result']} ${event['teams'][i]['result'][0]['unit']}</p>    
                </div>
            
                `
                if(i == 2)
                    return result;
            }
            return result;
        }

        function orderUp(teams){
            let sorted = false;
            while(!sorted){
                swap = false;
                for(let i = 0;i<teams.length-1;i++){
                
                    position = teams[i]['result'][0]['result'];
                    next = teams[i+1]['result'][0]['result'];
                    if(next < position){
                        carry = teams[i];
                        teams[i] = teams[i+1]
                        teams[i+1] = carry;
                        swap = true;
                    }
                    
                }
                if(!swap){
                    sorted = true;
                }
            }
            return teams;
            

        }

        function loadMarkDown(event) {

            return `
                <div class="event-container">

                        <div class="event-title-holder">

                            <a href="./event/mark/${event['id']}" class="event-title">${event['name']}</a>
                            <p class="event-state">${event['date']}</p>

                        </div>

                        <div class="event-mark-holder">
                            ${markDown(event)}                    
                        </div>

                </div>
            `
        }

        function markDown(event) {

            teams = event['teams'];

            console.log(event)
            
            if(teams[0].result.length === 0){

                let limit = teams.length;

                let teamName = '';

                for(let i = 0; i < limit; i++){

                    teamName += `

                        <div class="team-holder">
                            <a href="" class="team-name">${teams[i]['name']}</a>
                            <p class="time"> NA</p>    
                        </div>

                    `;

                }

                return teamName
                
            }
            
            teams = orderDown(teams);
            result = "";

            for(let i = 0;i<teams.length;i++){
                result += `
                <div class="team-holder">
                    <a href="" class="team-name">${teams[i]['name']}</a>
                    <p class="time">${teams[i]['result'][0]['result']} ${event['teams'][i]['result'][0]['unit']}</p>    
                </div>
            
                `
                if(i == 2)
                    return result;
            }
            return result;
        }

        function orderDown(teams){
            let sorted = false;
            while(!sorted){
                swap = false;
                for(let i = 0;i<teams.length-1;i++){
                
                    position = teams[i]['result'][0]['result'];
                    next = teams[i+1]['result'][0]['result'];
                    if(next > position){
                        carry = teams[i];
                        teams[i] = teams[i+1]
                        teams[i+1] = carry;
                        swap = true;
                    }
                    
                }
                if(!swap){
                    sorted = true;
                }
            }
            return teams;
            

        }

        function loadPoints(event) {
            return `
                <div class="event-container">

                        <div class="event-title-holder">

                            <a href="./event/${event['id']}" class="event-title">${event['name']}</a>
                            <p class="event-state">${event['date']}</p>

                        </div>

                        <div class="event-holder">

                            <div class="team-holder">

                                <img src='http://127.0.0.1:8005/img/public_images/${event["teams"][0]["photo"]}' class="team-logo">
                                <a href="" class="team-name">${event["teams"][0]["name"]}</a>

                            </div>

                            <div class="score-holder">

                                <p class="event-score">${totalPoints(event["teams"][0]['result'])} <span class="divisor"> - </span>${totalPoints(event["teams"][1]['result'])}</p>

                            </div>

                            <div class="team-holder">

                                <img src='http://127.0.0.1:8005/img/public_images/${event["teams"][1]["photo"]}' class="team-logo">
                                <a href="" class="team-name">${event["teams"][1]["name"]}</a>

                            </div>

                        </div>

                </div>
            `
        }

        function totalPoints(result) {
            let total = 0;
            result.forEach(point => {
                total += point['point'];
            });

            return total;
        }

    const getEventsBySport = (id) => {
            document.getElementById("eventsContainer").innerHTML = ""
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            })
            jQuery.ajax({
                url: "{{ url('http://localhost:8001/api/getEventsBySport') }}",
                method: 'POST',
                data: {
                    idSport: id
                },

                success: function(events) {
                    events.forEach(event => {
                        if (event['type'] == "results_points") {

                            document.getElementById('eventsContainer').innerHTML += loadPoints(
                                event);
                        }
                        if (event['type'] == "results_downward") {
                            document.getElementById('eventsContainer').innerHTML += loadMarkDown(event);
                        }
                        if(event['type'] =="results_upward"){
                            document.getElementById('eventsContainer').innerHTML += loadMarkUp(event);

                        }
                        if(event['type'] =="points_sets"){
                            document.getElementById('eventsContainer').innerHTML += loadSets(event);

                        }

                    });
                }
            });
        }


</script>

</html>
