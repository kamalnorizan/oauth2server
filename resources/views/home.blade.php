@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Access To Sub System</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach (Auth::user()->usersubsystems as $usersubsystem)
                        <a class="btn btn-info" href="{{ route('sub-systems.ssologin',['subsystem'=>$usersubsystem->subsystem->id]) }}">
                            <i class="fa fa-barcode fa-5x" aria-hidden="true"></i> <br> {{ $usersubsystem->subsystem->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
