<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <title>Users</title>
</head>
<body>
    <main>

        @include('navbar')


        <div class="main-page-container">

            <div class="nav-bar-container">

                <h1>User Management</h1>

            </div>

            <div class="create-user-container">

                <button type="button" class="dropdown-button" id="dropdown_button" onClick="dropdown()">Create user 
                    <span class="hidden material-symbols-outlined" id="show_icon">expand_more</span>
                    <span class="material-symbols-outlined" id="hide_icon">expand_less</span>
                </button>

                <div class="unhide-container hide" id="create_user_container">

                        <h2>Create user</h2>
    
                        <form action="/user/create" class="create-user-form" method="POST" id="creationForm" enctype="multipart/form-data">
                            @method('POST')
                            @csrf
                            
                            <div class="form-up-container">
    
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Name</p>
                                        <input type="text" name="name" placeholder="John" id="name">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Email</p>
                                        <input type="text" name="email" placeholder="jonhdoe@gmail.com" id="email">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Password</p>
                                        <input type="password" name="password"id="password">
                                    </label>
    
                                    <label>
                                        <p>Profile image</p>
                                        <input type="file" name="image" accept="image/*" id="photo">
                                    </label>
    
                                </div>
                                <div class="form-inner-container">
    
                                    <label>
                                        <p><span>* </span>Subscription</p>
                                        <select name="type_of_user" id="type_of_user">
                                            <option value="free">Free</option>
                                            <option value="paid_monthly">Monthly</option>
                                            <option value="paid_yearly">Yearly</option>
                                        </select>
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Points</p>
                                        <input type="number" name="points" value="" placeholder="300" id="points">
                                    </label>
    
                                    <label>
                                        <p><span>* </span>Total points</p>
                                        <input type="number" name="total_points" value="" placeholder="300" id="totalPoints">
                                    </label>
    
                                    <label>
                                        <p>Credit card</p>
                                        <input type="number" name="credit_card" value="" placeholder="4123412341234123" id="card">
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
                            <th>Email</th>
                            <th>Profile Image</th>
                            <th>Type User</th>
                            <th>Points</th>
                            <th>Total Points</th>
                            <th>Credit Card</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)

                            <tr>
                                    <form class="entry" method="POST" action="/user/{{$user->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$user->id}}</p>

                                        </td>

                                        <td class="user-profile-pic">

                                            <div class="image-container">
                                                <img src="{{ asset('img/public_images').'/'.$user->photo }}" alt="">
                                            </div>

                                        </td>

                                        <td class="user-name">
                                            <label>
                                                <input name="name" type="text" value="{{$user->name}}">
                                            </label>
                                        </td>
    
                                        <td class="user-email">
                                            <label>
                                                <input name="email" type="text" value="{{$user->email}}">
                                            </label>
                                        </td>
                                        
                                        <td class="user-image">
                                            <label>
                                                <input type="file" name="image" accept="image/*" id="photo">
                                            </label>
                                        </td>
    
                                        <td class="user-type">
                                            <label>
                                                <select name="type_of_user">
                                                    <option value="free" @if($user->type_of_user == 'free') selected @endif>Free</option>
                                                    <option value="paid_monthly" @if($user->type_of_user == 'paid_monthly') selected @endif>Monthly</option>
                                                    <option value="paid_yearly" @if($user->type_of_user == 'paid_yearly') selected @endif>Yearly</option>
                                                </select>
                                            </label>
                                        </td>
    
                                        <td class="user-points">
                                            <label>
                                                <input type="number"name="points" value="{{$user->points}}">
                                            </label>
                                        </td>
    
                                        <td class="user-total-points">
                                            <label>
                                                <input type="number" name="total_points" value="{{$user->total_points}}">
                                            </label>
                                        </td>
    
                                        <td class="user-card">
                                            <label>
                                                <input type="number"name="credit_card" value="{{$user->credit_card}}">
                                            </label>
                                        </td>
    
                                        <td class="actions-buttons">
                                            <!-- <button type="button" class="edit-input-btn" onClick="editFormInput()"></button> -->
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>
                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$user->id}})">
                                            <span class="material-symbols-outlined">delete</span>
                                            </button>
                                        </td>
                                    </form>

                                <form action="/user/{{$user->id}}"method="POST" class="delete" id="delete_form_{{$user->id}}">
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
        document.getElementById('user').classList.add("focus");
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>