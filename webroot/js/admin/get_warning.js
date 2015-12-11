function getWarning() {
    var warningSelect = document.getElementById("warningSelect");
    var accountId = warningSelect.options[warningSelect.selectedIndex].value;
    var userData = 'account_id=' + accountId;
    $.ajax({
        url : "/admin/get_warning",
        data : userData,
        type : "POST",
        success : function(response) {
            document.getElementById("message").value = response;
        },
        error : function(xhr, status, error) {
            alert("error");
        }
    });
}