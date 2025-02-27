@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Sub Systems</h1>
                <div class="card">
                    <div class="card-header">
                        Sub System
                        <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#createSubSystem">
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
                                            <span class="badge badge-primary">{{ $scope->scope }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm btn-show"
                                            data-client="{{ $subSystem->client_id }}"><i class="fa fa-eye"></i> </button>
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

    <div class="modal fade" id="showClient" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sub System</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name_show">Subsystem Name</label>
                        <input type="text" id="name_show" name="name_show" value="" class="form-control"
                            required="required">
                        <small class="text-danger">{{ $errors->first('name_show') }}</small>
                    </div>

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description_show">Description</label>
                        <textarea id="description_show" name="description_show" class="form-control" required="required"></textarea>
                        <small class="text-danger">{{ $errors->first('description_show') }}</small>
                    </div>

                    <div class="form-group">
                        <label for="client_id">Client ID</label>
                        <input type="text" id="client_id" name="client_id" readonly value="" class="form-control"
                            required="required">
                        <small class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="client_secret">Client Secret</label>
                        <input type="text" id="client_secret" readonly name="client_secret" value=""
                            class="form-control" required="required">
                        <small class="text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="redirect">Redirect</label>
                        <input type="text" id="redirect_show" name="redirect" value="" class="form-control"
                            required="required">
                        <small class="text-danger"></small>
                    </div>
                    <div class="form-group {{ $errors->has('sso_header_show') ? 'has-error' : '' }}">
                        <label for="sso_header_show">SSO Header</label>
                        <input type="text" id="sso_header_show" name="sso_header_show" value="{{ old('sso_header_show') }}"
                            class="form-control" required="required">
                        <small class="text-danger">{{ $errors->first('sso_header_show') }}</small>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Scopes</h5>
                        </div>
                        @foreach ($scopes as $scope)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check {{ $errors->has('scope') ? ' has-error' : '' }}">
                                        <input class="form-check-input scopeedit" type="checkbox"
                                            id="scope_{{ $scope->id }}" name="scope" value="{{ $scope->id }}">
                                        <label class="form-check-label" for="scope">{{ $scope->description }}</label>
                                    </div>
                                    <small class="text-danger">{{ $errors->first('scope') }}</small>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btn-update">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createSubSystem" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
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
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="form-control" required="required">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                    </div>

                    <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" required="required"></textarea>
                        <small class="text-danger">{{ $errors->first('description') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('redirect') ? 'has-error' : '' }}">
                        <label for="redirect">Redirect</label>
                        <input type="text" id="redirect" name="redirect" value="{{ old('redirect') }}"
                            class="form-control" required="required">
                        <small class="text-danger">{{ $errors->first('redirect') }}</small>
                    </div>
                    <div class="form-group {{ $errors->has('sso_header') ? 'has-error' : '' }}">
                        <label for="sso_header">SSO Header</label>
                        <input type="text" id="sso_header" name="sso_header" value="{{ old('sso_header') }}"
                            class="form-control" required="required">
                        <small class="text-danger">{{ $errors->first('sso_header') }}</small>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5>Scopes</h5>
                        </div>
                        @foreach ($scopes as $scope)
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check {{ $errors->has('scope') ? ' has-error' : '' }}">
                                        <input class="form-check-input scope" type="checkbox" id="scope"
                                            name="scope" value="{{ $scope->id }}">
                                        <label class="form-check-label" for="scope">{{ $scope->description }}</label>
                                    </div>
                                    <small class="text-danger">{{ $errors->first('scope') }}</small>
                                </div>
                            </div>
                        @endforeach

                    </div>

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
        $.ajax({
            type: "get",
            url: "/oauth/clients",
            dataType: "json",
            success: function(response) {
                console.log(response);
            }
        });

        $('.btn-show').click(function(e) {
            e.preventDefault();
            var client_id = $(this).data('client');
            var url = "{{ route('sub-systems.getPassportClient', ':id') }}";
            url = url.replace(':id', client_id);
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    var client = response.data.client;
                    var scopes = response.data.scopes;
                    var subSys = response.data;
                    $('#client_id').val(client.id);
                    $('#client_secret').val(client.secret);
                    $('#redirect_show').val(client.redirect);
                    $('#name_show').val(subSys.name);
                    $('#description_show').val(subSys.description);
                    $('#sso_header_show').val(subSys.sso_header);
                    $.each(scopes, function(indexInArray, valueOfElement) {
                        $('#scope_' + valueOfElement.scope).prop('checked', true);
                    });
                    $('#showClient').modal('show');
                }
            });
        });

        $('#btn-update').click(function(e) {
            e.preventDefault();
            var scope = [];
            $('.scopeedit:checked').each(function() {
                scope.push($(this).val());
            });
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').text('');
            var client_id = $('#client_id').val();
            var url = "{{ route('sub-systems.update', ':id') }}";
            url = url.replace(':id', client_id);
            $.ajax({
                type: "put",
                url: url,
                data: {
                    _token: '{{ csrf_token() }}',
                    name_show: $('#name_show').val(),
                    description_show: $('#description_show').val(),
                    redirect_show: $('#redirect_show').val(),
                    sso_header_show: $('#sso_header_show').val(),
                    scope: scope
                },
                dataType: "json",
                success: function(response) {
                    window.location.reload();
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(indexInArray, valueOfElement) {
                        $('#' + indexInArray).addClass('is-invalid');
                        $('#' + indexInArray).closest('.form-group').find('.text-danger').text(
                            valueOfElement);
                    });
                }
            });

        });


        $('#saveBtn').click(function(e) {
            e.preventDefault();
            var scope = [];
            $('.scope:checked').each(function() {
                scope.push($(this).val());
            });
            $('.form-control').removeClass('is-invalid');
            $('.text-danger').text('');

            $.ajax({
                type: "post",
                url: "{{ route('sub-systems.store') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    name: $('#name').val(),
                    description: $('#description').val(),
                    redirect: $('#redirect').val(),
                    scope: scope,
                    sso_header: $('#sso_header').val(),
                },
                dataType: "json",
                success: function(response) {
                    window.location.reload();
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $.each(errors, function(indexInArray, valueOfElement) {
                        $('#' + indexInArray).addClass('is-invalid');
                        $('#' + indexInArray).closest('.form-group').find('.text-danger').text(
                            valueOfElement);
                    });
                }
            });
        });
    </script>
@endsection
