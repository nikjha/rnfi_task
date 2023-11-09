<!-- resources/views/slots/index.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Slots</h1>
    <hr />
    <div class="row">
    @foreach ($slots as $slot)
        <div class="col-3">
            <h3>Slot {{ $slot->id }}</h3>
            <form action="/slots/update/{{ $slot->id }}" method="post">
                @csrf
                @foreach ($slot->toArray() as $key => $value)
                    @if (strpos($key, 'slot') !== false)
                        <div class="mb-3">
                            <label for="{{ $key }}">{{ $key }}</label>
                            <input type="number" class="form-control" id="{{ $key }}" name="{{ $key }}" value="{{ $value }}">
                        </div>
                    @endif
                @endforeach
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    @endforeach
</div>
<br />
    <form action="/slots/add" method="post">
        @csrf
        <button type="submit" class="btn btn-success">Add Slot</button>
    </form>
</div>
@endsection
