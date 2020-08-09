@extends('layouts.app')

@section('content')
    <h1>My Profile</h1>

    <div class="current-user-information">
        <img class="prof-img" src="{{$photo}}">
        @foreach($table['tbody'] as $id => $value)
            <h3>{{$id}}</h3>
            <p>{{$value}}</p>
        @endforeach
    </div>
@endsection
