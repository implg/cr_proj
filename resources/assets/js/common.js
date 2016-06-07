$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.datetimepicker.setLocale('ru');
    $('.datetimepicker').datetimepicker();

    $('.datetimepicker2').datetimepicker({
        format:'Y-m-d H:i:s'
    });

    $.material.init();

    $('.tooltip').tooltip();
});