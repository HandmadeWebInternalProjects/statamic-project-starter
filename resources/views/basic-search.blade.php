@extends('layout')

@section('template_content')

    @if($searchResults->isNotEmpty())

        @foreach($searchResults as $item)
            {{-- {{  $item->collectionHandle() }} --}}
            {{ $item->get('title') }}
        @endforeach

    @endif

@endsection
