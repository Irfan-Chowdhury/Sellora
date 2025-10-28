@extends('admin.layout.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/kendo.default.v2.min.css') }}" type="text/css">
@endpush

@section('admin-content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <span id="form_result_permission"></span>

                            <h1 class="text-center mt-2">{{ $role->name }}</h1>
                            <p>{{ __('You can assign permission for this role') }}</p>
                            <div id="all_resources">
                                <div class="demo-section k-content">

                                    <h4>{{ __('Select modules') }}</h4>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div id="treeview1"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="treeview2"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <div id="treeview3"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <div class="form-group row mt-4">
            <div class="col-md-6 offset-md-3">
                <input id="role_id" type="hidden" name="role_id" value={{ $role->id }}>
                <button class="btn btn-primary btn-block" id="set_permission_btn" type="submit"
                    class="roles-btn btn-primary">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>
    </div>
@endsection


@push('scripts').
<script type="text/javascript" src="{{ asset('js/kendo.all.min.js') }}"></script>

<script type="text/javascript">
    (function($) {
        "use strict";

        var checkedNodes;


        $(document).ready(function () {

            $("ul#setting").siblings('a').attr('aria-expanded', 'true');
            $("ul#setting").addClass("show");
            $("ul#setting #role-menu").addClass("active");

            var target = '{{route('admin.permissionDetails',$role->id)}}';
            $.ajax({
                type: "GET",
                url: target,
                dataType: 'json',
                success: function (result) {
                    console.log(result);

                    $("#treeview1").empty();
                    $("#treeview1").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: [
                            {
                                id: 'category',
                                text: "{{__('Category Management')}}",
                                expanded: true,
                                checked: ($.inArray('category', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'view-category',
                                        text: '{{__('View Category')}}',
                                        checked: ($.inArray('view-category', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'store-category',
                                        text: '{{__('Store Category')}}',
                                        checked: ($.inArray('store-category', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'edit-category',
                                        text: '{{__('Edit Category')}}',
                                        checked: ($.inArray('edit-category', result) >= 0) ? true : false
                                    },
                                    {
                                        id: 'delete-category',
                                        text: '{{__('Delete Category')}}',
                                        checked: ($.inArray('delete-category', result) >= 0) ? true : false
                                    },
                                ]
                            },
                            {
                                id: 'customize-setting',
                                text: "{{__('Customize Setting')}}",
                                expanded: true,
                                checked: ($.inArray('customize-setting', result) >= 0) ? true : false,
                                items: [
                                    {
                                        id: 'role',
                                        text: "{{trans('Role')}}",
                                        expanded: true,
                                        checked: ($.inArray('role', result) >= 0) ? true : false,
                                        items: [
                                            {
                                                id: 'view-role',
                                                text: '{{__('View Role')}}',
                                                checked: ($.inArray('view-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'store-role',
                                                text: '{{__('Add Role')}}',
                                                checked: ($.inArray('store-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'edit-role',
                                                text: '{{__('Edit Role')}}',
                                                checked: ($.inArray('edit-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'delete-role',
                                                text: "{{__('Delete Role')}}",
                                                checked: ($.inArray('delete-role', result) >= 0) ? true : false
                                            },
                                            {
                                                id: 'set-permission',
                                                text: '{{__('Set Permission')}}',
                                                checked: ($.inArray('set-permission', result) >= 0) ? true : false
                                            },
                                        ]
                                    },
                                ]
                            },

                        ]
                    });

                    $("#treeview2").empty();
                    $("#treeview2").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: [
                        ]
                    });

                    $("#treeview3").empty();
                    $("#treeview3").kendoTreeView({
                        checkboxes: {
                            checkChildren: true
                        },
                        check: onCheck,
                        dataSource: [
                        ]
                    });


                    // function that gathers IDs of checked nodes
                    function checkedNodeIds(nodes, checkedNodes) {

                        for (var i = 0; i < nodes.length; i++) {
                            if (nodes[i].checked) {
                                getParentIds(nodes[i], checkedNodes);
                                checkedNodes.push(nodes[i].id);
                            }

                            if (nodes[i].hasChildren) {
                                checkedNodeIds(nodes[i].children.view(), checkedNodes);
                            }
                        }
                    }

                    function getParentIds(node, checkedNodes) {
                        if (node.parent() && node.parent().parent() && checkedNodes.indexOf(node.parent().parent().id) == -1) {
                            getParentIds(node.parent().parent(), checkedNodes);
                            checkedNodes.push(node.parent().parent().id);
                        }
                    }

                    // show checked node IDs on datasource change
                    function onCheck() {
                        checkedNodes = [];
                        var treeView1 = $('#treeview1').data("kendoTreeView"),
                            message;
                        var treeView2 = $('#treeview2').data("kendoTreeView"),
                            message;
                        var treeView3 = $('#treeview3').data("kendoTreeView"),
                            message;

                        //console.log(treeView.dataSource.view());
                        //console.log(checkedNodes);

                        checkedNodeIds(treeView1.dataSource.view(), checkedNodes);
                        checkedNodeIds(treeView2.dataSource.view(), checkedNodes);
                        checkedNodeIds(treeView3.dataSource.view(), checkedNodes);

                        // if (checkedNodes.length > 0) {
                        //     message = "IDs of checked nodes: " + checkedNodes.join();
                        // } else {
                        //     message = "No nodes checked.";
                        // }
                        // $("#result").html(message);
                    }

                }
            });


            $('#set_permission_btn').on('click', function () {

                if (checkedNodes) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var target = '{{route('admin.set_permission')}}';

                    $.ajax({
                        type: 'POST',
                        url: target,
                        data: {
                            checkedId: checkedNodes,
                            roleId: "{{ $role->id}}",
                        },
                        success: function (response) {
                            displaySuccessMessage(response.message);


                            // var html = '';
                            // if (data.errors) {
                            //     html = '<div class="alert alert-danger">';
                            //     for (var count = 0; count < data.errors.length; count++) {
                            //         html += '<p>' + data.errors[count] + '</p>';
                            //     }
                            //     html += '</div>';
                            // }
                            // if (data.success) {
                            //     html = '<div class="alert alert-success">' + data.success + '</div>';
                            // }
                            // if (data.error) {
                            //     html = '<div class="alert alert-danger">' + data.error + '</div>';
                            // }
                            // $('#form_result_permission').html(html).slideDown(100).delay(3000).slideUp(100);
                        }
                    });
                } else {
                    alert('{{__('Please select atleast one checkbox')}}');
                }


            });

        });
    })(jQuery);
</script>

<script type="text/javascript" src="{{asset('js/admin/common-js/alertMessages.js')}}"></script>

@endpush
