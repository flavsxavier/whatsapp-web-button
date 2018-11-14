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
});