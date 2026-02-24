@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-white">
                <h4>Inscription</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nom</label>
                        <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror" value="{{ old('nom') }}">
                        @error('nom') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control @error('mot_de_passe') is-invalid @enderror">
                        @error('Password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label>Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
                <p class="mt-3 text-center">Déjà inscrit ? <a href="{{ route('auth.login') }}">Se connecter</a></p>
            </div>
        </div>
    </div>
</div>
@endsection