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
                        <h1>@lang('file.Unit')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">@lang('file.Unit')</li>
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
                                <i class="fa fa-plus"></i> @lang('file.Add Unit')
                            </button>

                            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                                <i class="fa fa-minus-circle"></i> @lang('file.Bulk Action')
                            </button>

                            <table id="dataListTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="not-exported"></th>
                                        <th scope="col">{{ __('file.Name') }}</th>
                                        <th scope="col">{{ __('file.Code') }}</th>
                                        <th scope="col">{{ __('file.Base Unit') }}</th>
                                        <th scope="col">{{ __('file.Operator') }}</th>
                                        <th scope="col">@lang('file.Operation Value')</th>
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


    @include('admin.pages.units.create')
    @include('admin.pages.units.edit_modal')
    @include('admin.includes.confirm_modal')
@endsection

@push('scripts')
    <!-- DataTables  & Plugins -->
    @include('admin.includes.datatable_js')


    <!-- Page specific script -->
    <script>
        const indexURL = "{{ route('admin.units.index') }}";
        const storeURL = "{{ route('admin.units.store') }}";
        const editURL = "{{ route('admin.units.edit', ':id') }}";
        let updateURL = "{{ route('admin.units.update', ':id') }}";
        let deleteURL = "{{ route('admin.units.destroy', ':id') }}";
        let activeURL = "{{ route('admin.units.active', ':id') }}";
        let inactiveURL = "{{ route('admin.units.inactive', ':id') }}";
        const bulkActionURL = "{{ route('admin.units.bulk_action') }}";

        $(function() {
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
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
                            data: 'code',
                            name: 'code',
                        },
                        {
                            data: 'base_unit',
                            name: 'base_unit',
                        },
                        {
                            data: 'operator',
                            name: 'operator',
                        },
                        {
                            data: 'operation_value',
                            name: 'operation_value',
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


            // $(document).ready(function() {

            //     //===== Create Part =====

            //     $('#submitForm #operator, #submitForm #operation_value').closest('.form-group').hide();

            //     $('#submitForm select[name="base_unit"]').val('');

            //     $('#submitForm select[name="base_unit"]').change(function() {
            //         var selectedBaseUnit = $(this).val();

            //         if (selectedBaseUnit) {
            //             $('#submitForm #operator, #submitForm #operation_value').closest('.form-group').show();

            //             $('#submitForm #operator').val('/').prop('readonly', true);

            //             $('#submitForm #operation_value').prop('readonly', false); // Ensure it is editable

            //         } else {
            //             $('#submitForm #operator, #submitForm #operation_value').closest('.form-group').hide();
            //         }
            //     });

            //     // // ====== Update ======

            //     $('#updateForm select[name="base_unit"]').change(function() {
            //         var selectedBaseUnit = $(this).val();

            //         if (selectedBaseUnit) {
            //             $('#updateForm #operator, #updateForm #operation_value').closest('.form-group').show();

            //             $('#updateForm #operator').val('/').prop('readonly', true);

            //             $('#updateForm #operation_value').prop('readonly', false); // Ensure it is editable

            //         } else {
            //             $('#updateForm #operator, #updateForm #operation_value').closest('.form-group').hide();
            //         }
            //     });


            //     var selectedBaseUnitEdit = $('#updateForm select[name="base_unit"]').val(); // Get current selected value
            //     if (selectedBaseUnitEdit) {
            //         $('#updateForm #operator, #updateForm #operation_value').closest('.form-group').show();
            //         $('#updateForm #operator').val('/').prop('readonly', true); // Set operator to '/' and readonly
            //     }
            // });


            $(document).ready(function() {

                // Function to show/hide Operator and Operation Value fields
                function toggleOperatorAndOperationValueForm(baseUnitSelect, operatorInput, operationValueInput) {
                    var selectedBaseUnit = $(baseUnitSelect).val();

                    if (selectedBaseUnit) {
                        // If Base Unit is selected, show Operator and Operation Value fields
                        $(operatorInput).closest('.form-group').show();
                        $(operationValueInput).closest('.form-group').show();

                        // Set the Operator field to '/' and make it readonly
                        $(operatorInput).val('/').prop('readonly', true);

                        // Enable the Operation Value field for user input
                        $(operationValueInput).prop('readonly', false);
                    } else {
                        // If "None" is selected (i.e., base_unit is null), hide the fields
                        $(operatorInput).closest('.form-group').hide();
                        $(operationValueInput).closest('.form-group').hide();
                    }
                }

                // Create Part
                // Initially hide the Operator and Operation Value fields inside #submitForm
                toggleOperatorAndOperationValueForm('#submitForm select[name="base_unit"]', '#submitForm #operator', '#submitForm #operation_value');

                // When the Base Unit changes
                $('#submitForm select[name="base_unit"]').change(function() {
                    toggleOperatorAndOperationValueForm(this, '#submitForm #operator', '#submitForm #operation_value');
                });

                // Update Part
                // When the Base Unit changes in the update form
                $('#updateForm select[name="base_unit"]').change(function() {
                    toggleOperatorAndOperationValueForm(this, '#updateForm #operator', '#updateForm #operation_value');
                });

                // If there's any data pre-loaded into the update form (for editing)
                var selectedBaseUnitEdit = $('#updateForm select[name="base_unit"]').val();
                if (selectedBaseUnitEdit) {
                    toggleOperatorAndOperationValueForm('#updateForm select[name="base_unit"]', '#updateForm #operator', '#updateForm #operation_value');
                }

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

                        // Populate the form fields with the data received from the server
                        $('#updateForm [name="unit_id"]').val(response.data.id); // Unit ID
                        $('#updateForm [name="name"]').val(response.data.name); // Unit Name
                        $('#updateForm [name="code"]').val(response.data.code); // Unit Code
                        $('#updateForm [name="operator"]').val(response.data.operator); // Operator
                        $('#updateForm [name="operation_value"]').val(response.data.operation_value); // Operation Value

                        // $('#updateForm [name="base_unit"]').val(response.data.base_unit);

                        if (response.data.base_unit) {
                            $('#updateForm [name="base_unit"]').val(response.data.base_unit_id);
                        } else {
                            //Initially hide the Operator and Operation Value fields in #updateForm
                            $('#updateForm #operator, #updateForm #operation_value').closest('.form-group').hide();

                            $('#updateForm [name="base_unit"]').val('');
                        }

                        // Set the 'is_active' checkbox based on the value (1 for checked, 0 for unchecked)
                        $('#updateForm [name="is_active"]').prop('checked', response.data.is_active == 1);

                        // Show the modal
                        $('#editModal').modal('show');
                    }
                })
            });


        });
    </script>
@endpush
