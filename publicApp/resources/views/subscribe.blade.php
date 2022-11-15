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
        <link rel="stylesheet" href="{{ asset('assets/css/subscription.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Livescore - Upgrade Account</title>
</head>

<body>
    
    <main>

        <div class="subscription-container">

            <div class="header">

                <h1>Wanna upgrade your experience in Livescore?</h1>
                <p>Pay your subscription with your Visa Card</p>

            </div>

            <div class="subscription-card-container">

                    <div class="card-container">

                        <div class="inner-container">
                            <p class="type-subscription">Premium</p>
                            <p class="price">$5 <span>/month</span></p>
                        </div>
    
                        <div class="data-container">
                            Our subscription based plan. 
                            Get rid of the ads and enhance your experience
                        </div>
    
                    </div>
    
                    <div class="card-container">

                        <div class="inner-container">
                            <p class="type-subscription">Enterprise</p>
                            <p class="price">$50 <span>/year</span></p>
                        </div>
                            
                        <div class="data-container">
                            Save up to 2 months of payments and get all
                            the benefits from premium plan
                        </div>
    
                    </div>
    
            </div>

            <hr class="line">

            <div class="subscription-form-container">

                <form method="POST" action="/user/subscribe">
                    @method('POST')
                    @csrf

                    <p>Pay with card</p>

                    <div class="inner-container">

                        <label>
                            Monthly subscription
                            <input type="radio" name="subscription-type" value="paid_monthly">
                        </label>
    
                        <label>
                            Anual subscription
                            <input type="radio" name="subscription-type" value="paid_yearly">
                        </label>

                        <label>
                            Credit Card
                            <input type="number" min="1">
                        </label>

                    </div>

                </form>

            </div>

        </div>

    </main>
    
</body>
</html>