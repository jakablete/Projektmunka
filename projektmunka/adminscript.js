// script.js
var selectedData = {};

function listItemClick(felado_id, cimzett_id, termek_id) {
    selectedData.felado_id = felado_id;
    selectedData.cimzett_id = cimzett_id;
    selectedData.termek_id = termek_id;

    $.ajax({
        url: '../get_messages.php',
        type: 'POST',
        data: selectedData,
        dataType: 'json',
        success: function (response) {
            selectedDataFromServer = response;
            console.log('Adatok a szerverről:', selectedDataFromServer);

            var form = document.createElement("form");
            form.method = "post";
            form.action = "adminuzenetek.php";

            for (var key in selectedDataFromServer) {
                var input = document.createElement("input");
                input.type = "hidden";
                input.name = key;
                input.value = selectedDataFromServer[key];
                form.appendChild(input);
            }

            document.body.appendChild(form);
            form.submit();
        },
        error: function (error) {
            console.error('Hiba történt:', error);
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    var msgHistory = document.querySelector(".msg_history");
    msgHistory.scrollTop = msgHistory.scrollHeight;
});
