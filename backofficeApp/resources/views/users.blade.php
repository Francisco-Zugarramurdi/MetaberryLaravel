<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Users</title>
</head>
<body>
    @if($users)
        @foreach($users as $user)
            <div class="entry">
                <h2>Name: {{$user->name}}</h2>
                <img src="{{$user->photo}}"alt="">
                <p>Email: {{$users->email}}</p>
                <p>Type of User: {{$user->type_of_user}}</p>
                <p>Points:{{$users->points}}</p>
                <p>Total points: {{$->total_points}}</p>
            </div>
        @endforeach
    @endif
</body>
</html>