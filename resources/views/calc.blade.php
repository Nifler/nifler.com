@extends('layouts.app')

@section('content')

<form method="post" action="{{ url('/calc') }}">
    x = <input type="number" name="x"><br>
    y = <input type="number" name="y"><br>
    <input type="submit" value="Send">
    @if (isset($result))
        <p>Result = {{$result}}
    @endif
</form>