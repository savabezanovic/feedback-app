@extends('layouts.master')

@section('content')
    <div class="login">
        <span class="login-text">Log in to provide a feedback</span>
        <form action="{{route('login')}}" method="POST">
            @csrf
            <br><br><br>
            <label class="hidden js-mail" for="email">Email</label>
            <input class="e-mail js-e-mail" type="email" name="email" placeholder="email" required>
            <br><br><br>
            <label class="hidden js-pass" for="password">Password</label>
            <input class="password js-password" type="password" name="password" placeholder="password" required><br>
            <input type="submit" class="login-btn js-test" value="LOG IN">
        </form>
    </div>
@endsection