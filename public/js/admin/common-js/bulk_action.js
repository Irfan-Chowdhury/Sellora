(function ($) {
    "use strict";

    $("#bulk_action").on("click",function() {

        // var idsArray = [];
        // idsArray = table.rows({selected: true}).ids().toArray();

        // idsArray = table.rows({ selected: true }).data().pluck('id').toArray(); // Assumes 'id' exists in the data

        let table = $('#dataListTable').DataTable();
        let idsArray = [];
        $("#dataListTable .row-checkbox:checked").each(function () {
            idsArray.push($(this).data("id")); // Push the ID of the selected row
        });


        if(idsArray.length === 0){
            alert("Please Select at least one checkbox.");
        }else{
            $('#bulkConfirmModal').modal('show');
            let action_type;

            $("#active").on("click",function(){
                console.log(idsArray);
                action_type = "active";
                $.get({
                    url: bulkActionURL,
                    data: {idsArray:idsArray,action_type:action_type},
                    error: function(response){
                        console.log(response)
                        $('#bulkConfirmModal').modal('hide');
                        let htmlContent = prepareMessage(response);
                        displayErrorMessage(htmlContent);
                        table.rows('.selected').deselect();
                    },
                    success: function (response) {
                        console.log(response);
                        $('#bulkConfirmModal').modal('hide');
                        displaySuccessMessage(response.message);
                        if ($.fn.DataTable.isDataTable('#dataListTable')) {
                            $('#dataListTable').DataTable().ajax.reload();
                        }
                        table.rows('.selected').deselect();
                    }
                });
            });
            
            $("#inactive").on("click",function(){
                action_type = "inactive";
                console.log(idsArray);
                $.get({
                    url: bulkActionURL,
                    data: {idsArray:idsArray,action_type:action_type},
                    error: function(response){
                        console.log(response)
                        $('#bulkConfirmModal').modal('hide');
                        let htmlContent = prepareMessage(response);
                        displayErrorMessage(htmlContent);
                        table.rows('.selected').deselect();
                    },
                    success: function (response) {
                        console.log(response);
                        $('#bulkConfirmModal').modal('hide');
                        displaySuccessMessage(response.message);
                        if ($.fn.DataTable.isDataTable('#dataListTable')) {
                            $('#dataListTable').DataTable().ajax.reload();
                        }
                        table.rows('.selected').deselect();
                    }
                });
            });


            $("#bulkDelete").on("click",function(){
                action_type = "delete";
                $.get({
                    url: bulkActionURL,
                    data: {idsArray:idsArray,action_type:action_type},
                    error: function (response) {
                        console.log(response);
                        let htmlContent = prepareMessage(response);
                        displayErrorMessage(htmlContent);
                        table.rows('.selected').deselect();
                    },
                    success: function (response) {
                        console.log(response);
                        $('#bulkConfirmModal').modal('hide');
                        displaySuccessMessage(response.message);
                        if ($.fn.DataTable.isDataTable('#dataListTable')) {
                            $('#dataListTable').DataTable().ajax.reload();
                        }
                        table.rows('.selected').deselect();
                    }
                });
            });
        }
    });

})(jQuery);

