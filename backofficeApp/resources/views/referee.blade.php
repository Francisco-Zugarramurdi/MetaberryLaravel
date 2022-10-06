<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Referee</title>
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
                <a href="/team/" class="routes-list-element"><span class="material-symbols-outlined">shield</span>Teams</a>
                <a href="/player/" class="routes-list-element"><span class="material-symbols-outlined">directions_run</span>Players</a>
                <a href="/sport/" class="routes-list-element"><span class="material-symbols-outlined">sports</span> Sports</a>
                <a href="/country/" class="routes-list-element"><span class="material-symbols-outlined">public</span> Country</a>
                <a href="/league/" class="routes-list-element"><span class="material-symbols-outlined">shield</span> League</a>
                <a href="/extra/" class="routes-list-element"><span class="material-symbols-outlined">person</span> Extras</a>
                <a href="/referee/" class="routes-list-element focus"><span class="material-symbols-outlined">sports_score</span> Referee</a>

            </div>

        </div>

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Referee Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create referee 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create referee</h2>
    
                        <form action="/referee/create" class="create-user-form" method="POST" id="creationForm">
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
                                        <p><span>* </span>Profile image</p>
                                        <input type="text" name="photo" placeholder="somelink.com"id="photo">
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
                            <th>Image</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($referees as $referee)
                            <tr>
                                    <form class="entry" method="POST" action="/referee/{{$referee->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$referee->id}}</p>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$referee->name}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-name">
                                            <label>
                                                <input name="surname" type="text" value="{{$referee->surname}}">
                                            </label>
                                        </td>

                                        <td class="user-image">
                                            <label>
                                                <input name="photo" type="text" value="{{$referee->photo}}">
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

                                <form action="/referee/{{$referee->id}}"method="POST" class="delete" id="delete_form">
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