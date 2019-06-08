jQuery(document).ready(function($) {
    $('#wwbSelect').change(function() {
        if ($(this).val() !== '') {
            var choiceNumber = [];
            choiceNumber[0] = $(this).val();
            choiceNumber[1] = choiceNumber[0].replace('(', '');
            choiceNumber[2] = choiceNumber[1].replace(')', '');
            choiceNumber[3] = choiceNumber[2].replace(' ', '');
            choiceNumber[4] = choiceNumber[3].replace('-', '');
            $('#wwb__modal .modal-content .modal-footer a').attr({
                href: 'https://wa.me/55' + choiceNumber[4],
                target: '_blank'
            });
        } else {
            $('#wwb__modal .modal-content .modal-footer a').attr({
                href: '#!',
                target: '_self'
            });
        }
    });
});