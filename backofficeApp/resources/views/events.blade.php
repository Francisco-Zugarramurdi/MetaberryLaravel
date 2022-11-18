<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Event</title>
</head>
<body>
    <main>

        @include('navbar')

        <div class="main-page-container">

            <div class="nav-bar-container">
                <h1>Event Management</h1>
            </div>

            <div class="create-user-container">
                
                    <a href="/event/list" class="dropdown-button"> Go to Event List </a>
                    <button type="button" class="dropdown-button" id="button-set" onClick="dropdown('sets')">Create event by Sets
                        <span class="hidden material-symbols-outlined" id="show_icon_sets">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon_sets">expand_less</span>
                    </button>
    
                    <div class="unhide-container" id="sets">
    
                            <h2>Create Event by Sets</h2>
        
                            <form action="/event/create/set" class="create-user-form" method="GET" id="creationForm">
                                @method('GET')
                                @csrf
                                
                                <div class="form-up-container">
        
                                    <div class="form-inner-container">
        
                                        <label>
                                            <p><span>* </span>Name</p>
                                            <input type="text" name="name" placeholder="Real Madrid vs Barcelona FC" id="name">
                                        </label>
                                      
                                        <label>
                                            <p><span>* </span>Details</p>
                                            <input type="text" name="details" placeholder="A match which is going" id="details">
                                        </label>
                                                      
                                        <label>
                                           <p><span>* </span>Date</p>           
                                           <input type="date" name="date" id="date">
                                        </label>
                                        <label>
                                            <p><span>* </span>Relevance</p>
                                            <input type="number" name="relevance" id="relevance" placeholder="1 to 5" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="countrySets">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sportSets">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->id}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="leagueSets">
                                                <option value="">Does not have a league</option>
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->id}}">{{$league->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p><span>* </span>Referee</p>
                                            <select name="referee" id="referee">
                                                @foreach ($referees as $referee)
                                                    <option value="{{$referee->id}}">{{$referee->name}} {{$referee->surname}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p>Load result now</p>
                                            <input type="checkbox" name="resultReady">
                                        </label>
                                    </div>
                                    <div class="form-inner-container">

                                        <label>
                                            Local Team
                                            <select name="localTeam" id="localTeamSets">
                                                @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label>
                                            Vistant Team
                                            <select name="visitorTeam" id="visitorTeamSets">
                                                @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <div class="set-container">

                                            <label>
                                                <button type="button" id="add-set">Add Set</button>
                                            </label>

                                            <div class="set-inner-container">

                                                <div class="set-local-container">
                                                    <p class="set-title">Local Set</p>
                                                    <div id="setContainerLocal"></div>
                                                </div>

                                                <div class="set-visitor-container">
                                                    <p class="set-title">Visitor Set</p>
                                                    <div id="setContainerVisitor"></div>
                                                </div>

                                            </div>

                                        </div>

                                        <label>
                                            Winner
                                            <select name="winner" id="winner">
                                                <option value="local">Local</option>
                                                <option value="visitor">Visitor</option>
                                            </select>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-down-container">
        
                                    <input type="submit" value="Create" class="create-btn" id="submit">
                
                                    <div id="error" class="error"></div>
        
                                </div>
        
                            </form>
                        
                    </div>            
    
                    <button type="button" class="dropdown-button" id="button-points" onClick="dropdown('points')">Create event by Points
                        <span class="hidden material-symbols-outlined" id="show_icon_points">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon_points">expand_less</span>
                    </button>
    
                    <div class="unhide-container" id="points">
    
                            <h2>Create Event by Points</h2>
        
                            <form action="/event/create/point" class="create-user-form" method="GET" id="creationForm">
                                @method('GET')
                                @csrf
                                
                                <div class="form-up-container">
        
                                    <div class="form-inner-container">
        
                                        <label>
                                            <p><span>* </span>Name</p>
                                            <input type="text" name="name" placeholder="Real Madrid vs Barcelona FC" id="name">
                                        </label>
                                      
                                        <label>
                                            <p><span>* </span>Details</p>
                                            <input type="text" name="details" placeholder="A match which is going" id="details">
                                        </label>
                                                      
                                        <label>
                                           <p><span>* </span>Date</p>           
                                           <input type="date" name="date" id="date">
                                        </label>

                                        <label>
                                            <p><span>* </span>Relevance</p>
                                            <input type="number" name="relevance" id="relevance" placeholder="1 to 5" min="1" max="5">
                                        </label>

                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="countryPoints">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sportPoints">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->id}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label><p>League</p>
                                            <select name="league" id="leaguePoints">
                                                <option value="">Does not have a league</option>
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->id}}">{{$league->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label>
                                            <p><span>* </span>Referee</p>
                                            <select name="referee" id="referee">
                                                @foreach ($referees as $referee)
                                                    <option value="{{$referee->id}}">{{$referee->name}} {{$referee->surname}}</option>
                                                @endforeach
                                            </select>
                                        </label>

                                        <label>
                                            <p>Load result now</p>
                                            <input type="checkbox" name="resultReady">
                                        </label>

                                    </div>

                                    <div class="form-inner-container">
                                        
                                        <div class="form-team-container">
                                            
                                            <label>
                                                <p><span>* </span>Teams</p>
                                            </label>

                                            <label class="add-btn">
                                                Add a local team
                                                <button type="button" id="add_team_local_button"><span class="material-symbols-outlined">add</span></button>
                                            </label>
                                            
                                            <label>
                                                Local Team
                                                <select name="localTeam" id="localTeamScore">
                                                    @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            
                                            <div class="team-card-container" id="team_card_Local_container">
                                                
                                                <div class="team-container">


                                                </div>

                                            </div>

                                            <label class="add-btn">
                                                Add a visitor team
                                                <button type="button" id="add_team_visitor_button"><span class="material-symbols-outlined">add</span></button>
                                            </label>

                                            <label>
                                                Visitor Team
                                                <select name="visitorTeam" id="visitorTeamScore">
                                                    @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                    @endforeach
                                                </select>

                                            </label>

                                            <div class="team-card-container" id="team_card_Visitor_container">
                                                
                                                <div class="team-container">
                
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </div>
        
                                <div class="form-down-container">
        
                                    <input type="submit" value="Create" class="create-btn" id="submit">
                
                                    <div id="error" class="error"></div>
        
                                </div>
        
                            </form>
                        
                    </div>            
                    
                    <button type="button" class="dropdown-button" id="button-markup" onClick="dropdown('markUp')">Create event by MarkUp
                        <span class="hidden material-symbols-outlined" id="show_icon_markUp">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon_markUp">expand_less</span>
                    </button>
    
                    <div class="unhide-container" id="markUp">
    
                            <h2>Create Event by Mark Up</h2>
        
                            <form action="/event/create/markUp" class="create-user-form" method="POST" id="creationForm">
                                @method('GET')
                                @csrf
                                
                                <div class="form-up-container">
        
                                    <div class="form-inner-container">
        
                                        <label>
                                            <p><span>* </span>Name</p>
                                            <input type="text" name="name" placeholder="Real Madrid vs Barcelona FC" id="name">
                                        </label>
                                      
                                        <label>
                                            <p><span>* </span>Details</p>
                                            <input type="text" name="details" placeholder="A match which is going" id="details">
                                        </label>
                                                      
                                        <label>
                                           <p><span>* </span>Date</p>           
                                           <input type="date" name="date" id="date">
                                        </label>
                                        <label>
                                            <p><span>* </span>Relevance</p>
                                            <input type="number" name="relevance" id="relevance" placeholder="1 to 5" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="countryMarkUp">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sportMarkUp">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->id}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="leagueMarkUp">
                                                <option value="">Does not have a league</option>
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->id}}">{{$league->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p><span>* </span>Referee</p>
                                            <select name="referee" id="referee">
                                                @foreach ($referees as $referee)
                                                    <option value="{{$referee->id}}">{{$referee->name}} {{$referee->surname}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p>Load result now</p>
                                            <input type="checkbox" name="resultReady">
                                        </label>
                                    </div>

                                    <div class="form-inner-container">
                                        
                                        <div class="form-team-container">
                                            
                                        <label>
                                            Unit
                                            <input type="text" name="unit" placeholder="kilos">
                                        </label>

                                            <label>
                                                <p><span>* </span>Teams</p>
                                            </label>

                                            <label class="add-btn">
                                                Add a team
                                                <button type="button" id="addTeamMarkUp"><span class="material-symbols-outlined">add</span></button>
                                            </label>
                                            
                                            <div class="team-card-container" id="team_card_container_for_mark_up">
                                                
                                                <div class="team-container">
                                                    
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>
        
                                <div class="form-down-container">
        
                                    <input type="submit" value="Create" class="create-btn" id="submit">
                
                                    <div id="error" class="error"></div>
        
                                </div>
        
                            </form>
                        
                    </div>            
    
                    <button type="button" class="dropdown-button" id="button-markdown" onClick="dropdown('markDown')">Create event by MarkDown
                        <span class="hidden material-symbols-outlined" id="show_icon_markDown">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon_markDown">expand_less</span>
                    </button>
    
                    <div class="unhide-container" id="markDown">
    
                            <h2>Create Event by Mark Down</h2>
        
                            <form action="/event/create/markDown" class="create-user-form" method="POST" id="creationForm">
                                @method('GET')
                                @csrf
                                
                                <div class="form-up-container">
        
                                    <div class="form-inner-container">
        
                                        <label>
                                            <p><span>* </span>Name</p>
                                            <input type="text" name="name" placeholder="Real Madrid vs Barcelona FC" id="name">
                                        </label>
                                      
                                        <label>
                                            <p><span>* </span>Details</p>
                                            <input type="text" name="details" placeholder="A match which is going" id="details">
                                        </label>
                                                      
                                        <label>
                                           <p><span>* </span>Date</p>           
                                           <input type="date" name="date" id="date">
                                        </label>
                                        <label>
                                            <p><span>* </span>Relevance</p>
                                            <input type="number" name="relevance" id="relevance" placeholder="1 to 5" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="countryMarkDown">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sportMarkDown">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->id}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="leagueMarkDown">
                                                <option value="">Does not have a league</option>
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->id}}">{{$league->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p><span>* </span>Referee</p>
                                            <select name="referee" id="referee">
                                                @foreach ($referees as $referee)
                                                    <option value="{{$referee->id}}">{{$referee->name}} {{$referee->surname}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p>Load result now</p>
                                            <input type="checkbox" name="resultReady">
                                        </label>
                                    </div>

                                    <div class="form-inner-container">
                                        
                                        <div class="form-team-container">
                                            
                                            <label>
                                                Unit 
                                                <input type="text" name="unit" placeholder="kilos">
                                            </label>

                                            <label>
                                                <p><span>* </span>Teams</p>
                                            </label>

                                            <label class="add-btn">
                                                Add a team
                                                <button type="button" id="addTeamMarkDown"><span class="material-symbols-outlined">add</span></button>
                                            </label>
                                            
                                            <div class="team-card-container" id="team_card_container_for_mark_down">
                                                
                                                <div class="team-container">
                                                    
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
        
                                <div class="form-down-container">
        
                                    <input type="submit" value="Create" class="create-btn" id="submit">
                
                                    <div id="error" class="error"></div>
        
                                </div>
        
                            </form>
                        
                    </div>
                                
            </div>

        </div>

    </main>


    <script>
        document.getElementById('event').classList.add("focus");
    </script>

    <script src="{{ asset('js/Event.js') }}"></script>

    <script>
        var count = 0;

        jQuery(document).ready(function(){
            jQuery('#add_team_local_button').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/player/indexById') }}",
                    method: 'POST',
                    data: {
                        teamId:jQuery('#localTeamScore').val()
                    },
                    success: function(players){
                        addPointToATeam(players, 'Local')
                }});
            });

            jQuery('#add_team_visitor_button').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/player/indexById') }}",
                    method: 'POST',
                    data: {
                        teamId:jQuery('#visitorTeamScore').val()
                    },
                    success: function(players){
                        addPointToATeam(players, 'Visitor')
                    }});
            });
        
        let addPointToATeam = (players, team) =>{
            let options = ''
            count += 1;

            Object.keys(players).forEach(player => {
                
                options += `<option value="${players[player].id}">${players[player].name}  ${players[player].surname}</option>`
            }); 

            document.getElementById(`team_card_${team}_container`).innerHTML += 
            `<div class="team-container">
                
                <label>
                    Player
                    <select name="points${team}[${count}][player]" id="player">
                        ${options}
                    </select>
                </label>
            
                <label>
                    Points
                    <input type="number" name="points${team}[${count}][points]" min="1">
                </label>
            
            </div>`;
        }

        jQuery('#localTeamScore').change(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/player/indexById') }}",
                    method: 'POST',
                    data: {
                        teamId:jQuery('#localTeamScore').val()
                    },
                    success: function(players){
                       changeSelect(players,'Local');
                }});
        });
        jQuery('#visitorTeamScore').change(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/player/indexById') }}",
                    method: 'POST',
                    data: {
                        teamId:jQuery('#visitorTeamScore').val()
                    },
                    success: function(players){
                       changeSelect(players,'Visitor');
                }});
        });

        let changeSelect = (players, team) =>{
            let options = ''
            count += 1;

            Object.keys(players).forEach(player => {
                    
                options += `<option value="${players[player].id}">${players[player].name}  ${players[player].surname}</option>`
            }); 

            document.getElementById(`team_card_${team}_container`).innerHTML = 
            `<div class="team-container">
                
                <label>
                    Player
                    <select name="points${team}[${count}][player]" id="player">
                        ${options}
                    </select>
                </label>
            
                <label>
                    Points
                    <input type="number" name="points${team}[${count}][points]" min="1">
                </label>
            
            </div>`;
        }
    });
    </script>


    <script>
        var count = 0;
        
        jQuery(document).ready(function(){
            jQuery('#addTeamMarkUp').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/team/indexBySport') }}",
                    method: 'POST',
                    data: {
                        id:jQuery('#sportMarkUp').val()
                    },
                    success: function(teams){
                        CreateATeam(teams,'mark_up')
                }});
            });
            jQuery('#addTeamMarkDown').click(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/team/indexBySport') }}",
                    method: 'POST',
                    data: {
                        id:jQuery('#sportMarkDown').val()
                    },
                    success: function(teams){
                        CreateATeam(teams,'mark_down')
                }});
            });
            
        
            let CreateATeam = (teams, typeOfMark) =>{
            let options = ''
            count += 1;

            Object.keys(teams).forEach(team => {
                
                options += `<option value="${teams[team].id}">${teams[team].name}</option>`
            }); 

            document.getElementById(`team_card_container_for_${typeOfMark}`).innerHTML += 
            `<div class="team-container">
            
                <label>
                    Team
                    <select name="marks[${count}][team]">
                        ${options}
                    </select>
                </label>

                <label>
                    Mark
                    <input type="number" name="marks[${count}][mark]" placeholder="50">
                </label>

                
        
            </div>`;
        }
    });
    jQuery('#sportMarkDown').change(function(){
        document.getElementById('team_card_container_for_mark_down').innerHTML = "";
    });
    jQuery('#sportMarkUp').change(function(){
        document.getElementById('team_card_container_for_mark_up').innerHTML = "";
    });
    
    </script>
    <script>
        jQuery(document).ready(function(){
            handleCountryChange('countrySets','leagueSets');
            handleCountryChange('countryPoints','leaguePoints');
            handleCountryChange('countryMarkUp','leagueMarkUp');
            handleCountryChange('countryMarkDown','leagueMarkDown');


            jQuery('#countrySets').change(function(){
                handleCountryChange('countrySets','leagueSets');
            });
            jQuery('#countryPoints').change(function(){
                handleCountryChange('countryPoints','leaguePoints');
            });
            jQuery('#countryMarkUp').change(function(){
                handleCountryChange('countryMarkUp','leagueMarkUp');
            });
            jQuery('#countryMarkDown').change(function(){
                handleCountryChange('countryMarkDown','leagueMarkDown');
            });
            
            jQuery('#sportSets').change(function(){
                handleSportChange('sportSets','localTeamSets');
                handleSportChange('sportSets','visitorTeamSets');
            });
            jQuery('#sportPoints').change(function(){
                handleSportChange('sportPoints','localTeamScore');
                handleSportChange('sportPoints','visitorTeamScore');
            })

            function handleSportChange(idSport,idTeams){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/team/indexBySport') }}",
                    method: 'POST',
                    data: {
                        id:jQuery(`#${idSport}`).val()
                    },
                    success: function(teams){
                        changeTeams(teams,idTeams);
                }});
            }
            function changeTeams(teams,idTeams){
                let options = ''
                count += 1;
                Object.keys(teams).forEach(team => {
                    
                    options += `<option value="${teams[team].id}">${teams[team].name}</option>`
                }); 
                document.getElementById(`${idTeams}`).innerHTML = 
                    `
                     ${options}                              
                    `;
               
            }

            function handleCountryChange(idCountry,idLeagues){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                });
                jQuery.ajax({
                    url: "{{ url('/league/byCountry') }}",
                    method: 'POST',
                    data: {
                        id:jQuery(`#${idCountry}`).val()
                    },
                    success: function(leagues){
                        changeLeague(leagues,idLeagues);
                }});
            }
            function changeLeague(leagues,id){
                let options = ''
                count += 1;
                Object.keys(leagues).forEach(league => {
                    
                    options += `<option value="${leagues[league].id}">${leagues[league].name}</option>`
                }); 

                document.getElementById(`${id}`).innerHTML = 
                `<option value="">Does not have a league</option>
                 ${options}                              
                `;
            }
        });
    </script>
</body>
</html>