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

        @if(session()->has('user_sub'))
        <div class="subscription-container">

            <div class="header">

                <h1>Want to cancel your subscription?</h1>
                <p>Upgrade to Enterprise, or cancel your subscription now</p>

            </div>

            <div class="subscription-card-container">

                <form method="POST" action="/user/subscription/delete">
                    @method('POST')
                    @csrf

                    <div class="card-container cancel">

                        <div class="inner-container">
                            <p class="type-subscription">Basic</p>
                            <p class="price">$0 <span>/month</span></p>
                        </div>
    
                        <div class="data-container">
                            Our free plan
                            Although limited, you can access to a great experience in our site
                        </div>
    
                        <button type="submit" class="type-button">Cancel your subscription</button>

                    </div>

                    @if(session('user_sub') == 'paid_yearly')

                        <div class="card-container">

                            <div class="inner-container">
                                <p class="type-subscription">Premium</p>
                                <p class="price">$5 <span>/month</span></p>
                            </div>
        
                            <div class="data-container">
                                Our subscription based plan. 
                                Get rid of the ads and enhance your experience
                            </div>
        
                            <button type="button" class="type-button" onClick="setType('paid_monhtly')">Downgrade to Premium</button>

                        </div>

                    @else
                    
                        <div class="card-container">

                            <div class="inner-container">
                                <p class="type-subscription">Enterprise</p>
                                <p class="price">$50 <span>/year</span></p>
                            </div>
                                
                            <div class="data-container">
                                Save up to 2 months of payments and get all
                                the benefits from premium plan
                            </div>
        
                            <button type="button" class="type-button" onClick="setType('paid_yearly')">Upgrade to Enterprise</button>

                        </div>

                    @endif
    

                </form>

                <form action="/user/subscription/update" method="POST" id="updateSubscription">
                    @csrf
                    <input type="hidden" id="typeSubscription" name="type_of_user" value="">

                </form>

    
            </div>


        </div>
        @else
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
    
                        <button type="button" class="type-button" onClick="setType('paid_monthly')">Choose this plan</button>

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
    
                        <button type="button" class="type-button" onClick="setType('paid_yearly')">Choose this plan</button>

                    </div>
    
            </div>

            <hr class="line">

            <div class="subscription-form-container">

                <form method="POST" action="/user/subscription" id="subscriptionForm">
                    @method('POST')
                    @csrf

                    <p class="info">Subscription information</p>

                    <div class="inner-container">

                        <label>
                            Credit Card
                            <input id="card" type="number" min="1" placeholder="4123 1234 1234 1234" name="credit_card" required>
                        </label>

                        <input type="hidden" id="typeSubscription" name="type_of_user" value="">

                        @if(isset($error))
                            @foreach($body as $error)
                                <p class="error" id="validator">{{$error[0]}}</p>
                            @endforeach
                        @endif
                        <div class="error" id="error"></div>

                        <button type="button" onClick="submitForm()">Suscribe</button>
                    
                    </div>

                </form>

            </div>

        </div>
        @endif

    </main>
    
    <script>

        function setType(type){

            document.getElementById('typeSubscription').value = type;

        }

        function submitForm(){

            $type = document.getElementById('typeSubscription').value;
            $card = document.getElementById('card');
            $error = document.getElementById('error');
            $validator_error = document.getElementById('validator');

            $error.innerHTML = ""
            $validator_error = ""

            if(!$type){


                $error.innerHTML += "<p>Please choose a subscription plan</p>";

            }
            
            if($card.value == ''){

                $error.innerHTML += "<p>The credit card field is required</p>";
                
            } else if($type){

                document.getElementById('subscriptionForm').submit();

            }


        }

    </script>

</body>
</html>