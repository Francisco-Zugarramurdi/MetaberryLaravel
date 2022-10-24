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
    <title>Events List</title>
</head>
<body>
    <main>

        @include('navbar')
    
        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Events List</h1>

            </div>
            
            <div class="user-table-container enable event">
                    
                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th>Relevance</th>
                            <th>Date</th>
                            <th>Country</th>
                            <th>Sport</th>
                            <th>League</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                <tbody>
                    
                    @foreach($events as $event)
                        <tr>
                                <form class="entry" method="GET" action="/event/edit/{{$event->id}}">
                                    @method('GET')
                                    @csrf
                                    {{method_field('GET')}}
                                    <input name="_method" type="hidden" value="PUT">

                                    <td class="user-id">

                                        <p>{{$event->id}}</p>

                                    </td>

                                    <td class="table-content">
                                        <label>
                                            <p>{{$event->name}}</p>
                                        </label>
                                    </td>
                                    
                                    <td class="table-content">
                                        <label>
                                            <p>{{$event->details}}</p>
                                        </label>
                                    </td>
                                    <td class="table-content">
                                        <label>
                                            <p>{{$event->relevance}}</p>
                                        </label>
                                    </td>
                                    
                                    <td class="table-content">
                                        <label>
                                            <p>{{$event->date}}</p>
                                        </label>
                                    </td>
                                    
                                    <td class="table-content">
    
                                        <label> 
                                            <p>{{$event->countryName}}</p>
                                        </label>

                                    </td>

                                    <td class="table-content">
                                        <label>
                                               <p>{{$event->sportName}}</p>
                                        </label>
                                    </td>

                                    <td class="table-content">
                                        <label>
                                                <p>{{$event->leagueName}}</p>
                                        </label>
                                    </td>

                                    <td class="actions-buttons">
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$event->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                </form>
                                <form action="/event/list/{{$event->id}}"method="POST" class="delete" id="delete_form_{{$event->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>

    </main>

    <script>
        const deleteFormSubmit = (id) =>{

            event.preventDefault();
            document.getElementById('delete_form_'+id).submit();

        }
    </script>

</body>
</html>