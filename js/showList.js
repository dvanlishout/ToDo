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


function addList(listname){
    var tekst3 = "";
    $.ajax
    ({
        type: "POST",
        url: "ajax/addlist.php",
        data: "listname="+ listname,
        success: function(data){
            $.each(data, function(i, field){
                tekst3 = tekst3 + data[i].taskname;
                tekst3 = tekst3 + "<br />";

            });


            document.getElementById('blok').innerHTML = tekst3;


        },
        error: function(data){

            document.getElementById('blok').innerHTML = "Deze lijstnaam bestaat al, kies een andere";


        }
    })
}