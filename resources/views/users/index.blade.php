@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Users</h1>
            <div class="card">
                <div class="card-header">
                    Users
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                        data-target="#createSubSystem">
                        Register User
                    </button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>
                                Bil
                            </td>
                            <td>
                                Name
                            </td>
                            <td>
                                Email
                            </td>
                            <td>
                                Sub System
                            </td>
                            <td>
                                Actions
                            </td>
                        </tr>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->name }}
                                </td>
                                <td>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="{{route('users.edit',['user'=>$user->id])}}"> <i class="fa fa-edit"></i> Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="5">
                                    No records found
                                </td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
