<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/../css/style-users.css">
    <title>Users</title>
    <style>
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
    </style>
</head>
<body>
        <h1>Backoffice User's Administration</h1>
        <form method="POST" action="/api/user/create" class="creation">
                <h2 style="color:black">Create an user</h2>
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
                    <input name="password" type="text" value="">
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
        <h2 style="color:red;font-size:2em;">User's List</h2>
        @foreach($users as $user)
            <form class="entry" method="POST" action="/api/user/{{$user->id}}">
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
                <form action="/api/user/{{$user->id}}"method="POST" class="delete">
                    @method('DELETE')
                    @csrf
                    {{method_field('DELETE')}}
                    <input name="_method" type="hidden" value="DELETE">
                    <input type="submit" value="Delete User">
                </form>
                @endforeach
            </body>
            </html>