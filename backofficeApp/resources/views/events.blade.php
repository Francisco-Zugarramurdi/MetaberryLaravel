<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
    
                    <button type="button" class="dropdown-button" id="button-set" onClick="dropdown()">Create event by Sets
                        <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                    </button>
    
                    <div class="unhide-container hide" id="sets">
    
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
                                            <input type="number" name="relevance" id="relevance" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="country">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sport">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->id}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="league">
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->id}}">{{$league->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <p>Result is ready</p>
                                            <input type="checkbox" name="resultReady">
                                        </label>
                                    </div>
                                    <div class="form-inner-container">
                                        <label>
                                            Local Team
                                            <select name="localTeam" id="localTeam">
                                                @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            Vistant Team
                                            <select name="visitantTeam" id="visitantTeam">
                                                @foreach($teams as $team)
                                                    <option value="{{$team->id}}">{{$team->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label>
                                            <button type="button" id="add-set-local">Add Set for Local Team</button>
                                            <div id="setContainerLocal"></div>
                                            
                                        </label>
                                        <label>
                                            <button type="button" id="add-set-visitant">Add Set for Visitant Team</button>
                                            <div id="setContainerVisitant"></div>
                                            
                                        </label>
                                        <label>
                                            Winner
                                            <select name="winner" id="winner">
                                                <option value="local">Local</option>
                                                <option value="visitant">Visitant</option>
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
    
                    <button type="button" class="dropdown-button" id="button-points" onClick="dropdown()">Create event by Points
                        <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                    </button>
    
                    <div class="unhide-container hide" id="points">
    
                            <h2>Create Event by Points</h2>
        
                            <form action="/event/create" class="create-user-form" method="POST" id="creationForm">
                                @method('POST')
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
                                            <input type="number" name="relevance" id="relevance" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="country">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sport">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->name}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="league">
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->name}}">{{$league->name}}</option>
                                                @endforeach
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
                    
                    <button type="button" class="dropdown-button" id="button-markUp" onClick="dropdown()">Create event by Mark Up
                        <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                    </button>
    
                    <div class="unhide-container hide" id="markUp">
    
                            <h2>Create Event by Mark Up</h2>
        
                            <form action="/event/create" class="create-user-form" method="POST" id="creationForm">
                                @method('POST')
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
                                            <input type="number" name="relevance" id="relevance" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="country">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sport">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->name}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="league">
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->name}}">{{$league->name}}</option>
                                                @endforeach
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
    
                    <button type="button" class="dropdown-button" id="button-markDown" onClick="dropdown()">Create event by Mark Down
                        <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                        <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                    </button>
    
                    <div class="unhide-container hide" id="markDown">
    
                            <h2>Create Event by Mark Down</h2>
        
                            <form action="/event/create" class="create-user-form" method="POST" id="creationForm">
                                @method('POST')
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
                                            <input type="number" name="relevance" id="relevance" min="1" max="5">
                                        </label>
                                        <label><p><span>* </span>Country</p>
                                            <select name="country" id="country">
                                                @foreach ($countries as $country)
                                                    <option value="{{$country->name}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p><span>* </span>Sport</p>
                                            <select name="sport" id="sport">
                                                @foreach ($sports as $sport)
                                                    <option value="{{$sport->name}}">{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                        <label><p>League</p>
                                            <select name="league" id="league">
                                                @foreach ($leagues as $league)
                                                    <option value="{{$league->name}}">{{$league->name}}</option>
                                                @endforeach
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


            </div>

        </div>
        
           

    </main>


    <script>
        document.getElementById('event').classList.add("focus");
    </script>
    <script src="{{ asset('js/Event.js') }}"></script>
</body>
</html>