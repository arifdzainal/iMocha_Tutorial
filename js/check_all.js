function checkAll() {
    if ($('#check_all_hidden').val() == 1) {
        $('#check_all_hidden').val("0");
        $(':checkbox').each(function () {
            if ($(this).prop('disabled') == false) {
                this.checked = true;
            }
        });
    } else if ($('#check_all_hidden').val() == 0) {
        $('#check_all_hidden').val("1");
        $(':checkbox').each(function () {
            if ($(this).prop('disabled') == false) {
                this.checked = false;
            }
        });
    }
}