@extends('layouts.app')

@section('content')
<div class="card">
    @forelse ($books as $book)
        <x-book type="list-item" :book="$book"></x-book>

    @empty
        <div class="empty-collection p-3 text-muted">
            There's no books availlable
        </div>
    @endforelse

    {{ $books->links() }}
</div>
@endsection
