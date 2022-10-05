<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>League</title>
</head>
<body>
    <main>

        <div class="empty"></div>

        <div class="side-container">

            <div class="logo-container">

                <img src="{{ asset('img/logo/livescore-logo-white.png') }}">

            </div>

            <div class="routes-container">

                <a href="/" class="routes-list-element"><span class="material-symbols-outlined">home</span> Main</a>
                <a href="/user/" class="routes-list-element"><span class="material-symbols-outlined">person</span> Users</a>
                <a href="/ads/" class="routes-list-element"><span class="material-symbols-outlined">ads_click</span> Ads</a>
                <a href="/players/" class="routes-list-element"><span class="material-symbols-outlined">directions_run</span>Players</a>
                <a href="/sport/" class="routes-list-element"><span class="material-symbols-outlined">sports</span> Sports</a>
                <a href="/country/" class="routes-list-element"><span class="material-symbols-outlined">public</span> Country</a>
                <a href="/league/" class="routes-list-element focus"><span class="material-symbols-outlined">shield</span> League</a>

            </div>

        </div>

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>League Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create league 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create league</h2>
    
                        <form action="/league/create" class="create-user-form" method="POST" id="creationForm">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="Manshield Acuatic League" id="name">
                                    </label>

                                    <label>
                                        <p><span>* </span>Details</p>
                                        <textarea name="details" id="details" cols="30" rows="10" placeholder="The Manshield Acuatic League, since 1972"></textarea>
                                    </label>

                                    <label>
                                        <p><span>* </span>Profile image</p>
                                        <input type="text" name="photo" placeholder="somelink.com" id="photo">
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
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($leagues as $league)
                            <tr>
                                    <form class="entry" method="POST" action="/league/{{$league->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$league->id}}</p>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$league->name}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-image">
                                            <label>
                                                <input name="photo" type="text" value="{{$league->photo}}">
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

                                <form action="/league/{{$league->id}}"method="POST" class="delete" id="delete_form">
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

    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>