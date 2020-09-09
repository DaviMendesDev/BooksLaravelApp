@extends('layouts.app')

@section('content')
    <div class="container rounded">
        <x-book type="show" :book="$book"></x-book>
    </div>
@endsection
