@extends('layouts.app')

@section('content')
    <h2>Edit User</h2>
        <br />
         <hr />
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/update/{{ $user['id'] }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user['name'] }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="{{ $user['password'] }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user['email'] }}" required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        <div class="mb-3">
            <label for="mobile" class="form-label">Mobile</label>
            <input type="tel" class="form-control" id="mobile" name="mobile" value="{{ $user['mobile'] }}" required>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" value="{{ $user['date'] }}" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select name="role" class="form-control" id="role" required>
                <option value="">Select Role</option>
                <option value="Admin" {{ $user['role'] === 'Admin' ? 'selected' : '' }}>Admin</option>
                <option value="User" {{ $user['role'] === 'User' ? 'selected' : '' }}>User</option>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
@endsection
