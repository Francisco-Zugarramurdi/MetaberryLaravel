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

            <div class="user-table-container">

                <table class="user-table">

                    <thead>
                        <tr>

                            <th>ID</th>
                            <th> </th>
                            <th>Email</th>
                            <th>Type User</th>
                            <th>Actions</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach($subscription as $subs)

                            <tr>
                                    <form class="entry" method="POST" action="/user/subscription/{{$subs->id}}" enctype="multipart/form-data">
                                        @method('PUT')
                                        @csrf
                                        {{method_field('PUT')}}
                                        <input name="_method" type="hidden" value="PUT">

                                        <td class="user-id">

                                            <p>{{$user->id}}</p>

                                        </td>

                                        <td class="user-id">

                                            <p>{{$user->id}}</p>

                                        </td>
    
                                        <td class="user-email">
                                            <label>
                                                <input name="email" type="text" value="{{$user->email}}">
                                            </label>
                                        </td>
    
                                        <td class="user-type">
                                            <label>
                                                @if($user->type_of_user == 'paid_monthly')
                                                <select name="type_of_user">
                                                    <option value="paid_monthly">Monhtly</option>
                                                    <option value="paid_yearly" selected>Yearly</option>
                                                </select>
                                                @else if ($user-> type_of_user == 'paid_yearly')
                                                <select name="type_of_user">
                                                    <option value="paid_yearly" selected>Yearly</option>
                                                    <option value="paid_monthly">Monthly</option>
                                                </select>
                                                @endif
                                            </label>
                                        </td>
    
                                        <td class="actions-buttons">
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
        document.getElementById('usersubscription').classList.add("focus");
    </script>
    <script src="{{ asset('js/UserForm.js') }}"></script>
    <script src="{{ asset('js/DropdownAnimation.js') }}"></script>
</body>
</html>