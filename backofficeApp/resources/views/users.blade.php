<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Users</title>
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

            </div>

        </div>

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>User Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create user 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create user</h2>
    
                        <form action="/user/create" class="create-user-form" method="POST" id="creationForm">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="John" id="name">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Email</p>
                                        <input type="text" name="email" placeholder="jonhdoe@gmail.com" id="email">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Password</p>
                                        <input type="password" name="password"id="password">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Profile image</p>
                                        <input type="text" name="photo" placeholder="somelink.com"id="photo">
                                    </label>
    
                                </div>
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Type of user</p>
                                        <select name="type_of_user" id="type_of_user">
                                            <option value="free">Free</option>
                                            <option value="paid">Paid</option>
                                        </select>
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Points</p>
                                        <input type="number" name="points" value="" placeholder="300" id="points">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Total points</p>
                                        <input type="number" name="total_points" value="" placeholder="300" id="totalPoints">
                                    </label>
    
                                    <label>
                                        <p>Credit card</p>
                                        <input type="number" name="credit_card" value="" placeholder="4123412341234123" id="card">
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
                            <th>Email</th>
                            <th>Image</th>
                            <th>Type User</th>
                            <th>Points</th>
                            <th>Total Points</th>
                            <th>Credit Card</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                    <form class="entry" method="POST" action="/user/{{$user->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$user->id}}</p>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$user->name}}">
                                            </label>
                                        </td>
    
                                        <td class="user-email">
                                            <label>
                                                <input name="email" type="text" value="{{$user->email}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-image">
                                            <label>
                                                <input name="photo" type="text" value="{{$user->photo}}">
                                            </label>
                                        </td>
    
                                        <td class="user-type">
                                            <label>
                                                @if($user->type_of_user == 'paid')
                                                <select name="type_of_user">
                                                    <option value="free">Free</option>
                                                    <option value="paid" selected>Paid</option>
                                                </select>
                                                @else
                                                <select name="type_of_user">
                                                    <option value="free" selected>Free</option>
                                                    <option value="paid">Paid</option>
                                                </select>
                                                @endif
                                            </label>
                                        </td>
    
                                        <td class="user-points">
                                            <label>
                                                <input type="number"name="points" value="{{$user->points}}">
                                            </label>
                                        </td>
    
                                        <td class="user-total-points">
                                            <label>
                                                <input type="number" name="total_points" value="{{$user->total_points}}">
                                            </label>
                                        </td>
    
                                        <td class="user-card">
                                            <label>
                                                <input type="number"name="credit_card" value="{{$user->credit_card}}">
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

                                <form action="/user/{{$user->id}}"method="POST" class="delete" id="delete_form">
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