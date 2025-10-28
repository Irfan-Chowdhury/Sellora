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
                            <li class="breadcrumb-item active">@lang('file.Role')</li>
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
                                Add Role
                            </button>

                            <button type="button" class="btn btn-danger" name="bulk_delete" id="bulk_action">
                                <i class="fa fa-minus-circle"></i> @lang('file.Bulk Action')
                            </button>

                            <table id="dataListTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="not-exported"></th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ trans('file.Status') }}</th>
                                        <th class="not-exported">{{ __('Action') }}</th>
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


    @include('admin.pages.roles.create')
    @include('admin.pages.roles.edit_modal')
    @include('admin.includes.confirm_modal')
@endsection


@push('scripts')
    @include('admin.includes.datatable_js')


    <script type="text/javascript">
        const indexURL = "{{ route('admin.roles.index') }}";
        const storeURL = "{{ route('admin.roles.store') }}";
        const editURL = "{{ route('admin.roles.edit', ':id') }}";
        let updateURL = "{{ route('admin.roles.update', ':id') }}";
        const activeURL = "{{ route('admin.roles.active') }}";
        const inactiveURL = "{{ route('admin.roles.inactive') }}";
        const deleteURL = "{{ route('admin.roles.destroy', ':id') }}";
        const bulkActionURL = "{{ route('admin.roles.bulk_action') }}";



        (function($) {
            "use strict";

            var checkedNodes;
            var rid;
            var rname;


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
                            render: function(data) {
                                if (data == '1') {
                                    return "<td><div class = 'badge badge-success'>{{ trans('file.Active') }}</div>"
                                } else {
                                    return "<td><div class = 'badge badge-danger'>{{ trans('file.Inactive') }}</div>"
                                }
                            }

                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false
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



            $(document).on('click', '.permission', function(e) {


                e.preventDefault();
                rid = $(this).attr('id');
                rname = $(this).attr('role');

                document.getElementById('rname').innerHTML = rname;

                var target = "roles/role-permission/" + rid;
                $.ajax({
                    type: "GET",
                    url: target,
                    dataType: 'json',
                    success: function(result) {
                        $('#permissionModal').modal('show');
                        $("#treeview").empty();
                        $("#treeview").kendoTreeView({
                            checkboxes: {
                                checkChildren: true
                            },

                            check: onCheck,

                            dataSource: [{
                                id: 'all-access',
                                text: "ALL ACCESS",
                                expanded: true,
                                items: [{
                                        id: 'user',
                                        text: "{{ trans('User') }}",
                                        expanded: true,
                                        checked: ($.inArray('user', result) >=
                                            0) ? true : false,
                                        items: [{
                                                id: 'user-add',
                                                text: '{{ __('Add User') }}',
                                                checked: ($.inArray(
                                                        'user-add',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'user-edit',
                                                text: '{{ __('Edit User') }}',
                                                checked: ($.inArray(
                                                        'user-edit',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'user-delete',
                                                text: "{{ __('Delete User') }}",
                                                checked: ($.inArray(
                                                        'user-delete',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'users-list',
                                                text: "{{ __('Users List') }}",
                                                checked: ($.inArray(
                                                        'users-list',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'user-last-login',
                                                text: "{{ __('Users Last Login') }}",
                                                checked: ($.inArray(
                                                        'user-last-login',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'user-role-access',
                                                text: "{{ __('Users Role and access') }}",
                                                checked: ($.inArray(
                                                        'user-role-access',
                                                        result) >= 0) ?
                                                    true : false
                                            }
                                        ]
                                    },

                                    {
                                        id: 'customize-setting',
                                        text: "{{ __('Customize Setting') }}",
                                        expanded: true,
                                        items: [{
                                                id: 'role-access',
                                                text: '{{ __('Roles and Access') }}',
                                                checked: ($.inArray(
                                                        'role-access',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'general-setting',
                                                text: "{{ __('General Setting') }}",
                                                checked: ($.inArray(
                                                        'general-setting',
                                                        result) >= 0) ?
                                                    true : false
                                            },
                                            {
                                                id: 'language-setting',
                                                text: "{{ __('Language Setting') }}",
                                                checked: ($.inArray(
                                                        'language-setting',
                                                        result) >= 0) ?
                                                    true : false
                                            }
                                        ]
                                    }
                                ]
                            }]
                        });


                        // function that gathers IDs of checked nodes
                        function checkedNodeIds(nodes, checkedNodes) {

                            for (var i = 0; i < nodes.length; i++) {
                                if (nodes[i].checked) {
                                    checkedNodes.push(nodes[i].id);
                                }

                                if (nodes[i].hasChildren) {
                                    checkedNodeIds(nodes[i].children.view(), checkedNodes);
                                }
                            }
                        }

                        // show checked node IDs on datasource change
                        function onCheck() {
                            checkedNodes = [];
                            var treeView = $("#treeview").data("kendoTreeView"),
                                message;

                            checkedNodeIds(treeView.dataSource.view(), checkedNodes);

                            if (checkedNodes.length > 0) {
                                message = "IDs of checked nodes: " + checkedNodes.join();
                            } else {
                                message = "No nodes checked.";
                            }
                            $("#result").html(message);
                        }

                    }
                });
            });

        })(jQuery);
    </script>
@endpush
