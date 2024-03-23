@extends('base')

@section('content')

<h1>Se connecter</h1>

<div class="card">
    <div class="card-body">
        <form action="{{ route('auth.login') }}" method="POST" class="vstack gap-3">
            @csrf
            <div class="form-group">
                <label for="email">Email:</label>
                  <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
                @error('email')
                    {{ $message }}
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Mot de passe:</label>
                  <input type="password" class="form-control" name="password" id="password">
                @error('passwod')
                    {{ $message }}
                @enderror
            </div>
            <button class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</div>

@endsection

