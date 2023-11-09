@extends('layouts.app')

@section('content')
    <h2>Users</h2>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Date</th>
                <th>Role</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user['id'] }}</td>
                    <td>{{ $user['name'] }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['mobile'] }}</td>
                    <td>{{ $user['date'] }}</td>
                    <td>{{ $user['role'] }}</td>
                    <td>
                        @if(isset($user['image']))
                            <img src="{{ asset($user['image']) }}" alt="User Image" style="max-width: 100px;">
                        @elsemt-3
                            No Image
                        @endif
                    </td>

                    <td>
                        <a href="/edit/{{ $user['id'] }}" class="btn btn-sm btn-primary">Edit</a>
                        <a href="/delete/{{ $user['id'] }}" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="/add" class="btn btn-success">Add User</a> 
    <!-- <a href="/final-submit" class="btn btn-warning">Final Submit</a> -->
    @php
    $userData = Session::get('userData', []);
    @endphp
    @if(count($userData) > 0)
    <a href="/final-submit" class="btn btn-warning">Final Submit</a>
    @endif

@endsection
