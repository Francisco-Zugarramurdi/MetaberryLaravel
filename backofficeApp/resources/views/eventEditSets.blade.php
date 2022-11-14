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
    <title>Edit Event</title>
</head>
<body>
    <main>
        @include('navbar')
        
        <div class="main-page-container">

            <div class="nav-bar-container">
                <h1>Events Edits</h1>
            </div>

            <div class="create-user-container">
                <div class="unhide-container hide">
                    
                        <h2>Edit Event</h2>
                        
                                <form class="create-user-form" method="POST" action="/event/edit/set/{{$event->id}}">
                                    @method('PUT')
                                    @csrf
                                    {{method_field('PUT')}}
                                    <div class="form-up-container">

                                        <div class="form-inner-container">
                                            <Label>
                                                <p>ID Event: <span>{{$event->id}}</span></p> 
                                            </Label>

                                            <label>
                                                <p>Name:</p>
                                                <input type="text" name="name" id="name" value="{{$event->name}}">
                                            </label>
                                            <label>
                                                <p>Details:</p>
                                                <input type="text" name="details" id="details" value="{{$event->details}}">
                                            </label>
                                            <label>
                                                <p>Date:</p>
                                                <input type="date" name="date" id="date" value="{{$event->date}}">
                                            </label>
                                            <label>
                                                <p>Relevance:</p>
                                                <input type="number" name="relevance" id="Relevance" value="{{$event->relevance}}">
                                            </label>
                                            <label>
                                            <p>Country:</p>
                                                <select name="country" id="Country">
                                                    @foreach($countries as $country)
                                                    <option value="{{$country->id}}" @if($country->name == $event->countryName)selected @endif>{{$country->name}}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <label>
                                            <p>Sport:</p>
                                                <select name="sport" id="Sport">
                                                    @foreach($sports as $sport)
                                                    <option value="{{$sport->id}}" @if($sport->name == $event->sportName)selected @endif>{{$sport->name}}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <label>
                                                <p>League:</p>
                                                <select name="league" id="league">
                                                    @foreach($leagues as $league)
                                                    <option value="{{$league->id}}"  @if($league->name == $event->leagueName)selected @endif>{{$league->name}}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <label>
                                                <p>Referee:</p>
                                                <select name="referee" id="referee">
                                                    @foreach($referees as $referee)
                                                    <option value="{{$referee->id}}"@if($event->refereeId == $referee->id) selected @endif>{{$referee->name}} {{$referee->surname}}</option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <label>
                                                <input type="hidden" name="typeResult" value="{{$event->typeResult}}">
                                            </label>
                                        </div>

                                        <div class="form-up-container">
  
                                            <div class="form-inner-container">

                                                <label>
                                                    Local Team
                                                    <select name="teams[]" id="localTeamSets">
                                                        @foreach($teams as $team)
                                                            <option value="{{$team->id}}" @if($team->id == $eventTeams[0]->teamId)selected @endif>{{$team->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>

                                                <label>
                                                    Vistant Team
                                                    <select name="teams[]" id="visitorTeamSets">
                                                        @foreach($teams as $team)
                                                            <option value="{{$team->id}}"@if($team->id == $eventTeams[1]->teamId)selected @endif>{{$team->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>

                                                <div class="set-container">

                                                    <label>
                                                        <button type="button" id="add-set" onClick="addSets()">Add Set</button>
                                                    </label>

                                                    <div class="set-inner-container">

                                                        <div class="set-local-container">
                                                            <p class="set-title">Local Set</p>
                                                            <div id="setContainerLocal">
                                                                @foreach($scores as $score)
                                                                    @if($score->teamId == $eventTeams[0]->teamId)
                                                                        <label>
                                                                            <input type="hidden" name="sets[localOldNumberSet:{{$score->numberSet}}][setNumber]" value="{{$score->numberSet}}">
                                                                        </label>
                                                                        <label>
                                                                            <input type="hidden" name="sets[localOldNumberSet:{{$score->numberSet}}][team]" value="{{$eventTeams[0]->teamId}}">
                                                                        </label>
                                                                        <label>
                                                                            <input type='number' name='sets[localOldNumberSet:{{$score->numberSet}}][set]' value={{$score->points}}>
                                                                        </label>
                                                                        
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>

                                                        <div class="set-visitor-container">
                                                            <p class="set-title">Visitor Set</p>
                                                            <div id="setContainerVisitor">
                                                                @foreach($scores as $score)
                                                                    @if($score->teamId == $eventTeams[1]->teamId)
                                                                        <label>
                                                                            <input type="hidden" name="sets[visitorOldNumberSet:{{$score->numberSet}}][setNumber]" value="{{$score->numberSet}}">
                                                                        </label>
                                                                        <label>
                                                                            <input type="hidden" name="sets[visitorOldNumberSet:{{$score->numberSet}}][team]" value="{{$eventTeams[1]->teamId}}">
                                                                        </label>
                                                                        <label>
                                                                            <input type='number' name='sets[visitorOldNumberSet:{{$score->numberSet}}][set]' value={{$score->points}}>
                                                                        </label>
                                                                        
                                                                    @endif
                                                                @endforeach
                                                            </div>
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
                                            

                                        

                                    </div>
                                    <div class="form-down-container">
        
                                        <input type="submit" value="Edit" class="create-btn" id="submit">

                                        <div id="error" class="error"></div>

                                    </div>
                            </form>
                </div>
            </div>
        </div>
        
    </main>

    <script>
        var setNumberVisitor = 0;
        var setNumberLocal = 0;

        let addSets = ()=>{
            idTeamLocal = document.getElementById("localTeamSets").value;
            idTeamVisitor = document.getElementById("visitorTeamSets").value;

            setNumberLocal++;
            setNumberVisitor++;

            document.getElementById("setContainerLocal").innerHTML += `
            <label>
                <input type="hidden" name="sets[localNewNumberSet:${setNumberLocal}][team]" value="${idTeamLocal}">
            </label>
            <label>
                <input type='number' name='sets[localNewNumberSet:${setNumberLocal}][set]'>
            </label>
            `;

            document.getElementById("setContainerVisitor").innerHTML += `
            <label>
                <input type="hidden" name="sets[visitorNewNumberSet:${setNumberLocal}][team]" value="${idTeamVisitor}">
            </label>
            <label>
                <input type='number' name='sets[visitorNewNumberSet:${setNumberLocal}][set]'>
            </label>
            `;
    }
    
    jQuery('#localTeamSets').change(function(){
        document.getElementById("setContainerLocal").innerHTML ="";
        document.getElementById("setContainerVisitor").innerHTML ="";
    });

    jQuery('#visitorTeamSets').change(function(){
        document.getElementById("setContainerLocal").innerHTML ="";
        document.getElementById("setContainerVisitor").innerHTML ="";
    });
    ;
    </script>
</body>
</html>