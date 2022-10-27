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
    <title>Sanctions</title>
</head>
<body>
    <main>
       
        
        @include('navbar')

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Sanctions Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create sanction 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create Sanction</h2>
    
                        <form action="/sanction/create" class="create-user-form" method="POST" id="creationForm">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
                                    <label>
                                        Type:
                                        <select id="type" name="type">
                                            <option value="Player" default>Player</option>
                                            <option value="Extra">Extra</option>
                                        </select>
                                    </label>
                                    <label>
                                        Event:
                                       <select name="event" id="eventSelect" class="event">
                                        @foreach($events as $event)
                                            <option value="{{$event->id}}">{{$event->name}}</option>
                                        @endforeach
                                       </select>
                                    </label>
                                    <label>
                                        <p id="labelID">Player:</p>
                                       <select name="player" id="playerSelect">
                                        <option>Select an event</option>
                                       </select>
                                    </label>
                                    <label>
                                        Sanction:
                                        <input type="text" name="sanction" id="sanction">
                                    </label>
                                    <label>
                                        Minute:
                                        <input type="number" name="minute" id="minute">
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

            <div class="user-table-container">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Player</th>
                            <th>Sanction</th>
                            <th>Event</th>
                            <th>Minute</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sanctions as $sanction)
                            <tr>
                                    <form class="entry" method="POST" action="/sanction/{{$sanction->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">
                                        <input name="type" type="hidden" value="Player" style="display:none">
                                        <td class="user-id">

                                            <p>{{$sanction->id}}</p>

                                        </td>

                                        <td class="user-type">
                                            <label>
                                                <select name="player" readonly>
                                                    <option value="{{$sanction->idPlayer}}" selected>{{$sanction->namePlayer}} {{$sanction->surnamePlayer}}</option>
                                                </select>
                                            </label>
                                        </td>
    
                                        <td class="user-name">
                                            <label>
                                                <input name="sanction" type="text" value="{{$sanction->sancion}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-name">
                                            <label>
                                                <input name="event" type="text" value="{{$sanction->nameEvent}}" readonly>
                                            </label>
                                        </td>
                                        <td class="user-name">
                                            <label>
                                                <input type="number" name="minute" value="{{$sanction->minute}}">
                                            </label>
                                        </td>

                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$sanction->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/sanction/{{$sanction->id}}"method="POST" class="delete" id="delete_form{{$sanction->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="hidden" name="type" value="Player">
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

            <div class="user-table-container">
                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Extra</th>
                            <th>Sanction</th>
                            <th>Event</th>
                            <th>Minute</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sanctionsExtra as $sanction)
                            <tr>
                                    <form class="entry" method="POST" action="/sanction/{{$sanction->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">
                                        <input name="type" type="hidden" value="Extra" style="display:none">
                                        <td class="user-id">

                                            <p>{{$sanction->id}}</p>

                                        </td>

                                        <td class="user-type">
                                            <label>
                                                <select name="player" readonly>
                                                    <option value="{{$sanction->idPlayer}}" selected>{{$sanction->namePlayer}} {{$sanction->surnamePlayer}}</option>
                                                </select>
                                            </label>
                                        </td>
    
                                        <td class="user-name">
                                            <label>
                                                <input name="sanction" type="text" value="{{$sanction->sancion}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-name">
                                            <label>
                                                <input name="event" type="text" value="{{$sanction->nameEvent}}" readonly>
                                            </label>
                                        </td>
                                        <td class="user-name">
                                            <label>
                                                <input type="number" name="minute" value="{{$sanction->minute}}">
                                            </label>
                                        </td>

                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$sanction->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/sanction/{{$sanction->id}}"method="POST" class="delete" id="delete_form{{$sanction->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                    <input type="hidden" name="type" value="Extra"> 
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </main>

    <script>


        const deleteFormSubmit = (id) =>{

            event.preventDefault();
            document.getElementById(`delete_form${id}`).submit();

        }
      

    </script>
    <script>
        document.getElementById('sanction').classList.add("focus");
    </script>
    <script>

            jQuery(document).ready(function(){

                jQuery('#eventSelect').change(handleSelectUpdate())

                function handleSelectUpdate(){
                    if(jQuery('#type').val() == "Player")
                    updateByPlayer();
                    if(jQuery('#type').val() == "Extra")
                    updateByExtra();

                }
                function updateByPlayer(){
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                    });
                    jQuery.ajax({
                    url: "{{ url('/player/indexByEvent') }}",
                    method: 'POST',
                    data: {
                        id:jQuery('#eventSelect').val()
                    },
                    success: function(players){
                        let options = '';
                        console.log(players);
                        Object.keys(players).forEach(player => {
                        options += `<option value="${players[player].id}">${players[player].name} ${players[player].surname}</option>`
                        }); 
    
                        document.getElementById('playerSelect').innerHTML = `${options}`;

                    }});
                }
                function updateByExtra(){
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                    });
                    jQuery.ajax({
                    url: "{{ url('/extra/indexByEvent') }}",
                    method: 'POST',
                    data: {
                        id:jQuery('#eventSelect').val()
                    },
                    success: function(extras){
                        let options = '';
                        console.log(extras);
                        Object.keys(extras).forEach(extra => {
                    
                        options += `<option value="${extras[extra].id}">${extras[extra].name} ${extras[extra].surname}</option>`
                        }); 
    
                        document.getElementById('playerSelect').innerHTML = `${options}`;

                    }});
                }
                jQuery('#type').change(function(){
                    console.log("A");
                    if(jQuery('#eventSelect').val()){
                        handleSelectUpdate();
                    }
                    document.getElementById('labelID').innerHTML = `${jQuery('#type').val()}:`
                })
            });
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script?>
</body>
</html>