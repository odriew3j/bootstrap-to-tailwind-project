

// Select2 call
$(document).ready(function () {
    $('.select2').select2();
});
// Select2 call

// Range Slider Configure
function updateInputsFromSlider(data) {
    $(".js-input-from").val(data.from);
    $(".js-input-to").val(data.to);
}

$(".js-range-slider").ionRangeSlider({
    skin: "big",
    type: "double",
    grid: false,
    min: 1,
    max: 1000000,
    from: 0,
    to: 1000000,
    onStart: updateInputsFromSlider,
    onChange: updateInputsFromSlider,
    onFinish: updateInputsFromSlider,
    onUpdate: updateInputsFromSlider
});

$(".js-input-from, .js-input-to").on("input", function () {
    var from = parseInt($(".js-input-from").val()) || 0;
    var to = parseInt($(".js-input-to").val()) || 0;

    if (from > to) {
        [from, to] = [to, from];
    }

    $(".js-range-slider").data("ionRangeSlider").update({ from: from, to: to });
});
// Range Slider Configure

// Filter & Search

// Accordion

function accordionBtn(){
    $('#filter_body').slideToggle()  // ساخت دکمه برای آکاردئونر
}

$("#filter_body").slideUp() // اسلایدر در شروع کار بسته باشد

// Modal backdrop

$(document).ready(function() {
    $('#modalBtn1').click(function() {
        $('#modal').modal('show');
    });

    $('#modalBtn2').click(function() {
        $('#modal').modal('show');
    });
});