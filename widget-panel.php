<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="mml-footer-logos">
    <p><label for="<?= $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= $title; ?>" /></p>

    <div class="mml-footer-logos-loop">
        <?php $i = 0; /* Need to defin this in case there is no loop. */ ?>
        <?php if ( ! count($logos) ) : ?>

            <p class="mml-footer-logos-logo">
                <label><?php _e( 'Logo link:' ); ?>
                    <input name="<?= $this->get_field_name( 'logos' ); ?>[1][link]" type="text" value="" />
                </label>
                <input class="mml-footer-logos-logo-id"  name="<?= $this->get_field_name( 'logos' ); ?>[1][image_id]" type="hidden" value="" />
                <a href="#" class="mml-footer-logos-remove-logo" style="float:right;">&times;</a>
            </p>

        <?php else :
            foreach ($logos as $i => $logo) :
                $link = isset($logo['link']) ? $logo['link'] : '';
                $img_id = isset($logo['image_id']) ? $logo['image_id'] : '';
                $img_src = wp_get_attachment_image_src( $img_id, 'thumbnail' );
                $has_img = is_array( $img_src );
                ?>
                <p class="mml-footer-logos-logo clearfix">
                    <?php if ( $has_img ) : ?>
                        <img src="<?php echo $img_src[0] ?>" alt="" style="max-width:100%;" />
                    <?php else: ?>
                        <a href="#" class="mml-footer-logos-add-image">Add an image</a>
                    <?php endif; ?>

                    <label><?php _e( 'Link to:' ); ?>
                        <input name="<?= $this->get_field_name( 'logos' ); ?>[<?= $i + 1 ?>][link]" type="text" value="<?= $link ?>" />
                    </label>

                    <input class="mml-footer-logos-logo-id" name="<?= $this->get_field_name( 'logos' ); ?>[<?= $i + 1 ?>][image_id]" type="hidden" value="<?= $img_id ?>" />
                    <a href="#" class="mml-footer-logos-remove-logo" style="float:right;">&times;</a>
                </p>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <input type="hidden" class="mml-footer-logos-next-id" value="<?= $i + 2 ?>" />
    <a href="#" class="mml-footer-logos-add-logo">Add a logo</a>
</div>
