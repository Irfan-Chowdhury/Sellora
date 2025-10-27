@extends('admin.layout.master')

@section('admin-content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>@lang('file.Role')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Assign Role</li>
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
                            <!-- Left side: Role Button -->
                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                <a href="#" class="btn btn-info mr-2">
                                    <i class="fa fa-puzzle-piece mr-1"></i> {{ trans('file.Role') }}
                                </a>

                                <!-- Dropdown: Assign Role -->
                                <form id="mass_role_assign" class="mb-0">
                                    <select id="mass_select"
                                            class="form-control"
                                            data-style="btn-primary"
                                            name="mass_role"
                                            title="">
                                            <option value="">Select Role...</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>

                            <table id="dataListTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="not-exported"></th>
                                        {{-- <th>{{ __('Image') }}</th> --}}
                                        <th>{{ trans('file.Username') }}</th>
                                        <th>{{ __('Permission Role') }}</th>
                                        <th class="not-exported text-center">{{ __('Assign Role') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


@push('scripts')
    @include('admin.includes.datatable_js')


    <script type="text/javascript">
        const indexURL = "{{ route('admin.roles.assign') }}";
        // const storeURL = "{{ route('admin.roles.store') }}";

        (function($) {
            "use strict";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
                    columns: [
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, row, meta) {
                                return '<input type="checkbox" class="row-checkbox" data-id="' + row.id + '">';
                            },
                        },
                        {
                            data: 'username',
                            name: 'username',

                        },
                        {
                            data: 'role_name',
                            name: 'role_name',
                        },
                        {
                            data: 'assignRole',
                            name: 'assignRole',
                        }
                    ],

                    'select': {style: 'multi', selector: 'td:first-child'},
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
                let target = editURL.replace(':id', id);

                $.ajax({
                    url: target,
                    dataType: "json",
                    success: function(html) {
                        $('#updateForm [name="name"]').val(html.role.name);
                        $('#updateForm [name="role_id"]').val(html.role.id);
                        $('#updateForm [name="is_active"]').prop('checked', html.role.is_active ==
                            1);

                        $('#editModal').modal('show');
                    }
                })
            });

            $('body').on('click', '.assign-role', function () {
                let role_id = $(this).attr('data-role_id');
                let user_id = $(this).attr('data-user_id');

                let target = "{{ url('admin/roles/assign')}}/"+ user_id;
                $.ajax({
                    url: target,
                    method: "POST",
                    data: {
                        roleId: role_id,
                    },
                    error: function(response) {
                        console.log('response');
                        let htmlContent = prepareMessage(response);
                        displayErrorMessage(htmlContent);
                    },
                    success: function (response) {
                        console.log(response);
                        displaySuccessMessage(response.message);
                        $('#dataListTable').DataTable().ajax.reload();
                    }
                });
            });


            $('#mass_select').on('change', function () {
                let table = $('#dataListTable').DataTable();
                let massFormData = $('[name=mass_role]').val();
                let id = [];

                $('.row-checkbox:checked').each(function() {
                    id.push($(this).data('id'));
                });


                if (id.length > 0) {
                    if (confirm('{{__('Are you sure you want to assign this role to the selected users?')}}')) {
                        let target = "{{route('admin.mass_assign_role')}}";

                        $.ajax({
                            url: target,
                            method: "POST",
                            data: {
                                userIdArray: id,
                                mass_role: massFormData
                            },
                            error: function(response) {
                                console.log('response');
                                let htmlContent = prepareMessage(response);
                                displayErrorMessage(htmlContent);
                            },
                            success: function (response) {
                                console.log(response);
                                displaySuccessMessage(response.message);
                                $('#dataListTable').DataTable().ajax.reload();
                            }
                        });
                    }
                } else {
                    alert('{{__('No user is selected')}}')
                }
            });



            $('.close').on('click', function () {
                $('#role_assign')[0].reset();
            });

        })(jQuery);
    </script>
@endpush
