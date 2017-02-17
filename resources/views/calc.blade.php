@extends('layouts.app')

@section('content')

<form method="post" action="{{ url('/calc') }}">
    x = <input type="number" name="num1"><br>
    y = <input type="number" name="num2"><br>
    y = <input type="text" pattern="[+-/*]" name="sign"><br>
    <input type="submit" value="Send">
    @if (isset($result))
        <p>Result = {{$result}}
    @endif
</form>