<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
                                        Event:
                                       <select name="event" id="event">
                                        @foreach($events as $event)
                                            <option value="{{$event->id}}">{{$event->name}}</option>
                                        @endforeach
                                       </select>
                                    </label>
                                    <label>
                                        Player:
                                       <select name="player" id="player">
                                        <option>Select an event</option>
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

            <div class="user-table-container">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Photo</th>
                            <th>Team</th>
                            <th>Contract Start</th>
                            <th>Contract End</th>
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

                                        <td class="user-id">

                                            <p>{{$sanction->id}}</p>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$sanction->name}}">
                                            </label>
                                        </td>
    
                                        <td class="user-name">
                                            <label>
                                                <input name="surname" type="text" value="{{$sanction->surname}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-name">
                                            <label>
                                                <input name="photo" type="text" value="{{$sanction->photo}}">
                                            </label>
                                        </td>
                                        <td class="user-name">
                                            <label>
                                                <input name="teamName" type="text" value="{{$sanction->teamName}}" readonly>
                                            </label>
                                        </td>
                                        <td class="user-image">
                                            <label>
                                                <input type="date" name="contractStart"id="contractStart" value="{{$sanction->contractStart}}">
                                            </label>
                                        </td>
                                        <td class="user-image">
                                            <label>
                                                <input type="date" name="contractEnd" id="contractEnd" value="{{$sanction->contractEnd}}">
                                            </label>
                                        </td>

                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit()">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/sanction/{{$sanction->id}}"method="POST" class="delete" id="delete_form">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

        </div>

    </main>

    <script>


        const deleteFormSubmit = () =>{

            event.preventDefault();
            document.getElementById('delete_form').submit();

        }
      

    </script>
    <script>
        document.getElementById('sanction').classList.add("focus");
    </script>
    <script>

            jQuery(document).ready(function(){
                jQuery('#event').change(function(){
                    $('#event').style.color = "red";
                    $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    }
                    });
                    jQuery.ajax({
                    url: "{{ url('/player/indexByEvent') }}",
                    method: 'POST',
                    data: {
                        id:jQuery('#event').val()
                    },
                    success: function(players){
                        
                        let options = '';
                        Object.keys(players).forEach(player => {
                    
                        options += `<option value="${players[player].id}">${players[player].name}</option>`
                        }); 
    
                        document.getElementById('event').innerHTML = `${options}`;

                    }});
                })

            });
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script?>
</body>
</html>