@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <h4 class="">{{ __('share.languages') }}</h4>
        </div>
        <div class="col-md-8 text-right">
            @can('language.create')
            <x-datatable.create href="{{ route('languages.create') }}" module="{{ __('modules/administration/language.language') }}"/>
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
                        <th>{{ __('modules/administration/language.name') }}</th>
                        <th>{{ __('share.created_at') }}</th>
                        @canany(['language.edit','language.delete'])
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
                ajax: '{!! route('languages.list') !!}',
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    { data: 'name', name: 'name' },
                    { data: 'created_at', name: 'created_at' },
                    @canany(['language.edit','language.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                    @canany(['language.edit','language.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("languages.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("languages.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('language.edit')
                                        <a class="text-success" href="${editUrl}"><i class="fas fa-pencil-alt mr-1"></i></a>
                                       @endcan
                                        @can('language.delete')
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
