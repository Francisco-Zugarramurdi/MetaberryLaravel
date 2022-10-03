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

            </div>

        </div>

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>User Management</h1>

            </div>

            <div class="create-user-container">

                <h2>Create User</h2>

                <form action="/user/create" class="create-user-form" method="POST">
                    @method('POST')
                    @csrf
                    
                    <label>
                        <p><span>* </span>Name</p>
                        <input type="text" name="name" placeholder="John">
                    </label>

                    <label>
                        <p><span>* </span>Email</p>
                        <input type="text" name="email" placeholder="jonhdoe@gmail.com">
                    </label>

                    <label>
                        <p><span>* </span>Password</p>
                        <input type="password" name="password">
                    </label>

                    <label>
                        <p><span>* </span>Profile image</p>
                        <input type="text" name="photo" placeholder="somelink.com">
                    </label>

                    <label>
                        <p><span>* </span>Type of user</p>
                        <select name="type_of_user" id="type_of_user">
                            <option value="free">Free</option>
                            <option value="paid">Paid</option>
                        </select>
                    </label>

                    <label>
                        <p><span>* </span>Points</p>
                        <input type="number" name="points" value="" placeholder="300">
                    </label>

                    <label>
                        <p><span>* </span>Total points</p>
                        <input type="number" name="total_points" value="" placeholder="300">
                    </label>

                    <label>
                        <p>Credit card</p>
                        <input type="number" name="credit_card" value="" placeholder="4123412341234123">
                    </label>

                    <input type="submit" value="Create user" class="create-btn">

                </form>

            </div>

        </div>

    </main>

        <h1>Backoffice User's Administration</h1>

        <form method="POST" action="/user/create" class="creation">
            @method('POST')
            @csrf
                <!-- <h2 style="color:black">Create an user</h2> -->
                <label>
                    Name:
                    <input name="name" type="text" value="">
                </label>
                <label>
                    Email:
                    <input name="email" type="text" value="">
                </label>
                <label>
                    Password:
                    <input name="password" type="password" value="">
                </label>
                <label>
                    Image:
                    <input name="photo" type="text" value="">
                </label>
                <label>
                    Type Of User:
                    <input name="type_of_user" type="text" value="" maxlength="8">
                </label>

                <label>
                    Points:
                    <input type="number"name="points" value="">
                </label>
                <label>
                    Total Points:
                    <input type="number"name="total_points" value="">
                </label>
                <label>
                    Credit Card:
                    <input type="number"name="credit_card" value="">
                </label>
            <input type="submit" value="Submit User">
        </form>
        <!-- <h2 style="color:red;font-size:2em;">User's List</h2> -->
        @foreach($users as $user)
            <form class="entry" method="POST" action="/user/{{$user->id}}">
                @method('PUT')
                @csrf
                {{method_field('PUT')}}
                <div class="column">
                    <input name="_method" type="hidden" value="PUT">
                    <label>
                        Name:
                        <input name="name" type="text" value="{{$user->name}}">
                    </label>
                    <label>
                        Image:
                        <input name="photo" type="text" value="{{$user->photo}}">
                    </label>
                    <label>
                        Email:
                        <input name="email" type="text" value="{{$user->email}}">
                    </label>
                    <label>
                        Type Of User:
                        <input name="type_of_user" type="text" value="{{$user->type_of_user}}" maxlength="8">
                    </label>
                </div>
                <div class="column">

                    <label>
                        Points:
                        <input type="number"name="points" value="{{$user->points}}">
                    </label>
                    <label>
                        Total Points:
                        <input type="number"name="total_points" value="{{$user->total_points}}">
                    </label>
                    <label>
                        Credit Card:
                        <input type="number"name="credit_card" value="{{$user->credit_card}}">
                    </label>
                </div>
                <input type="submit" value="Update User">
                </form>
                <form action="/user/{{$user->id}}"method="POST" class="delete">
                    @method('DELETE')
                    @csrf
                    {{method_field('DELETE')}}
                    <input name="_method" type="hidden" value="DELETE">
                    <input type="submit" value="Delete User">
                </form>
                @endforeach
</body>
</html>