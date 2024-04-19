@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <h4 class="">{{ __('share.users') }}</h4>
        </div>
        <div class="col-md-8 text-right">
            @can('users.create')
            <x-datatable.create href="{{ route('users.create') }}" module="{{ __('modules/account/user.user') }}"/>
            @endcan
        </div>
    </div>

    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="card-body">
            <div class="card-datatable table-responsive pt-0">
                <table id="dt" class="datatables-basic1 table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>{{ __('modules/account/user.name') }}</th>
                        <th>{{ __('modules/account/user.email') }}</th>
                        <th>{{ __('modules/account/user.phone') }}</th>
                        <th>{{ __('modules/account/user.role') }}</th>
                        <th>{{ __('share.created_at') }}</th>
                        @canany(['users.edit','users.delete'])
                            <th><span><i class="fa fa-cog"></i></span></th>
                        @endcanany
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->
@endsection

@push('js')
    <script>
        $(function() {
            $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                order: [[ 0, "desc" ]],
                ajax: '{!! route('users.list') !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false,},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    {data: 'role',name: 'role',orderable: false,searchable: false},
                    { data: 'created_at', name: 'created_at' },
                    @canany(['users.edit','users.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                        @canany(['users.edit','users.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("users.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("users.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('users.edit')
                                        <a class="text-success" href="${editUrl}"><i class="fas fa-pencil-alt mr-1"></i></a>
                                       @endcan
                                        @can('users.delete')
                                        <a class="confirm-delete text-danger" data-url="${deleteUrl}"><i class="far fa-trash-alt mr-1"></i></a>
                                       @endcan
                                   </div>`;
                        }
                    }
                    @endcanany
                ]
            });
        });
    </script>
@endpush
