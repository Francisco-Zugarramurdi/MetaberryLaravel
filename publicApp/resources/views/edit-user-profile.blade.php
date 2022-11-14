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
        <section class="edit-user-container">

            <h1>Edit profile</h1>

            <form method="POST" action="/user/edit">
                @method('POST')
                @csrf

                <div class="form-up-container">
                    <label>
                        Nickname
                        <input type="text" class="input" id='inputName' value="" name="name">
                    </label>

                    <label>
                        Email
                        <input type="text" class="input" id='inputEmail' value="" name="email">
                    </label>

                    <label>
                        Password
                        <input type="password" class="input" name="password">
                    </label>

                    <a href="/subscribe" class="upgrade-account">Upgrade account</a>

                    <a class="logout-button" href="/logout"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                </div>
                <div class="form-down-container">
                    <button type="submit">Update profile</button>
                </div>

            </form>

            <form id="logout-form" action="/logout" method="POST" class="d-none">
                @csrf
            </form>

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

                    $('#inputEmail').attr('placeholder',`${data['email']}`);
                    $('#inputEmail').val(`${data['email']}`);
                    $('#inputName').attr('placeholder',`${data['name']}`);
                    $('#inputName').val(`${data['name']}`);

                }
            });
        });
    </script>

</body>
</html>