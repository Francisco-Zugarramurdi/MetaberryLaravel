<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="icon" href="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/icon.ico">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="{{ asset('assets/css/index-css.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Livescore</title>
</head>

<body>

    @include('layouts.navbar')

    <main>

        <div class="hero-section">

            <div class="hero-section-text">

                <h1>Enjoy from <span>anywhere, at any time</span> your favorite events</h1>
                <h2>You won't miss that special match again. Add to favorites teams, leagues
                    and events to catch up with their activities.
                </h2>
                <a href="/signup" class="join-btn">Join Now</a>

            </div>

            <div class="hero-section-img">

                <img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/illustrations/pablita-879.png?raw=true">

            </div>

        </div>

        <div class="event-section">

            <h2 class="event-head">Most popular events</h2>

            <div class="event-group-container" id="eventsContainer">





            </div>

            <a href="/scores" class="events-btn">See More</a>

        </div>

        <div class="subscription-section">

            <h2 class="sub-head">Ready to level up to Livescore Premium?</h2>

            <div class="subscription-group-container">

                <div class="subscription-container">

                    <div class="subscription-info">

                        <p class="sub-type">Basic</p>
                        <p class="sub-price">Free</p>
                        <p class="sub-desc">Although limited, you can access to a great experience in our site</p>

                    </div>

                    <div class="subscription-data">

                        <ul>

                            <li><span class="material-symbols-outlined">check_circle</span>
                                Follow teams, events and leagues</li>
                            <li><span class="material-symbols-outlined">cancel</span>
                                Remove Ads</li>

                        </ul>

                    </div>

                    <a href="/signup" class="sub-btn">Choose Plan</a>

                </div>

                <div class="subscription-container">

                    <div class="subscription-info">

                        <p class="sub-type">Premium</p>
                        <p class="sub-price">$5 <span>/month</span></p>
                        <p class="sub-desc">Our subscription based plan. Get rid of the ads and enhance your experience
                        </p>

                    </div>

                    <div class="subscription-data">

                        <ul>

                            <li><span class="material-symbols-outlined">check_circle</span>
                                Follow teams, events and leagues</li>
                            <li><span class="material-symbols-outlined">check_circle</span>
                                Remove Ads</li>

                        </ul>

                    </div>

                    <a href="/subscribe" class="sub-btn">Choose Plan</a>

                </div>

                <div class="subscription-container">

                    <div class="subscription-info">

                        <p class="sub-type">Enterprise</p>
                        <p class="sub-price">$50 <span>/year</span></p>
                        <p class="sub-desc">Save up to 2 months of payments and get all the benefits from the premium plan
                        </p>

                    </div>

                    <div class="subscription-data">

                        <ul>

                            <li><span class="material-symbols-outlined">check_circle</span>
                                Follow teams, events and leagues</li>
                            <li><span class="material-symbols-outlined">check_circle</span>
                                Remove Ads</li>

                        </ul>

                    </div>

                    <a href="/subscribe" class="sub-btn-default">Choose Plan</a>

                </div>

            </div>

        </div>

    </main>


    <footer>

        <img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2022white.png?raw=true">

    </footer>


</body>

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
                        <div class="sport-container">

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
            
            if(teams[0].result.length === 0){

                let limit = teams.length;

                let teamName = '';

                for(let i = 0; i < limit; i++){

                    teamName += `

                        <div class="team-holder">
                            <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][i]["photo"]}' class="team-logo"></div>
                            <a class="team-name">${teams[i]['name']}</a>
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
                    <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][i]["photo"]}' class="team-logo"></div>
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
            
            if(teams[0].result.length === 0){

                let limit = teams.length;

                let teamName = '';

                for(let i = 0; i < limit; i++){

                    teamName += `

                        <div class="team-holder">
                            <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][i]["photo"]}' class="team-logo"></div>
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
                    <div class="event-image-container"><img src='http://127.0.0.1:8005/img/public_images/${event["teams"][i]["photo"]}' class="team-logo"></div>
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
