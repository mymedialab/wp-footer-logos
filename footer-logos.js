var mml = mml || {};

mml.footerLogos = function($) {
    'use strict';
    var frame = wp.media({
        title : 'Choose a logo',
        multiple : false,
        library : { type : 'image'},
        button : { text : 'Use this image' },
    });

    var imageLink = '<a href="#" class="mml-footer-logos-add-image">Add an image</a>';

    function removeItem(e) {
        var $row = $(this).parents('.mml-footer-logos-logo');
        e.preventDefault();
        $row.remove();
    }
    function addImage(e) {
        var $input = $(this).parents('.mml-footer-logos-logo').find('.mml-footer-logos-logo-id');
        var $save = $(this).parents('.widget').find('.widget-control-save');
        e.preventDefault();
        frame.on('select', function() {
            var selection = frame.state().get('selection');
            if (!selection) {
                $input.value = "";
                $save.click();
                return;
            }
            selection.each(function(attachment) {
                $input.val(attachment.attributes.id);
                $save.click();
            });
        });
        frame.open();
    }
    function setupWidgetPanel(k, el) {
        var $loop = $(el).find('.mml-footer-logos-loop'),
            $add  = $(el).find('.mml-footer-logos-add-logo'),
            $item = $loop.find('.mml-footer-logos-logo').first().clone(),
            nextIndex = parseInt($(el).find('.mml-footer-logos-next-id').val(), 10);

        if ($item.find('.mml-footer-logos-add-image').size() === 0) {
            $item.find('img').remove();
            $item.prepend(imageLink);
        }

        function addNewRow(e) {
            var $new = $item.clone();
            e.preventDefault();
            $loop.append($new);
            $new.find('.mml-footer-logos-remove-logo')
                .off('click.footerLogos')
                .on('click.footerLogos', removeItem);
            $new.find('.mml-footer-logos-add-image')
                .off('click.footerLogos')
                .on('click.footerLogos', addImage);
            $new.find('input').each(function(k, el) {
                el.value = '';
                el.name = el.name.replace(/(widget-mml_footer_logos\[\d\]\[logos\])\[(\d)\]/g, '$1[' + (nextIndex) + ']');
            });
            nextIndex++;
        }

        $(el).find('.mml-footer-logos-remove-logo').off('click.footerLogos').on('click.footerLogos', removeItem);
        $(el).find('.mml-footer-logos-add-image').off('click.footerLogos').on('click.footerLogos', addImage);
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
