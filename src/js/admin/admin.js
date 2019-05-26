jQuery(document).ready(function($) {
    // Table and masks
    $('#table__multi_tel').DataTable();
    $('#wwb__tel_id').mask('(99) 9999-9999');
    $('#wwb__mnumber_id').mask('(99) 9999-9999');

    // Icons
    if ($('#wwb__modes').val() == 'custom') {
        $('.wwb__custom_icon').removeClass('hidden');
    }
    if ($('#wwb__modes').val() == 'default' || $('#wwb__modes').val() == 'business') {
        $(".wwb__custom_icon").addClass('hidden', '');
    }
    $('#wwb__modes').change(function() {
        if ($(this).val() == 'custom') {
            $('.wwb__custom_icon').removeClass('hidden');
        }
        if ($(this).val() == 'default' || $('#wwb__modes').val() == 'business') {
            $(".wwb__custom_icon").addClass('hidden', '');
        }
    });
    $('.wwb__file_btn').click(function(e) {
        e.preventDefault();
        var custom_uploader = wp.media({
            title: 'Ícone',
            button: {
                text: 'Enviar'
            },
            multiple: false  // Set this to true to allow multiple files to be selected
        })
        .on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            $('.wwb__file_input').val(attachment.title);
        })
        .open();
    });

    // Multiple Numbers
    var multi_numbers = [];
    $('#add__mnumbers_btn').click(function() {
        var label = $('#wwb__mlabel_id').val().trim();
        var number = $('#wwb__mnumber_id').val();
        multi_numbers.forEach(verLabelExist);
        function verLabelExist(item, index, arr) {
            if (arr[index][0] == label) {
                labelExist = true;
            }
        }
        if (typeof labelExist == 'undefined' || labelExist == false) {
            multi_numbers[multi_numbers.length] = [label, number];
            $('.mnumbers-preview').html(function() {
                html = '';
                multi_numbers.forEach(function(item, index, arr) {
                    html = html.concat('<p>'+ arr[index][0] + ' - ' + arr[index][1] +'</p>');
                });
                return html;
            });
        } else if (typeof labelExist !== 'undefined' && labelExist) {
            $('#wwb__notices').html('<div class="notice notice-error" id="message"><p><strong>Este nome já está vinculado a outro numero, tente outro.<strong></p></div>');
            $('html, body').animate({scrollTop: 0}, 'slow');
            registerNumberFalse = false;
        }
        $('#wwb__mlabel_id').val('');
        $('#wwb__mnumber_id').val('');
    });
    $('#save__mnumbers_btn').click(function() {
        if (multi_numbers !== '') {
            $.post(wwbtn_ajax_object.ajax_url, {
                'action': 'save__multi_numbers',
                'data': multi_numbers
            }, function(response) {
                if (response == 'success') {
                    multi_numbers = [];
                    $('#wwb__notices').html('<div class="updated"><p><strong>Alterações salvas.</strong> <a href="'+ window.location.href +'">Recarregar</a>.</p></div>');
                } else if (response == 'fail') {
                    $('#wwb__notices').html('<div class="error"><p><strong>O nome definido já está vinculado a outro telefone, tente outro nome.<strong></p></div>');
                }
                multi_numbers = [];
                $('.mnumbers-preview').html('<p>Não há números adicionados ainda.</p>');
                $('html, body').animate({scrollTop: 0}, 'slow');
            });
        }
    });
    $('#clean__mnumbers_btn').click(function() {
        multi_numbers = [];
        $('.mnumbers-preview').html('<p>Não há números adicionados ainda.</p>');
    });
    $('.delete__number').click(function() {
        label_del = $(this).attr('data-label');
        $.post(wwbtn_ajax_object.ajax_url, {
            'action': 'delete__number',
            'data': label_del
        }, function(response) {
            if (response == 'success') {
                multi_numbers = [];
                $('#wwb__notices').html('<div class="updated"><p><strong>Número deletado.</strong> <a href="'+ window.location.href +'">Recarregar</a>.</p></div>');
            } else {
                $('#wwb__notices').html('<div class="error"><p><strong><span class="dashicons dashicons-warning"></span> Desculpe, um erro ocorreu. Se o erro persistir me informe através do <a href="https://github.com/flavisXavier">GitHub</a>.<strong></p></div>');
            }
            $('html, body').animate({scrollTop: 0}, 'slow');
        });
    });
});