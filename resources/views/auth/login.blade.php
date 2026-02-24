@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-white"><h4>Connexion</h4></div>
            <div class="card-body">
                @if($errors->has('message'))
                    <div class="alert alert-danger">{{ $errors->first('message') }}</div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection