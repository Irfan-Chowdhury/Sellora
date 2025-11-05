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
                        <h1>@lang('file.Category')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@lang('file.Category')</li>
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
                            {{-- @can('category-store') --}}
                            <button type="button" class="btn btn-info parent_load" name="create_record" id="create_record">
                                <i class="fa fa-plus"></i> @lang('file.Add Category')
                            </button>
                            {{-- @endcan --}}
                            {{-- @can('category-action') --}}
                            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                                <i class="fa fa-minus-circle"></i> @lang('file.Bulk Action')
                            </button>
                            {{-- @endcan --}}
                            <table id="dataListTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="not-exported"></th>
                                        <th scope="col">{{ __('file.Image') }}</th>
                                        <th scope="col">{{ __('file.Category Name') }}</th>
                                        <th scope="col">@lang('file.Parent')</th>
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


    @include('admin.pages.category.create')
    @include('admin.pages.category.edit_modal')
    @include('admin.includes.confirm_modal')
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    @include('admin.includes.datatable_js')



    <!-- Page specific script -->
    <script>
        let indexURL = "{{ route('admin.categories.datatable') }}";
        let storeURL = "{{ route('admin.categories.store') }}";

        const editURL = "{{ route('admin.categories.edit', ':id') }}";

        let updateURL = "{{ route('admin.categories.update', ':id') }}";
        let deleteURL = "{{ route('admin.categories.destroy', ':id') }}";
        let activeURL = "{{ route('admin.categories.active', ':id') }}";
        let inactiveURL = "{{ route('admin.categories.inactive', ':id') }}";
        let bulkActionURL = "{{ route('admin.categories.bulk_action') }}";

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
                            data: 'category_image',
                            name: 'category_image',
                        },
                        {
                            data: 'category_name',
                            name: 'category_name',
                        },
                        {
                            data: 'parent',
                            name: 'parent',

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

            $(document).on('click', '.edit', function() {
                let id = $(this).data('id');
                let targetURL = editURL.replace(':id', id);

                $('#alert_message').html('');
                $.ajax({
                    url: targetURL,
                    type: "GET",
                    data: {
                        category_id: id
                    },
                    success: function(data) {
                        console.log(data);

                        $('#updateForm [name="category_id"]').val(data.category.id);
                        $('#updateForm [name="name"]').val(data.category.name);
                        $('#updateForm [name="icon"]').val(data.category.icon);
                        $('#updateForm [name="parent_id"]').selectpicker('val', data.category.parent_id);
                        if (data.category.top === 1) {
                            $('#updateForm [name="top"]').prop('checked', true);
                        } else {
                            $('#updateForm [name="top"]').prop('checked', false);
                        }

                        if (data.category.is_active === 1) {
                            $('#updateForm [name="is_active"]').prop('checked', true);
                        } else {
                            $('#updateForm [name="is_active"]').prop('checked', false);
                        }

                        if(data.category.image){
                            $('#previewImageEdit')
                                .attr('src', data.category.image)  // adjust path
                                .show();
                        } else {
                            $('#previewImageEdit').hide();
                        }
                        $('#editModal').modal('show');
                    }
                })
            });

            $(document).ready(function(){
                $("#imageInputCreate").change(function(e){
                    let reader = new FileReader();
                    reader.onload = function(e){
                        $("#previewImage").attr("src", e.target.result).show();
                    };
                    reader.readAsDataURL(this.files[0]);
                });
                $("#imageInputEdit").change(function(e){
                    let reader = new FileReader();
                    reader.onload = function(e){
                        $("#previewImageEdit").attr("src", e.target.result).show();
                    };
                    reader.readAsDataURL(this.files[0]);
                });
            });
        });
    </script>
@endpush
