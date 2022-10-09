<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Ads</title>
    <!-- <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
        h1{
            color: red;
        }
        body{
            display: flex;
            flex-direction: column;
            font-family: 'Roboto';
            color: white;
            background-color: lightgray;
        }
        form{
            padding: 2%;
            margin: 1%;
            margin-bottom:0;
            display: flex;
            flex-direction: row;
            width: 70%;
            align-items:center;
            justify-content: space-between;
            background-color: darkgray;
            border-radius: 0 20px 20px 0; 
        }
        form.creation{
            width:40%;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 1%;
        }
        .column{
            display: flex;
            flex-direction: column;
        }
        .delete{
            width:10%;
            margin-top: 0%;
            margin-bottom: 1%;
            border-top-right-radius: 0;
        }
    </style> -->
</head>
<body>
    <main>

        <div class="empty"></div>

        <div class="side-container">

            <div class="logo-container">

                <img src="{{ asset('img/logo/livescore-logo-white.png') }}" alt="blabla">

            </div>

            <div class="routes-container">

                <a href="/" class="routes-list-element"><span class="material-symbols-outlined">home</span> Main</a>
                <a href="/user/" class="routes-list-element focus"><span class="material-symbols-outlined">person</span> Users</a>
                <a href="/ads/" class="routes-list-element"><span class="material-symbols-outlined">ads_click</span> Ads</a>
                <a href="/player/" class="routes-list-element"><span class="material-symbols-outlined">directions_run</span>Players</a>
                <a href="/sport/" class="routes-list-element"><span class="material-symbols-outlined">sports</span> Sports</a>
                <a href="/country/" class="routes-list-element"><span class="material-symbols-outlined">public</span> Country</a>
            
            </div>

        </div>

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Ads Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create ads 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create ads</h2>
    
                        <form action="/ads/create" class="create-user-form" method="POST" id="creationForm">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Image</p>
                                        <input type="text" name="image" placeholder="FutbolAd.com" id="image">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Url</p>
                                        <input type="text" name="url" placeholder="Futbol.com" id="url">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Size</p>
                                        <input type="text" name="size"id="size" placeholder="Large">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Views hired</p>
                                        <input type="text" name="viewsHired" placeholder="100" id="viewsHired">
                                    </label>

                                    <label>
                                        <p><span>* </span>Tag</p>
                                        <input type="text" name="tag" placeholder="Futbol" id="tag">
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
                            <th>Image</th>
                            <th>Url</th>
                            <th>Size</th>
                            <th>Views hired</th>
                            <th>Tag</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($ads as $ad)
                            <tr>
                                    <form class="entry" method="POST" action="/ads/{{$ad->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$ad->id}}</p>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="image" type="text" value="{{$ad->image}}">
                                            </label>
                                        </td>
    
                                        <td class="user-email">
                                            <label>
                                                <input name="url" type="text" value="{{$ad->url}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-image">
                                            <label>
                                                <input name="size" type="text" value="{{$ad->size}}">
                                            </label>
                                        </td>
    
                                        <td class="user-points">
                                            <label>
                                                <input type="text"name="viewsHired" value="{{$ad->views_hired}}">
                                            </label>
                                        </td>
    
                                        <td class="user-total-points">
                                            <label>
                                                <input type="text" name="tag" value="{{$ad->tag}}">
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

                                <form action="/ads/{{$ad->id}}"method="POST" class="delete" id="delete_form">
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
    
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>