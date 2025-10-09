(function ($) {
    "use strict";

    $(document).on("click",".active",function(e){
        e.preventDefault();
        var id = $(this).data("id");
        $.get({
            url: activeURL,
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

