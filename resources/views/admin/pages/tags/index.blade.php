@extends('admin.layout.master')

@push('css')
    <link rel="preload" href="{{ asset('vendor/bootstrap/css/bootstrap-select.min.css') }}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="preload" href="{{ asset('vendor/bootstrap/css/bootstrap-select.min.css') }}" as="style"
            onload="this.onload=null;this.rel='stylesheet'">
    </noscript>

    <link rel="stylesheet" href="{{ asset('admin-lte') }}/dist/css/style.default.css">
@endpush

@section('admin-content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('file.Tag')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@lang('file.Tag')</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>


        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                                <i class="fa fa-plus"></i> @lang('file.Add Tag')
                            </button>

                            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                                <i class="fa fa-minus-circle"></i> @lang('file.Bulk Action')
                            </button>

                            <table id="dataListTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="not-exported"></th>
                                        <th scope="col">{{ __('file.Name') }}</th>
                                        <th scope="col">@lang('file.Status')</th>
                                        <th scope="col">@lang('file.Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>


    @include('admin.pages.tags.create')
    @include('admin.pages.tags.edit_modal')
    @include('admin.includes.confirm_modal')
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    @include('admin.includes.datatable_js')


    <!-- Page specific script -->
    <script>
        const indexURL = "{{ route('admin.tags.index') }}";
        const storeURL = "{{ route('admin.tags.store') }}";
        const editURL = "{{ route('admin.tags.edit', ':id') }}";
        let updateURL = "{{ route('admin.tags.update', ':id') }}";
        let deleteURL = "{{ route('admin.tags.destroy', ':id') }}";
        let activeURL = "{{ route('admin.tags.active', ':id') }}";
        let inactiveURL = "{{ route('admin.tags.inactive', ':id') }}";
        const bulkActionURL = "{{ route('admin.tags.bulk_action') }}";

        $(function() {
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            });

            $('#create_record').click(function() {
                $('#createModal').modal('show');
            });


            $(document).ready(function() {
                $("#dataListTable").DataTable({
                    responsive: true,
                    fixedHeader: {
                        header: true,
                        footer: true
                    },
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: indexURL,
                    },
                    columns: [{
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return '<input type="checkbox" class="row-checkbox" data-id="' +
                                    row.id + '">';
                            },
                        },
                        {
                            data: 'name',
                            name: 'name',
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                        }
                    ],

                    "paging": true,
                    "responsive": true,
                    "searching": true,
                    "lengthChange": false,
                    "autoWidth": true,
                    "ordering": true,
                    "info": true,
                    "buttons": ["copy", "csv", "excel", "pdf", "print"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });


            $(document).on('click', '.edit', function(e) {
                e.preventDefault();

                let id = $(this).data('id');
                let targetURL = editURL.replace(':id', id);

                $.ajax({
                    url: targetURL,
                    dataType: "json",
                    success: function(response) {
                        console.log(response.data);
                        $('#updateForm [name="name"]').val(response.data.name);
                        $('#updateForm [name="tag_id"]').val(response.data.id);
                        $('#updateForm [name="is_active"]').prop('checked', response.data.isActive ==1);

                        $('#editModal').modal('show');
                    }
                })
            });

        });
    </script>
@endpush
