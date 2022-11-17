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
    <link rel="stylesheet" href="{{ asset('assets/css/sign-up.css') }}">
    <title>Livescore - Sign Up</title>
</head>

<body>

    @include('layouts.navbar')

    <main>

        <div class="sign-form-container">

            <div class="sign-container">

                <form action="/signup" method="post" id="form">
                @csrf
                @method('POST')

                    <div class="sign-text-container">

                        <h1 class="sign-title">Welcome! Sign Up</h1>
                        <p class="sign-text">Already have an account? <a href="/login">Log In</a></p>

                    </div>

                    <div class="form-name-container">

                        <label>
    
                            Nickname
    
                            <input type="text" name="name" id="name" placeholder="Alice Smith" required>
    
                        </label>

                    </div>

                    <label>

                        Email

                        <input class="sign-form-input" type="text" name="email" id="email"
                            placeholder="alicesmith@gmail.com" required>

                    </label>

                    <label>

                        Password

                        <input class="sign-form-input" type="password" name="password" id="password"
                        required>

                    </label>

                    <label>

                        Password confirmation

                        <input class="sign-form-input" type="password" name="password_confirmation" id="password-confirmation"
                        required>

                    </label>

                    <input class="sign-form-button" type="submit" value="Create Account">

                    @if(isset($error))
                        @foreach($body as $error)
                            <p class="error">{{$error[0]}}</p>
                        @endforeach
                    @endif

                </form>

            </div>

            <div class="sign-aside-container">
                
                <div class="image-container">

                    <div class="text-up">

                        <p>LA. Fem. Athletism</p>
                        <p>12 hours ago</p>

                    </div>

                    <div class="text-down">

                        <p>The girls are now practicing for the next tournament. 
                            We can't wait to see you guys there! Are you coming?
                        Don't miss our upcoming match, 13th of August at the Lockhart Field in LA.</p>

                    </div>

                    <img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/illustrations/abstract-729.gif?raw=true" alt="" class="right">
                    <img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/illustrations/abstract-red-speech-bubble.gif?raw=true" class="left" alt="">
                    <p class="legal">All pictures shown are for illustation purpose only. The actual product may vary.</p>

                </div>
            
            </div>

        </div>

    </main>

</body>

</html>