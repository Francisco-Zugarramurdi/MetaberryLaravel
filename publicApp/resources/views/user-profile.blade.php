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
    
    @include('layouts.navbar')

    <main>
        <section class="userDisplay">
            <div class="user">
                <a class="profile-image" href="/user"><img id="displayImage"></a>
                <div class="data">
                    <p class="userName" id="displayName"></p>
                    <p class="email" id="displayEmail"></p>
                </div>
                <a href="/user/edit" class="edit-user-btn"><span class="material-symbols-outlined">settings</span></a>
                
            </div>
        </section>
        <section class="innerNav">
            <button type="button" class="user-profile">Events</button>
            <button type="button">Teams</button>
            <button type="button">Leagues</button>
        </section>
        <section class="display">
            
        </section>
    </main>

    <script>

        jQuery(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                url: "{{ url('/userData') }}",
                method: 'POST',
                success: function(data){
                    const image = document.getElementById('displayImage')
                    const name = document.getElementById('displayName')
                    const email = document.getElementById('displayEmail')

                    name.innerHTML = `${data['name']}`;
                    email.innerHTML = `${data['email']}`;
                    image.src = `http://127.0.0.1:8005/img/public_images/${data['photo']}`;

                }
            });
        });

    </script>
</body>
</html>