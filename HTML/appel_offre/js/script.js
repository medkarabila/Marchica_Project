// Add Record
function addRecord() {
    // get values
    var titre = $("#titre").val();
    var description = $("#description").val();
    var type = $("#type").val();
    var chef = $("#chef").val();
    var datec = $("#datec").val();
    var datej = $("#datej").val();
    var montant = $("#montant").val();
    var cps = $("#cps").val();

    // Add record
    $.post("ajax/addRecord.php", {
        titre: titre,
        description: description,
        type: type,
        chef: chef,
        datec: datec,
        datej: datej,
        montant: montant,
        cps: cps

    }, function (data, status) {
        // close the popup
        $("#add_new_record_modal").modal("hide");

        // read records again
        readRecords();

        // clear fields from the popup
        $("#titre").val("");
        $("#description").val("");
        $("#type").val("");
        $("#chef").val("");
        $("#datec").val("");
        $("#datej").val("");
        $("#montant").val("");
        $("#cps").val("");

    });
}

// READ records
function readRecords() {
    $.get("ajax/readRecords.php", {}, function (data, status) {
        $(".records_content").html(data);
    });
}


function DeleteUser(id) {
    var conf = confirm("Are you sure, do you really want to delete offre?");
    if (conf == true) {
        $.post("ajax/deleteUser.php", {
                id: id
            },
            function (data, status) {
                // reload Users by using readRecords();
                readRecords();
            }
        );
    }
}

function GetUserDetails(id) {
    // Add User ID to the hidden field for furture usage
    $("#hidden_user_id").val(id);
    $.post("ajax/readUserDetails.php", {
            id: id
        },
        function (data, status) {
            // PARSE json data
            var user = JSON.parse(data);
            // Assing existing values to the modal popup fields
            $("#update_titre").val(user.titre);
            $("#update_description").val(user.description);
            $("#update_type").val(user.type);
            $("#update_chef").val(user.chef);
            $("#update_datec").val(user.datec);
            $("#update_datej").val(user.datej);
            $("#update_montant").val(user.montant);
            $("#update_cps").val(user.cps);

        }
    );
    // Open modal popup
    $("#update_user_modal").modal("show");
}

function UpdateUserDetails() {
    // get values
    var titre = $("#update_titre").val();
    var description = $("#update_description").val();
    var type = $("#update_type").val();
    var chef = $("#update_chef").val();
    var datec = $("#update_datec").val();
    var datej = $("#update_datej").val();
    var montant = $("#update_montant").val();
    var cps = $("#update_cps").val();


    // get hidden field value
    var id = $("#hidden_user_id").val();

    // Update the details by requesting to the server using ajax
    $.post("ajax/updateUserDetails.php", {
            id: id,
            titre: titre,
            description: description,
            chef: chef,
            datec: datec,
            datej: datej,
            montant: montant,
            cps: cps,
            type: type
        },
        function (data, status) {
            // hide modal popup
            $("#update_user_modal").modal("hide");
            // reload Users by using readRecords();
            readRecords();
        }
    );
}

$(document).ready(function () {
    // READ recods on page load
    readRecords(); // calling function
});
