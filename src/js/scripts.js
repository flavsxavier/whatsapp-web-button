jQuery(document).ready(function($) {
    $('a span#wwb__section img').tooltip();
    $('#table__multi_tel').DataTable();
    $('#wwb__tel_id').mask('(99) 9999-9999');
    $('#wwb__mnumber_id').mask('(99) 9999-9999');
    // Opções Ícones
    var select = "#wwb__modes";
    if ($(select).val() == "wpp__custom") {
        $(".wwb__custom_icon").removeClass("hidden");
    }
    if ($(select).val() == "wpp__padrao") {
        $(".wwb__custom_icon").addClass("hidden", "");
    }
    if ($(select).val() == "wpp__business") {
        $(".wwb__custom_icon").addClass("hidden", "");
    }
    $(select).change(function() {
        if ($(this).val() == "wpp__custom") {
            $(".wwb__custom_icon").removeClass("hidden");
        }
        if ($(this).val() == "wpp__padrao") {
            $(".wwb__custom_icon").addClass("hidden", "");
        }
        if ($(this).val() == "wpp__business") {
            $(".wwb__custom_icon").addClass("hidden", "");
        }
    });
    // Opções Múltiplos Números
    var multi_numbers = [];
    var multi_option = $("input[name='wwb__multi_status']:checked").val();
    if (multi_option == "activated") {
        $(".wwb__single_tel").addClass("hidden", "");
        $(".wwb__multi_input").removeClass("hidden");
        $(".wwbtn__submit").removeClass("hidden");
        // Atributos
        $(".wwb__single_tel td input").attr("disabled", "");
        $(".wwb__multi_input td input").removeAttr("disabled", "");
        $(".wwbtn__submit p a").attr("id", "add__multi_btn");
    } else if (multi_option == "deactivated") {
        $(".wwb__single_tel").removeClass("hidden");
        $(".wwb__multi_input").addClass("hidden", "");
        $(".wwbtn__submit").addClass("hidden", "");
        // Atributos
        $(".wwb__single_tel td input").removeAttr("disabled", "");
        $(".wwb__multi_input td input").attr("disabled", "");
        $(".wwbtn__submit p a").attr("id", "disabled__multi_btn");
    }
    $("#add__multi_btn").click(function() {
        var label = $("#wwb__mlabel_id").val();
        var number = $("#wwb__mnumber_id").val();
        multi_numbers.forEach(verLabelExist);
        function verLabelExist(item, index, arr) {
            if (arr[index][0] == label) {
                labelExist = true;
            }
        }
        if (typeof labelExist == 'undefined' || labelExist == false) {
            multi_numbers[multi_numbers.length] = [label, number];
            $("#wwbtn__notices").html("");
        } else if (typeof labelExist !== 'undefined' && labelExist == true) {
            $("#wwbtn__notices").html("<div class='notice notice-error'><p>O nome definido já está vinculado a outro telefone, tente outro nome.</p></div>");
            $('html, body').animate({scrollTop: 0}, 400);
            registerNumberFalse = false;
        }
        $("#wwb__mlabel_id").val("");
        $("#wwb__mnumber_id").val("");
    });
    $(".delete__number").click(function() {
        label_del = $(this).attr("data-number");
        $.post(wwbtn_ajax_object.ajax_url, {
            'action': 'delete__number',
            'data': label_del
        }, function(response) {
            $("#wwbtn__notices").html(response);
            $('html, body').animate({scrollTop: 0}, 400);
            location.reload();
        });
    });
    $("#submit").click(function(e) {
        $.post(wwbtn_ajax_object.ajax_url, {
            'action': 'save__multi_numbers',
            'data': multi_numbers
        }, function(response) {
            $("#wwbtn__notices").html(response);
            $('html, body').animate({scrollTop: 0}, 400);
        });
    });
    var multiSelect = "#wwbSelect";
    $(multiSelect).change(function() {
        if ($(this).val() !== "") {
            var choiceNumber = [];
            choiceNumber[0] = $(this).val();
            choiceNumber[1] = choiceNumber[0].replace("(", "");
            choiceNumber[2] = choiceNumber[1].replace(")", "");
            choiceNumber[3] = choiceNumber[2].replace(" ", "");
            choiceNumber[4] = choiceNumber[3].replace("-", "");
            $('#wwbModal .modal-dialog .modal-content .modal-footer a').attr('href', 'https://wa.me/55' + choiceNumber[4]);
        } else {
            $('#wwbModal .modal-dialog .modal-content .modal-footer a').attr('href', '#');
        }
    });
});