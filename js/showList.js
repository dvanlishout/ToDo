/**
 * Created by Ditte on 07/08/16.
 */

$(document).ready(function () {
    function showList(e){

        var listname = $(".listname").val();

            $.post("ajax/showlist.php", {listname: listname})
                .done(function (response) {
                    if (response.status === 'error') {
                        $("div.feedback").html("<p class='bg-danger text-danger'>No tasks yes, you better get going!</p>");
                    } else if(response.status === 'success'){
                        $("#tasklist").show();
                    }
                });
        };




        e.preventDefault();





});
