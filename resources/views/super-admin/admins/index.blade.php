@extends('layouts.master')

@section('users')

    <div class="user-box">
        <div class="user">
            <img src="https://source.unsplash.com/random" class="user-image">
            <div class="user-status">
                <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <a class="user-name" href="{{route('user.profile', auth()->user()->id)}}">{{auth()->user()->first_name}} {{auth()->user()->last_name}}</a>
                    <span><button type="submit" class="logout-btn">Log out</button></span>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('content')

    <br>

    @forelse($admins as $admin)

        <a href="{{route('superadmin.admin', $admin->id)}}">{{$admin->first_name}} {{$admin->last_name}}</a> -  add, delete, update<br>

    @empty

        <p>No admins.</p>

    @endforelse

@endsection
