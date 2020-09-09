@extends('layouts.app')

@section('content')
    <div class="container-fluid rounded py-3">
        <form action="{{ route('new-book') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <x-book type="create"></x-book>
        </form>
    </div>
@endsection
