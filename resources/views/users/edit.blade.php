@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Edit User</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"  class="form-control" required="required">
                            <small class="text-danger">{{ $errors->first('name') }}</small>
                        </div>
                        <div class="form-group {{ $errors->has('identity') ? 'has-error' : '' }}">
                            <label for="identity">Identity</label>
                            <input type="text" id="identity" name="identity" value="{{ old('identity', $user->identity) }}"  class="form-control" required="required" readonly>
                            <small class="text-danger">{{ $errors->first('identity') }}</small>
                        </div>
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Email address</label>
                            <input type="email" id="email" name="email"  value="{{ old('email', $user->email) }}" class="form-control" required placeholder="eg: foo@bar.com">
                            <small class="text-danger">{{ $errors->first('email') }}</small>
                        </div>
                        <hr>
                        <h5>Sub System Access</h5>
                        <small class="text-danger">{{ $errors->first('sub_systems') }}</small>
                        <div class="row">
                            @foreach ($subsystems as $subSystem)
                                <div class="col-md-3">
                                    <div class="form-check
                                        {{ $errors->has('sub_systems') ? ' has-error' : '' }}">
                                        <input type="checkbox" name="sub_systems[]" value="{{ $subSystem->id }}"
                                            {{ in_array($subSystem->id, old('sub_systems', $user->usersubsystems->pluck('sub_system_id')->toArray())) ? 'checked' : '' }}
                                            class="form-check-input" id="sub_system_{{ $subSystem->id }}">
                                        <label class="form-check
                                            form-check-label" for="sub_system_{{ $subSystem->id }}">
                                            {{ $subSystem->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
