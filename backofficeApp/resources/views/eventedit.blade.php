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
                    
                            <form class="create-user-form" method="POST" action="/event/edit/{{$event->id}}">
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
                                            <input type="text" name="details" id="name" value="{{$event->details}}">
                                        </label>
                                        <label>
                                            <p>Date:</p>
                                            <input type="date" name="date" id="name" value="{{$event->date}}">
                                        </label>
                                        <label>
                                            <p>Relevance:</p>
                                            <input type="number" name="relevance" id="name" value="{{$event->relevance}}">
                                        </label>
                                        <label>
                                        <p>Country:</p>
                                            <select name="country" class="country">
                                                @foreach($countries as $country)
                                                <option value="{{$country->id}}" @if($country->name == $event->countryName)selected @endif>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                        <p>Sport:</p>
                                            <select name="sport" class="sport">
                                                @foreach($sports as $sport)
                                                <option value="{{$sport->id}}" @if($sport->name == $event->sportName)selected @endif>{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p>League:</p>
                                            <select name="league" class="league">
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
                                    </div>
                                    <div class="form-up-container">
                                        @if($event->typeResult == "points_sets")

                                        @endif
                                        @if($event->typeResult == "results_points")

                                        @endif
                                        @if($event->typeResult == "results_upward")
                                            @foreach ($results as $result)
                                            <div class="team-container">
            
                                                <label>
                                                    Team
                                                    <select name="marks[][team]">
                                                        @foreach($teams as $team)
                                                            <option value="{{$team->id}}"@if($team->id == $result->teamId)selected @endif>{{$teams->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>

                                                <label>
                                                    marks
                                                    <input type="number" name="marks[][mark]" min="1">
                                                </label>
                                        
                                            </div>

                                            @endforeach
                                        @endif
                                        @if($event->typeResult == "results_downward")
                                        @foreach ($results as $result)
                                            <div class="team-container">
            
                                                <label>
                                                    Team
                                                    <select name="marks[][team]">
                                                        @foreach($teams as $team)
                                                            <option value="{{$team->id}}"@if($team->id == $result->teamId)selected @endif>{{$teams->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </label>

                                                <label>
                                                    marks
                                                    <input type="number" name="marks[][mark]" min="1">
                                                </label>
                                        
                                            </div>

                                            @endforeach
                                        @endif
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
    
</body>
</html>