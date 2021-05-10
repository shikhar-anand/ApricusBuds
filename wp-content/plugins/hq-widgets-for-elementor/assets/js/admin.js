jQuery(document).ready(function ($) {

    // Toggle Element
    function bind_toggle_widgets_buttons() {
        $('.hqt-container-buttons [data-toggle]').on('click', function (e) {
            e.preventDefault();
            var area = $(this).closest('.hqt-tab').find('.hqt-container__fields');
            var checkbox = area.find('.hqt-control input[type="checkbox"]').not(':disabled');
            if ('all' === $(this).data('toggle')) {
                checkbox.prop('checked', true).val('on');
            }
            if ('none' === $(this).data('toggle')) {
                checkbox.prop('checked', false).val('off');
            }
        });
    }

    bind_toggle_widgets_buttons();

});