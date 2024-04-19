@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <h4 class="">{{ __('share.captains') }}</h4>
        </div>
        <div class="col-md-8 text-right">
            @can('captain.create')
                <x-datatable.create href="{{ route('captains.create') }}" module="{{ __('modules/account/captain.captain') }}"/>
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
                        <th>{{ __('modules/account/captain.name') }}</th>
                        <th>{{ __('modules/account/captain.email') }}</th>
                        <th>{{ __('modules/account/captain.phone') }}</th>
                        <th>{{ __('share.created_at') }}</th>
                        @canany(['captain.edit','captain.delete'])
                            <th>{{ __('share.actions') }}</th>
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
                ajax: '{!! route('captains.list') !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false,},
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'created_at', name: 'created_at' },
                        @canany(['captain.edit','captain.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                        @canany(['captain.edit','captain.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("captains.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("captains.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('captain.edit')
                            <a class="text-success" href="${editUrl}"><i class="fas fa-pencil-alt mr-1"></i></a>
                                       @endcan
                            @can('captain.delete')
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
