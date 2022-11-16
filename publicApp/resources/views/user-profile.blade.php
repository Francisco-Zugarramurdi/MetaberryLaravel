<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="_token" content="{{csrf_token()}}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/icon.ico">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="{{ asset('assets/css/user-profile.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Livescore - Profile</title>
</head>

<body>
    
    @include('layouts.navbar', $data)

    <main>
        <section class="userDisplay">
            <div class="user">
                <a class="profile-image" href="/user"><img src="http://127.0.0.1:8005/img/public_images/{{$data['photo']}}"></a>
                <div class="data">
                    <p class="userName" id="displayName">{{$data['name']}}</p>
                    <p class="email" id="displayEmail">{{$data['email']}}</p>
                </div>
                <a href="/user/edit" class="edit-user-btn"><span class="material-symbols-outlined">settings</span></a>
                
            </div>
        </section>
        <section class="innerNav">
            <button type="button" class="user-profile">Events you follow</button>
        </section>
        <section class="display">
            
        </section>
    </main>

</body>
</html>