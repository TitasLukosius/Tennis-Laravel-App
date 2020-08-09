@extends('layouts.app')

@section('content')
    <h1>Players Profile</h1>
    <div class="current-user-information">
        <img class="prof-img" src="{{$photo}}">
        @foreach($form['fields'] as $field_id => $value)
            <h3>{{$field_id}}</h3>
            <p>{{$value['value']}}</p>
        @endforeach
        @foreach($form['buttons'] ?? [] as $button_id => $button)
            <button {!!html_attr(($button['extra']['attr'] ?? []) + ['value' => $button_id, 'name' => 'action'])!!} >
                {!!$button['text']!!}
            </button>
        @endforeach
    </div>
@endsection
