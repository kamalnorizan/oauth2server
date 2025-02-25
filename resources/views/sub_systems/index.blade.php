@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Sub Systems</h1>
            <div class="card">
                <div class="card-header">
                    Sub System
                    <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#createSubSystem">
                        Add SubSystem
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
                                Description
                            </td>
                            <td>
                                Scopes
                            </td>
                            <td>
                                Actions
                            </td>
                        </tr>
                        @forelse ($subSystems as $subSystem)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                {{ $subSystem->name }}
                            </td>
                            <td>
                                {{ $subSystem->description }}
                            </td>
                            <td>
                                @foreach ($subSystem->scopes as $scope)
                                <span class="badge badge-primary">{{$scope->scope}}</span>
                                @endforeach
                                {{-- {{ $subSystem->scopes }} --}}
                            </td>
                            <td>

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

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="createSubSystem" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create SubSystem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body">
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="name">Subsystem Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"  class="form-control" required="required">
                    <small class="text-danger">{{ $errors->first('name') }}</small>
                </div>
                <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" required="required"></textarea>
                    <small class="text-danger">{{ $errors->first('description') }}</small>
                </div>
                @foreach ($scopes as $scope)
                <div class="form-group">
                    <div class="form-check {{ $errors->has('scope') ? ' has-error' : '' }}">
                        <input class="form-check-input scope" type="checkbox" id="scope" name="scope" value="{{$scope->id}}">
                        <label class="form-check-label" for="scope">{{$scope->description}}</label>
                    </div>
                    <small class="text-danger">{{ $errors->first('scope') }}</small>
                </div>
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="saveBtn" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#saveBtn').click(function (e) {
        e.preventDefault();
        var scope = [];
        $('.scope:checked').each(function () {
            scope.push($(this).val());
        });

        $.ajax({
            type: "post",
            url: "{{ route('sub-systems.store') }}",
            data: {
                _token: '{{ csrf_token() }}',
                name: $('#name').val(),
                description: $('#description').val(),
                scope: scope
            },
            dataType: "json",
            success: function (response) {
                window.location.reload();
            },
            error: function (response) {
                var errors = response.responseJSON.errors;
                jquery.each(errors, function (key, value) {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key).after('<small class="text-danger">' + value + '</small>');
                });
            }
        });
    });
</script>
@endsection
