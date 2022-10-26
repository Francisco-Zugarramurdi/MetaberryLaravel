<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Sport</title>
</head>
<body>
    <main>

        @include('navbar')


        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>Sport Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create sport 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create sport</h2>
    
                        <form action="/sport/create" class="create-user-form" method="POST" id="creationForm">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="John" id="name">
                                    </label>
    
                                </div>

                                <div class="form-inner-container">

                                    <label>
                                        <p><span>* </span>Icon</p>
                                    </label>

                                    <div class="tag-container">

                                        <label>
                                            <p>Football</p>
                                            <input type="radio" name="icon"value="sports_soccer">
                                        </label>
                                        <label>
                                            <p>Hiking</p>
                                            <input type="radio" name="icon" value="hiking">
                                        </label>
                                        <label>
                                            <p>Pool Sport</p>
                                            <input type="radio" name="icon" value="pool">
                                        </label>
                                        <label>
                                            <p>Racing Sport</p>
                                            <input type="radio" name="icon" value="sports_score">
                                        </label>
                                        <label>
                                            <p>Basketball</p>
                                            <input type="radio" name="icon" value="sports_basketball">
                                        </label>
                                        <label>
                                            <p>Sailing</p>
                                            <input type="radio" name="icon" value="sailing">
                                        </label>
                                        <label>
                                            <p>Tennis</p>
                                            <input type="radio" name="icon" value="sports_tennis">
                                        </label>
                                        <label>
                                            <p>Gymnastics</p>
                                            <input type="radio" name="icon" value="sports_gymnastics">
                                        </label>
                                        <label>
                                            <p>Motorsports</p>
                                            <input type="radio" name="icon" value="sports_motorsports">
                                        </label>
                                        <label>
                                            <p>Surfing</p>
                                            <input type="radio" name="icon" value="surfing">
                                        </label>
                                        <label>
                                            <p>Golf</p>
                                            <input type="radio" name="icon" value="golf_course">
                                        </label>
                                        <label>
                                            <p>Volleyball</p>
                                            <input type="radio" name="icon" value="sports_volleyball">
                                        </label>
                                        <label>
                                            <p>Martial Arts</p>
                                            <input type="radio" name="icon" value="sports_martial_arts">
                                        </label>
                                        <label>
                                            <p>Baseball</p>
                                            <input type="radio" name="icon" value="sports_baseball">
                                        </label>
                                        <label>
                                            <p>Downhill Skiing</p>
                                            <input type="radio" name="icon" value="downhill_skiing">
                                        </label>
                                        <label>
                                            <p>Kayaking</p>
                                            <input type="radio" name="icon" value="kayaking">
                                        </label>
                                        <label>
                                            <p>Handball</p>
                                            <input type="radio" name="icon" value="sports_handball">
                                        </label>
                                        <label>
                                            <p>American Football</p>
                                            <input type="radio" name="icon" value="sports_football">
                                        </label>
                                        <label>
                                            <p>Skateboarding</p>
                                            <input type="radio" name="icon" value="skateboarding">
                                        </label>
                                        <label>
                                            <p>Cricket</p>
                                            <input type="radio" name="icon" value="sports_criket">
                                        </label>
                                        <label>
                                            <p>Roller Skating</p>
                                            <input type="radio" name="icon" value="roller_skating">
                                        </label>
                                        <label>
                                            <p>MMA Sports</p>
                                            <input type="radio" name="icon" value="sports_mma">
                                        </label>
                                        <label>
                                            <p>Rugby</p>
                                            <input type="radio" name="icon" value="sports_rugby">
                                        </label>
                                        <label>
                                            <p>Paragliding</p>
                                            <input type="radio" name="icon" value="paragliding">
                                        </label>
                                        <label>
                                            <p>Hockey</p>
                                            <input type="radio" name="icon" value="sports_hockey">
                                        </label>
                                        <label>
                                            <p>Sledding</p>
                                            <input type="radio" name="icon" value="sledding">
                                        </label>
                                        <label>
                                            <p>Snowmobile</p>
                                            <input type="radio" name="icon" value="snowmobile">
                                        </label>
                                        <label>
                                            <p>Other</p>
                                            <input type="radio" name="icon" value="sports_score">
                                        </label>

                                        </div>

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
                            <th>Name</th>
                            <th>Icon</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($sports as $sport)
                            <tr>
                                    <form class="entry" method="POST" action="/sport/{{$sport->id}}">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$sport->id}}</p>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$sport->name}}">
                                            </label>
                                        </td>

                                        <td class="user-image">
                                            <label>
                                            <span class="material-symbols-outlined">{{$sport->icon}}</span>
                                            </label>
                                        </td>
    
                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$sport->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/sport/{{$sport->id}}"method="POST" class="delete" id="delete_form_{{$sport->id}}">
                                    @method('DELETE')
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <input name="_method" type="hidden" value="DELETE">
                                </form>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

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
        document.getElementById('sport').classList.add("focus");
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>