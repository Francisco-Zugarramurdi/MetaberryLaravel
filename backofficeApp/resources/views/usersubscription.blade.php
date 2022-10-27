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

                <h1>User Subscription Management</h1>

            </div>

            <div class="user-table-container enable event subscription">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th>User ID</th>
                            <th>Profile Image</th>
                            <th>Email</th>
                            <th>Type User</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($subscriptions as $subs)

                            <tr>
                                    <form class="entry" method="POST" action="/user/subscription/{{$subs->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$subs->id}}</p>

                                        </td>

                                        <td class="user-id">

                                            <p>{{$subs->userID}}</p>

                                        </td>

                                        
                                        <td class="user-profile-pic">

                                            <div class="image-container">
                                                <img src="{{ asset('img/public_images').'/'.$subs->photo }}" alt="">
                                            </div>

                                        </td>

    
                                        <td class="user-email">
                                            <label>
                                                <input name="email" type="text" value="{{$subs->email}}">
                                            </label>
                                        </td>
    
                                        <td class="user-type">
                                            <label>
                                                
                                                <select name="type_of_user">
                                                    <option value="paid_monthly" @if($subs->type_of_user == 'paid_monthly') selected @endif>Monhtly</option>
                                                    <option value="paid_yearly" @if($subs-> type_of_user == 'paid_yearly') selected @endif>Yearly</option>
                                                </select>
                                            </label>
                                        </td>
    
                                        <td class="actions-buttons">
                                            <button type="submit" class="submit-btn">
                                                <span class="material-symbols-outlined">send</span>
                                            </button>

                                            <button type="button" class="delete-btn" onClick="deleteFormSubmit({{$subs->id}})">
                                                <span class="material-symbols-outlined">delete</span>
                                            </button>

                                        </td>
                                    </form>

                                <form action="/user/subscription/{{$subs->id}}" method="POST" class="delete" id="delete_form_{{$subs->id}}">
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
        document.getElementById('usersubscription').classList.add("focus");
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>