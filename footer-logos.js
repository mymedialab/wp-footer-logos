var mml = mml || {};

mml.footerLogos = function($) {
    'use strict';

    function removeItem(e) {
        var $row = $(this).parent('.mml-footer-logos-logo');
        e.preventDefault();
        if ($row.siblings('.mml-footer-logos-logo').size() === 0) {
            $row.find('input').val('');
        } else {
            $row.remove();
        }
    }
    function setupWidgetPanel(k, el) {
        var $loop = $(el).find('.mml-footer-logos-loop'),
            $add  = $(el).find('.mml-footer-logos-add-logo'),
            $item = $loop.find('.mml-footer-logos-logo').first().clone();

        function addNewRow(e) {
            var $new = $item.clone();
            e.preventDefault();
            $loop.append($new);
            $new.find('.mml-footer-logos-remove-logo')
                .off('click.footerLogos')
                .on('click.footerLogos', removeItem);
        }

        $item.find('input').val('');
        $(el).find('.mml-footer-logos-remove-logo').off('click.footerLogos').on('click.footerLogos', removeItem);
        $add.off('click.footerLogos')
            .on('click.footerLogos', addNewRow);
    }

    function setupAllPanels() {
        var $panels = $('.mml-footer-logos');
        $panels.each(setupWidgetPanel);
    }

    $(document).on('widget-updated', setupAllPanels);
    setupAllPanels();
}

mml.footerLogos(jQuery);
