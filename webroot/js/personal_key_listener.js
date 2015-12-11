function accNumberKey(keyCode) {
    if(keyCode != 8 && keyCode != 46 && keyCode != 37 && keyCode != 39 && keyCode != 9)
        if(keyCode == 110 || keyCode == 190 || keyCode == 188 || keyCode == 191) {
            document.getElementById("acc_surname").focus();
            return false;
        }
        else
        if((keyCode < 95 || keyCode > 106) && (keyCode < 48 || keyCode > 57)) {
            return false;
        }
}

function accNumberKeyUp(keyCode) {
    if (document.getElementById("acc_number").value.length == 6) {
        document.getElementById("acc_surname").focus();
    }
}