@extends('layouts.app')

@section('content')
    <h1>My Sent Invitations</h1>
    @table($table)
    <h1>Received Invitations</h1>
    @table($tableB)
@endsection
