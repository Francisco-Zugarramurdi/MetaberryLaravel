<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{csrf_token()}}" />
    <link rel="icon" href="https://raw.githubusercontent.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/main/Dise%C3%B1o/Produccion/assets/img/logo/icon.ico">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
        <link rel="stylesheet" href="{{ asset('assets/css/index-css.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Livescore</title>
</head>

<body>

    @include('layouts.navbar')

    <main>

        <div class="hero-section">

            <div class="hero-section-text">

                <h1>Enjoy from <span>anywhere, at any time</span> your favorite events</h1>
                <h2>You won't miss that special match again. Add to favorites teams, leagues
                    and events to catch up with their activities.
                </h2>
                <a href="/signup" class="join-btn">Join Now</a>

            </div>

            <div class="hero-section-img">

                <img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/illustrations/pablita-879.png?raw=true">

            </div>

        </div>

        <div class="event-section">

            <h2 class="event-head">Most popular events</h2>

            <div class="event-group-container">

                <div class="event-container">

                    <div class="event-title-holder">

                        <a href="/" class="event-title">Event Title</a>
                        <p class="event-state">State</p>

                    </div>

                    <div class="event-holder">

                        <div class="team-holder">

                            <img src="./assets/img/photos/team-logos/60px/argentina.png" class="team-logo">
                            <a href="/" class="team-name">Team Name</a>

                        </div>

                        <div class="score-holder">

                            <p class="event-score">0 - 0</p>

                        </div>

                        <div class="team-holder">

                            <img src="./assets/img/photos/team-logos/60px/uruguay.png" class="team-logo">
                            <a href="/" class="team-name">Team Name</a>

                        </div>

                    </div>

                </div>

            </div>

            <a href="/" class="events-btn">See More</a>

        </div>

        {{-- <div class="about-livescore-section" id="aboutSection">

            <h2 class="about-head">How does Livesore work?</h2>

            <div class="about-card-group-container">

                <div class="about-card-container">

                    <span class="material-symbols-outlined">magic_button</span>

                    <div class="about-card-description-container">

                        <p class="about-description-title">

                            Gain Points

                        </p>

                        <p class="about-description-container">

                            Each actions you make comes with a reward, liking, commenting and publishing posts also you
                            can have a selection up to 3 "favorite" teams and every time they win a match you earn more
                            points! and of course you can always bet your points by predicting next matches results!

                        </p>

                    </div>

                </div>

                <div class="about-card-container">

                    <span class="material-symbols-outlined">monetization_on</span>

                    <div class="about-card-description-container">

                        <p class="about-description-title">

                            Make bets

                        </p>

                        <p class="about-description-container">

                            Take advantage of your sports knowledge and put those points to work as much as you want in
                            any upcoming event and if your guess was right you will get 50% of your gambled points.

                        </p>

                    </div>

                </div>

                <div class="about-card-container">

                    <span class="material-symbols-outlined">chat_bubble</span>

                    <div class="about-card-description-container">

                        <p class="about-description-title">

                            Make posts

                        </p>

                        <p class="about-description-container">

                            Take action in your community and express your thoughts and opinions about the events
                            through our post system enabling you to interact with other users you can like and even
                            comment your own opinion in any post you encounter.

                        </p>

                    </div>

                </div>

                <div class="about-card-container">

                    <span class="material-symbols-outlined">workspace_premium</span>

                    <div class="about-card-description-container">

                        <p class="about-description-title">

                            Win prizes

                        </p>

                        <p class="about-description-container">

                            Win amazing prizes, What about some tickets to the next great game? or maybe a full meet and
                            greet experience with your favorite athlete? if you work hard enough you may get it,
                            periodically top score players are rewarded by the admin team with these kind of prizes that
                            may include tickets to games, full on trips, meetings and discounts!

                        </p>

                    </div>

                </div>

            </div>

        </div> --}}

        <div class="subscription-section">

            <h2 class="sub-head">Ready to level up to Livescore Premium?</h2>

            <div class="subscription-group-container">

                <div class="subscription-container">

                    <div class="subscription-info">

                        <p class="sub-type">Basic</p>
                        <p class="sub-price">Free</p>
                        <p class="sub-desc">Although limited, you can access to a great experience in our site</p>

                    </div>

                    <div class="subscription-data">

                        <ul>

                            <li><span class="material-symbols-outlined">check_circle</span>
                                Follow teams, events and leagues</li>
                            <li><span class="material-symbols-outlined">cancel</span>
                                Remove Ads</li>

                        </ul>

                    </div>

                    <a href="/" class="sub-btn">Choose Plan</a>

                </div>

                <div class="subscription-container">

                    <div class="subscription-info">

                        <p class="sub-type">Premium</p>
                        <p class="sub-price">$5 <span>/month</span></p>
                        <p class="sub-desc">Our subscription based plan. Get rid of the ads and enhance your experience
                        </p>

                    </div>

                    <div class="subscription-data">

                        <ul>

                            <li><span class="material-symbols-outlined">check_circle</span>
                                Follow teams, events and leagues</li>
                            <li><span class="material-symbols-outlined">check_circle</span>
                                Remove Ads</li>

                        </ul>

                    </div>

                    <a href="/" class="sub-btn">Choose Plan</a>

                </div>

                <div class="subscription-container">

                    <div class="subscription-info">

                        <p class="sub-type">Enterprise</p>
                        <p class="sub-price">$50 <span>/year</span></p>
                        <p class="sub-desc">Save up to 2 months of payments and get all the benefits from the premium plan
                        </p>

                    </div>

                    <div class="subscription-data">

                        <ul>

                            <li><span class="material-symbols-outlined">check_circle</span>
                                Follow teams, events and leagues</li>
                            <li><span class="material-symbols-outlined">check_circle</span>
                                Remove Ads</li>

                        </ul>

                    </div>

                    <a href="/" class="sub-btn-default">Choose Plan</a>

                </div>

            </div>

        </div>

    </main>


    <footer>

        <img src="https://github.com/metaberrystudios/Proyecto-ESI-BUCEO-2022-MetaBerryStudios/blob/main/Dise%C3%B1o/Produccion/assets/img/logo/Recurso%2022white.png?raw=true">

    </footer>


</body>

</html>