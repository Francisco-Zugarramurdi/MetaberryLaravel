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
</head>

<body>

    <header>

        <nav>

            <div class="header-nav-container-1">
                <a href="./index.html"><img
                        src="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2019.png"></a>
                <a href="./index.html#aboutSection">How does it work?</a>
                <a href="./scores.html">Scores</a>
            </div>

            <div class="header-nav-container-2">

                <a href="./log-in.html" class="login-btn">Login</a>
                <a href="./sign-up.html" class="signup-btn">Create an Account</a>
                <button><span class="material-symbols-outlined">settings</span></button></li>

            </div>

        </nav>

    </header>

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

    <footer>

        <img
            src="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2022white.png">

        <div class="texts">

            <a href="./index.html#aboutSection">How does it work?</a>
            <a href="./scores.html">Scores</a>

        </div>

        <p class="copyright">All Rights Reserved. 2022 Metaberry</p>

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
                console.log(events);

                events.forEach(event => {
                    if (event['type'] == "results_points") {

                        document.getElementById('eventsContainer').innerHTML += loadPoints(
                            event);
                    }
                    if (event['type'] == "results_downward") {
                        document.getElementById('eventsContainer').innerHTML += loadMarkDown(event);
                    }
                    if(event['type'] ==="results_upward"){
                        document.getElementById('eventsContainer').innerHTML += loadMarkUp(event);

                    }

                });
            }
        });

        function loadMarkUp(event) {
            return `
                <div class="event-container">

                        <div class="event-title-holder">

                            <a href="./event-by-mark.html" class="event-title">${event['name']}</a>
                            <p class="event-state">${event['date']}</p>

                        </div>

                        <div class="event-mark-holder">
                            ${markUp(event['teams'])}                    
                        </div>

                </div>
            `
        }
        function markUp(teams) {
            result = "";
            teams = orderUp(teams);
            for(let i = 0;i<teams.length;i++){
                result += `
                <div class="team-holder">
                    <a href="" class="team-name">${teams[i]['name']}</a>
                    <p class="time">${teams[i]['result'][0]['result']}</p>    
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
                    console.log(teams[i]['result'][0]['result']);
                
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

                            <a href="./event-by-mark.html" class="event-title">${event['name']}</a>
                            <p class="event-state">${event['date']}</p>

                        </div>

                        <div class="event-mark-holder">
                            ${markDown(event['teams'])}                    
                        </div>

                </div>
            `
        }

        function markDown(teams) {
            result = "";
            teams = orderDown(teams);
            for(let i = 0;i<teams.length;i++){
                result += `
                <div class="team-holder">
                    <a href="" class="team-name">${teams[i]['name']}</a>
                    <p class="time">${teams[i]['result'][0]['result']}</p>    
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
                    console.log(teams[i]['result'][0]['result']);
                
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

                            <a href="./event-by-mark.html" class="event-title">${event['name']}</a>
                            <p class="event-state">${event['date']}</p>

                        </div>

                        <div class="event-holder">

                            <div class="team-holder">

                                <img src='http://127.0.0.1:8005/img/public_images/${event["teams"][0]["photo"]}' class="team-logo">
                                <a href="" class="team-name">${event["teams"][0]["name"]}</a>

                            </div>

                            <div class="score-holder">

                                <p class="event-score">${totalPoints(event["teams"][0]['result'])} - ${totalPoints(event["teams"][1]['result'])}</p>

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
    });
</script>

</html>
