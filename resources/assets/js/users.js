(function () {

    if(!$('.full-access').prop('checked')) {
        $('.not-full-access').show();
    }

    $('.full-access').on('click', function() {
        if(!$('.full-access').prop('checked')) {
            $('.not-full-access').show();
        } else {
            $('.not-full-access').hide();
        }
    });

})();