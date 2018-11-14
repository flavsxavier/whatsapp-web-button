$(function() {
    var multi_options = $("input[name='wpp__multi_act']:checked").val();
    var html = "";
    // Opções Múltiplos Números
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
});