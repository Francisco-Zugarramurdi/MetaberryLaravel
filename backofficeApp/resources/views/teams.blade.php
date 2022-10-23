<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Teams</title>
</head>
<body>
    <main>

        @include('navbar')


        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Team Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create team 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create team</h2>
    
                        <form action="/team/create" class="create-user-form" method="POST" id="creationForm" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="Nacional" id="name">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Profile image</p>
                                        <input type="file" name="image" accept="image/*" id="photo">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Type of Team</p>
                                        <select name="typeTeam" id="typeTeam">
                                            <option value="Group">Group</option>
                                            <option value="Individual">Individual</option>
                                        </select>
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Sport</p>
                                        <select name="sportName" id="sportName">
                                            @foreach ($sports as $sport)
                                            <option value="{{$sport->name}}" name="{{$sport->name}}">{{$sport->name}}</option>
                                            @endforeach
                                        </select>
                                    </label>

                                    <label>
                                        <p><span>* </span>Country</p>
                                        <select name="countryName" id="countryName">
                                            @foreach ($countries as $country)
                                            <option value="{{$country->name}}" name="{{$country->name}}">{{$country->name}}</option>
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
                            <th>Photo</th>
                            <th>Type of Team</th>
                            <th>Sport</th>
                            <th>Country</th>
                            <th>Action</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($teams as $team)
                            <tr>
                                    <form class="entry" method="POST" action="/team/{{$team->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$team->id}}</p>

                                        </td>

                                        
                                        <td class="user-profile-pic">

                                            <div class="image-container">
                                                <img src="{{ asset('img/public_images').'/'.$team->photo }}" alt="">
                                            </div>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$team->name}}">
                                            </label>
                                        </td>

                                        <td class="user-image">
                                            <label>
                                                <input type="file" name="image" accept="image/*" id="photo">
                                            </label>
                                        </td>
                                        
                                        <td class="user-type">
                                        <label>
                                                <select name="typeTeam" id="typeTeam">
                                                    <option value="Group" @if($team->typeTeam=='Group')selected @endif>Group</option>
                                                    <option value="Individual" @if($team->typeTeam=='Individual')selected @endif>Individual</option>
                                                </select>
                                            </label>
                                        </td>
    
                                        <td class="user-type">

                                            <label>
                                                <select name="sportName" id="sportName">
                                                @foreach ($sports as $sport)
                                                <option value="{{$sport->name}}" name="{{$sport->name}}" @if($sport->name == $team->sportName) selected @endif >{{$sport->name}}</option>
                                                @endforeach
                                                </select>
                                            </label>

                                        </td>
    
                                        <td class="user-type">

                                            <label>
                                                <select name="countryName" id="countryName">
                                                @foreach ($countries as $country)
                                                <option value="{{$country->name}}" name="{{$country->name}}" @if($country->name == $team->countryName) selected @endif >{{$country->name}}</option>
                                                @endforeach
                                                </select>
                                            </label>

                                        </td>

                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$team->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/team/{{$team->id}}"method="POST" class="delete" id="delete_form_{{$team->id}}">
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


        const deleteFormSubmit = (id) =>{

            event.preventDefault();
            document.getElementById('delete_form_'+id).submit();

        }
        
    </script>
    <script>
        document.getElementById('team').classList.add("focus");
    </script>

    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>