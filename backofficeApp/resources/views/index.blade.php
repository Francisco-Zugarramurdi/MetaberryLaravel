<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Livescore Backoffice</title>
</head>
<body>
    <main>

        @include('navbar')

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Backoffice</h1>

            </div>

            <div class="main-section">

                <div class="option-card-container">

                    <h2>User Management</h2>
                    <a href="/user/">Go to Manage Users</a>

                </div>

                <div class="option-card-container">

                    <h2>Ad Management</h2>
                    <a href="/ads/">Go to Manage Ads</a>

                </div>

                <div class="option-card-container">

                    <h2>Team Management</h2>
                    <a href="/team/">Go to Manage Teams</a>

                </div>

                <div class="option-card-container">

                    <h2>Player Management</h2>
                    <a href="/player/">Go to Manage Players</a>

                </div>

                <div class="option-card-container">

                    <h2>Sport Management</h2>
                    <a href="/sport/">Go to Manage Sports</a>

                </div>

                <div class="option-card-container">

                    <h2>Country Management</h2>
                    <a href="/country/">Go to Manage Countries</a>

                </div>

                <div class="option-card-container">

                    <h2>League Management</h2>
                    <a href="/league/">Go to Manage League</a>

                </div>

                <div class="option-card-container">

                    <h2>Extra Management</h2>
                    <a href="/extra/">Go to Manage Extras</a>

                </div>

                <div class="option-card-container">

                    <h2>Referee Management</h2>
                    <a href="/referee/">Go to Manage Referees</a>

                </div>

                <div class="option-card-container">

                    <h2>Event Management</h2>
                    <a href="/event/">Go to Manage Events</a>

                </div>

                <div class="option-card-container">

                    <h2>Sanction Management</h2>
                    <a href="/sanction/">Go to Manage Sanctions</a>

                </div>

                <div class="option-card-container">

                    <h2>Subscription Management</h2>
                    <a href="/user/subscription">Go to Manage Subscription</a>

                </div>

            </div>

        </div>
        <!-- <a href="/user/">Users</a>
        <a href="/ads/">Ads</a> -->

    </main>
    <script>
        document.getElementById('index').classList.add("focus");
    </script>
</body>
</html>
