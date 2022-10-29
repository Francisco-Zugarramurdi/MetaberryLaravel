@extends('layouts.app')

@section('content')
<div class="login-container">

    <div class="form-login-container">
        <div class="header-container">
            <h1>Backoffice</h1>
            <p>Please log in</p>
        </div>
        <div class="form-container">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-up-container">
                    
                    <label>
                        Rol
                        <input id="type" type="text" name="type" value="{{ old('type') }}" autofocus>
                    </label>

                    <label>
                        Password
                        <input id="password" type="password" name="password" required>
                    </label>

                </div>
                <div class="form-down-container">
                    <button type="submit">Login</button>
                </div>
                
            </form>
        </div>
    </div>
</div>
@endsection
