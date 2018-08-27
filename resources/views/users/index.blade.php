@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @forelse ($users as $user)
                    @include('_user', ['user' => $user])
                @empty
                    <p>No users</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection