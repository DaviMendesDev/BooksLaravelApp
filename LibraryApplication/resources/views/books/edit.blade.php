@extends('layouts.app')

@section('content')
<div class="container-fluid rounded p-3">
    <form action="{{ route('edit-book', ['book' => $book]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <x-book type="edit" :book="$book"></x-book>
    </form>
</div>
@endsection
