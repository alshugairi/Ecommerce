@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <h4 class="">{{ __('share.products') }}</h4>
        </div>
        <div class="col-md-8 text-right">
            <x-datatable.bulk-action>
                <a class="dropdown-item bulk-action-btn" data-action="delete"
                   data-url="{{ route('products.bulk_actions') }}" href="javascript:void(0);">
                    {{ __('share.delete_all') }}
                </a>
            </x-datatable.bulk-action>
            <a class="btn btn-sm btn-dark btn-print">
                <i class="fa-solid fa-print"></i>
                <span class="d-md-inline-block d-none">
                        {{ __('share.print') }}
                    </span>
            </a>
            <x-datatable.filter>
                <x-slot name="form">
                    <div class="row">
                        <x-form.input type="text" name="name" key="filter-name" label="true" labelName="{{ __('modules/product.name') }}"/>
                        <x-form.input type="number" name="price" key="filter-price" label="true" labelName="{{ __('modules/product.price') }}"/>
                        <x-form.input type="date" name="from" key="filter-from" label="true" labelName="{{ __('share.from') }}"/>
                        <x-form.input type="date" name="to" key="filter-to" label="true" labelName="{{ __('share.to') }}"/>
                    </div>
                </x-slot>
            </x-datatable.filter>
            @can('product.create')
            <x-datatable.create href="{{ route('products.create') }}" module="{{ __('modules/product.product') }}"/>
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
                        <th><input type="checkbox" id="check-all" style="margin-left: -8px;"></th>
                        <th>{{ __('modules/product.name') }}</th>
                        <th>{{ __('modules/product.price') }}</th>
                        <th>{{ __('modules/product.quantity') }}</th>
                        <th>{{ __('modules/product.category') }}</th>
                        @canany(['product.edit','product.delete'])
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
            dataTable = $('#dt').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                order: [[ 0, "desc" ]],
                ajax: {
                    url: '{!! route('products.list') !!}',
                    data: function (d) {
                        d.name = $('#filterForm #filter-name').val();
                        d.price = $('#filterForm #filter-price').val();
                        d.from = $('#filterForm #filter-from').val();
                        d.to = $('#filterForm #filter-to').val();
                    }
                },
                columns: [
                    { data: 'id', name: 'id',visible: false},
                    {
                        data: 'id',
                        name: 'id',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return '<input type="checkbox" class="check-item" value="' + data + '">';
                        }
                    },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'quantity', name: 'quantity' },
                    { data: 'category', name: 'category_id' },
                    @canany(['product.edit','product.delete'])
                    {data: 'actions',name: 'actions',orderable: false,searchable: false},
                    @endcanany
                ],
                columnDefs: [
                    @canany(['product.edit','product.delete'])
                    {
                        "targets": -1,
                        "render": function (data, type, row) {
                            var editUrl = '{{ route("products.edit", ":id") }}';
                            editUrl = editUrl.replace(':id', row.id);

                            var deleteUrl = '{{ route("products.destroy", ":id") }}';
                            deleteUrl = deleteUrl.replace(':id', row.id);

                            return `<div class='btn-actions'>
                                       @can('product.edit')
                                        <a class="text-success" href="${editUrl}"><i class="fas fa-pencil-alt mr-1"></i></a>
                                       @endcan
                                        @can('product.delete')
                                        <a class="confirm-delete text-danger" data-url="${deleteUrl}"><i class="far fa-trash-alt mr-1"></i></a>
                                       @endcan
                                    </div>`;
                        }
                    }
                    @endcanany
                ]
            });

            $('.btn-print').click(function() {
                var href = "{{route('products.print') }}";
                href += '?name=' + $('#filterForm #filter-name').val();
                href += "&price=" + $('#filterForm #filter-price').val();
                href += "&from=" + $('#filterForm #filter-from').val();
                href += "&to=" + $('#filterForm #filter-to').val();
                location.href = href;
            });
        });
    </script>
@endpush
