;
(function () {
    'use strict';
    var modal = $('#delete-confirmation-modal');

    $(function () {
        $('[data-confirm-delete=true]').click(function (e) {
            e.preventDefault();
            modal.data('delete-href', $(this).attr('href'));
            modal.modal('show');
        });

        modal.find('.btn.yes-button').click(function () {
            modal.modal('hide');
            window.location = modal.data('delete-href');
        });
    });
})();
