(function ($) {
    "use strict";

    $(document).on("click",".inactive",function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $.get({
            url: inactiveURL,
            data: {id:id},
            error: function(response){
                console.log(response)
                let htmlContent = prepareMessage(response);
                displayErrorMessage(htmlContent);
            },
            success: function(response){
                console.log(response);
                displaySuccessMessage(response.message);
                if ($.fn.DataTable.isDataTable('#dataListTable')) {
                    $('#dataListTable').DataTable().ajax.reload();
                }
            }
        });
    });

})(jQuery);
