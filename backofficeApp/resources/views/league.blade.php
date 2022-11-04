<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>League</title>
</head>
<body>
    <main>

        @include('navbar')

        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>League Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create league 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create league</h2>
    
                        <form action="/league/create" class="create-user-form" method="POST" id="creationForm" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="Manshield Acuatic League" id="name">
                                    </label>

                                    <label>
                                        <p><span>* </span>Details</p>
                                        <input name="details" id="details" placeholder="The Manshield Acuatic League, since 1972">
                                    </label>

                                    <label>
                                        <p>League image</p>
                                        <input type="file" name="image" accept="image/*" id="imageInput" class="input-image">
                                        <label for="imageInput" class="label-image">
                                            <span class="material-symbols-outlined">upload</span>
                                            <p>Upload an image...</p>
                                        </label>
                                    </label>

                                    <label>
                                        <p><span>* </span>Country</p>
                                        <select name="countryName" id="countryName">
                                            @foreach ($countries as $country)
                                            <option value="{{$country->id}}" name="{{$country->name}}">{{$country->name}}</option>
                                            @endforeach
                                        </select>
                                    </label>
    
                                </div>
    
                            </div>
    
                            <div class="form-down-container">
    
                                <input type="submit" value="Create" class="create-btn" id="submit">
            
                                <div id="error" class="error"></div>
    
                            </div>
    
                        </form>
                    
                </div>

            </div>

            <div class="user-table-container">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th> </th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Details</th>
                            <th>Country</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($leagues as $league)
                            <tr>
                                    <form class="entry" method="POST" action="/league/{{$league->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$league->id}}</p>

                                        </td>

                                        <td class="user-profile-pic">

                                            <div class="image-container">
                                                <img src="{{ asset('img/public_images').'/'.$league->photo }}" alt="">
                                            </div>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$league->name}}">
                                            </label>
                                        </td>

                                        <td class="user-image">
                                            <label class="custom-selector">
                                                <input type="file" name="image" accept="image/*" id="{{$league->id}}" class="input-image">
                                                <label for="{{$league->id}}" class="label-image">
                                                    <span class="material-symbols-outlined">upload</span>
                                                    <p>Change image...</p>
                                                </label>
                                            </label>
                                        </td>
                                        
                                        <td class="user-image">
                                            <label>
                                                <input name="details" type="text" value="{{$league->details}}">
                                            </label>
                                        </td>

                                        <td class="user-type">
                                            <label>
                                                <select name="countryName" id="countryName">
                                                @foreach ($countries as $country)
                                                <option value="{{$country->id}}" name="{{$country->name}}" @if($country->name == $league->countryName) selected @endif >{{$country->name}}</option>
                                                @endforeach
                                                </select>
                                            </label>
                                        </td>
                                        
    
                                        <td class="actions-buttons">
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$league->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/league/{{$league->id}}"method="POST" class="delete" id="delete_form_{{$league->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                {{$leagues->links()}}
            </div>

        </div>

    </main>

    <script>


        const deleteFormSubmit = (id) =>{

            event.preventDefault();
            document.getElementById('delete_form_'+id).submit();

        }
        
    </script>
    <script>
        document.getElementById('league').classList.add("focus");
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>