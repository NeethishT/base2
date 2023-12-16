var selectAllItems = "#select-all";
var checkboxItem = ":checkbox";
$(selectAllItems).click(function () {
    if (this.checked) {
        $(checkboxItem).each(function () {
            this.checked = true;
        });
    } else {
        $(checkboxItem).each(function () {
            this.checked = false;
        });
    }
});

$('input[type=checkbox]').click(function () {
    $(this).parent().find('li input[type=checkbox]').prop('checked', $(this).is(':checked'));
    var sibs = false;
    $(this).closest('ul').children('li').each(function () {
        if ($('input[type=checkbox]', this).is(':checked')) sibs = true;
    });
    $(this).parents('ul').prev().prop('checked', sibs);
});

$('body').on('click', '.expand-row', function () {
    $('#modal-popup-content').text($(this).find(".expand_content").text());
});