<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Players</title>
</head>
<body>
    <main>
        <div class="modalContainer" style='display:none' id="modalContainer">
            <form id="adTeamModal" action="/player/addTeam" method="POST">
                @csrf

                <div class="xContainer">
                    <button onClick="manageModal('hide',0)" type="button"><span class="material-symbols-outlined">cancel</span></button>
                    <h4 id="test">Add team</h4>
                </div>
                <label>
                    Team name:
                    <select name="teamName" id="teamName">
                        @foreach($teams as $team)
                            <option value="{{$team->name}}">{{$team->name}}</option>
                        @endforeach
                    </select>
                    <input type="text" name="playerId" id="playerId" class="hidden">
                    Contract Start
                    <input type="date" name="contractStart"id="contractStart">
                    Contract End
                    <input type="date" name="contractEnd"id="contractEnd">
                    Status
                    <select name="status" id="status">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    

                </label>
                <input type="submit" class="submit-btn">
            </form>
        </div>
        
        @include('navbar')

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Player Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create player 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create Player</h2>
    
                        <form action="/player/create" class="create-user-form" method="POST" id="creationForm" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="John" id="name">
                                    </label>
                                    <label>
                                        <p><span>* </span>Surname</p>
                                        <input type="text" name="surname" placeholder="Doe" id="surname">
                                    </label>
                                   
                                    <label>
                                        <p>Player image</p>
                                        <input type="file" name="image" accept="image/*" id="imageInput" class="input-image">
                                        <label for="imageInput" class="label-image">
                                            <span class="material-symbols-outlined">upload</span>
                                            <p>Upload an image...</p>
                                        </label>
                                    </label>

                                    <label>
                                        <p>Team name</p>
                                        <select name="team" id="teamName">
                                            @foreach($teams as $team)
                                            <option value="{{$team->id}}">{{$team->name}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label>
                                        <p><span>* </span>Contract start date</p>
                                        <input type="date" name="contractStart"id="contractStart">
                                    </label>
                                    <label>
                                        <p><span>* </span>Contract end date</p>
                                        <input type="date" name="contractEnd" id="contractEnd">
                                    </label>
                                    <label>
                                        <p><span>* </span>Status</p>
                                        <select name="status" id="status">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </label>
    
                                </div>

                                <div class="form-inner-container individual">
                                    <label>
                                        <p>Individual Team</p>
                                        <input type="checkbox" name="individual" class="individual-checkbox">
                                    </label>
                                    <label>
                                        <p>Individual Team's Sport</p>
                                        <select name="sport" id="sport">
                                            @foreach($sports as $sport)
                                            <option value="{{$sport->id}}">{{$sport->name}}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label>
                                        <p>Individual Team's Country</p>
                                        <select name="country" id="country">
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}">{{$country->name}}</option>
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

            <div class="user-table-container">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th> </th>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Image</th>
                            <th>Team</th>
                            <th>Contract Start</th>
                            <th>Contract End</th>
                            <th>Status</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($players as $player)
                            <tr>
                                    <form class="entry" method="POST" action="/player/{{$player->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$player->id}}</p>

                                        </td>

                                        <td class="user-profile-pic">

                                            <div class="image-container">
                                                <img src="{{ asset('img/public_images').'/'.$player->photo }}" alt="">
                                            </div>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$player->name}}">
                                            </label>
                                        </td>
    
                                        <td class="user-name">
                                            <label>
                                                <input name="surname" type="text" value="{{$player->surname}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-image">
                                            <label class="custom-selector">
                                                <input type="file" name="image" accept="image/*" id="{{$player->id}}" class="input-image">
                                                <label for="{{$player->id}}" class="label-image">
                                                    <span class="material-symbols-outlined">upload</span>
                                                    <p>Change image...</p>
                                                </label>
                                            </label>
                                        </td>
                                        
                                        <td class="user-type">
                                            <label>
                                                <select name="teamName" readonly>
                                                    <option value="{{$player->teamID}}">{{$player->teamName}}</option>
                                                </select>
                                             </label>
                                        </td>
                                        <td class="user-name">
                                            <label>
                                                <input type="date" name="contractStart"id="contractStart" value="{{$player->contractStart}}">
                                            </label>
                                        </td>
                                        <td class="user-name">
                                            <label>
                                                <input type="date" name="contractEnd" id="contractEnd" value="{{$player->contractEnd}}">
                                            </label>
                                        </td>
                                        <td class="user-type">
                                            <label>
                                                <select name="status" id="status">
                                                    <option value="active" @if($player->status=='active')selected @endif>Active</option>
                                                    <option value="inactive" @if($player->status=='inactive')selected @endif>Inactive</option>
                                                </select>
                                            </label>
                                        </td>
                                        <td class="actions-buttons">
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="manageModal('show',{{$player->id}})"><span class="material-symbols-outlined">add</span></button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$player->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/player/{{$player->id}}"method="POST" class="delete" id="delete_form_{{$player->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{$players->links()}}
            </div>

        </div>

    </main>

    <script>


        const deleteFormSubmit = (id) =>{

            event.preventDefault();
            document.getElementById('delete_form_'+id).submit();

        }

        const manageModal = (action, id) => {
            const modalContainer = document.getElementById('modalContainer');
            const playerId = document.getElementById('playerId');
            if(action == "hide"){
                modalContainer.style.display = "none";
            }
            else{
                modalContainer.style.display = "flex";

            }
            playerId.value = id;
        }

    </script>
    <script>
        document.getElementById('player').classList.add("focus");
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>