function chkform() {
    "use strict";
    var tax_rate = $('#tax_rate').val();
    if (tax_rate === '') {
        alert('Enter tax rate');
        return false;
    }
    if (isNaN(tax_rate)) {
        alert('Enter proper tax rate');
        return false;
    }
}

function chkforms() {
    "use strict";
    var tax_rate = $('#taxrate').val();
    if (tax_rate === '') {
        alert('Enter tax rate');
        return false;
    }
    if (isNaN(tax_rate)) {
        alert('Enter proper tax rate');
        return false;
    }
}
