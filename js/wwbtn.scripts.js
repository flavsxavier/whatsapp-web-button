$(function() {
    // Opções Ícones
    var select = "#wpp__modes";
    if ($(select).val() == "wpp__custom") {
        $(".wpp__img_custom").removeClass("hidden");
    }
    if ($(select).val() == "wpp__padrao") {
        $(".wpp__img_custom").addClass("hidden", "");
    }
    if ($(select).val() == "wpp__business") {
        $(".wpp__img_custom").addClass("hidden", "");
    }
    $(select).change(function() {
        if ($(this).val() == "wpp__custom") {
            $(".wpp__img_custom").removeClass("hidden");
        }
        if ($(this).val() == "wpp__padrao") {
            $(".wpp__img_custom").addClass("hidden", "");
        }
        if ($(this).val() == "wpp__business") {
            $(".wpp__img_custom").addClass("hidden", "");
        }
    });
    // Opções Múltiplos Números
    var multi_numbers = [];
    var multi_options = $("input[name='wpp__multi_act']:checked").val();
    if (multi_options == "active") {
        $(".wpp__single_tel").addClass("hidden", "");
        $(".wpp__multi_tel").removeClass("hidden");
        // Atributos
        $(".wpp__single_tel td input").attr("disabled", "");
        $(".wpp__multi_tel td input").removeAttr("disabled", "");
    }else if (multi_options == "desativ") {
        $(".wpp__single_tel").removeClass("hidden");
        $(".wpp__multi_tel").addClass("hidden", "");
        // Atributos
        $(".wpp__single_tel td input").removeAttr("disabled", "");
        $(".wpp__multi_tel td input").attr("disabled", "");
    }
    $("#add__multi_btn").click(function() {
        var labelExist = false;
        var label = $("#id__multi_label").val();
        var number = $("#id__multi_number").val();
        multi_numbers.forEach(verLabelExist);
        function verLabelExist(item, index, arr) {
            if (arr[index][0] == label) {
                labelExist = true;
            }
        }
        if (labelExist == false) {
            $("#wwbtn__notices").html("");
            multi_numbers[multi_numbers.length] = [label, number];
        } else if (labelExist == true) {
            $("#wwbtn__notices").html("<div class='notice notice-error'><p>O nome definido já está vinculado a outro telefone, tente outro nome.</p></div>");
            $('html, body').animate({scrollTop: 0}, 400);
        }
    });
    $("#submit").click(function(e) {
        // e.preventDefault();
        $.post(wwbtn_ajax_object.ajax_url, {
            'action': 'save__multi_numbers',
            'data': multi_numbers
        }, function(response) {
            $("#wwbtn__notices").html(response);
            $('html, body').animate({scrollTop: 0}, 400);
        });
    });
});