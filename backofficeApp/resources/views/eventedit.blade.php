<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <meta name="_token" content="{{csrf_token()}}" />
    <title>Edit Event</title>
</head>
<body>
    <main>
        @include('navbar')
        
        <div class="main-page-container">

            <div class="nav-bar-container">
                <h1>Events Edits</h1>
            </div>
            <div class="user-table-container enable event">
                <table class="user-table">

                    <thead>
                            <tr>

                                <th>ID</th>
                                <th>Name</th>
                                <th>Details</th>
                                <th>Relevance</th>
                                <th>Country</th>
                                <th>Sport</th>
                                <th>League</th>
                                <th>Actions</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach($events as $event)
                        <tr>
                                <form class="entry" method="POST" action="/event/edit/{{$event->id}}">
                                    @method('PUT')
                                    @csrf
                                    {{method_field('PUT')}}
                                    <input name="_method" type="hidden" value="PUT">

                                    <td class="user-id">

                                        <p>{{$event->id}}</p>

                                    </td>

                                    <td class="user-name">
                                        <label>
                                            <input name="name" type="text" value="{{$event->name}}">
                                        </label>
                                    </td>
                                    
                                    <td class="user-name">
                                        <label>
                                            <input name="details" type="text" value="{{$event->details}}">
                                        </label>
                                    </td>

                                    <td class="user-name">
                                        <label>
                                            <input name="relevance" type="number" value="{{$event->relevance}}" min="1" max="5">
                                        </label>
                                    </td>
                                    
                                    <td class="user-type">
                                        <label>
                                            <select name="country" class="country">
                                                @foreach($countries as $country)
                                                <option name="{{$event->countryName}}" @if($country->name == $event->countryName)selected @endif>{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </td>

                                    <td class="user-type">
                                        <label>
                                            <select name="sport" class="sport">
                                                @foreach($sports as $sport)
                                                <option name="{{$event->sportName}}" @if($sport->name == $event->sportName)selected @endif>{{$sport->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </td>

                                    <td class="user-type">
                                        <label>
                                            <select name="league" class="league">
                                                @foreach($leagues as $league)
                                                <option value="{{$event->leagueName}}" name="{{$event->leagueName}}" @if($league->name == $event->leagueName)selected @endif>{{$league->name}}</option>
                                                @endforeach
                                            </select>
                                        </label>
                                    </td>

                                    <td class="actions-buttons">
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                        </td>
                                </form>
                        </tr>
                            @endforeach
                        </tbody>

                </table>        

            </div>

        </div>
        
    </main>
    
</body>
</html>