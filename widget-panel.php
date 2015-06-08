<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<div class="mml-footer-logos">
    <p>
        <label for="<?= $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?= $this->get_field_id( 'title' ); ?>" name="<?= $this->get_field_name( 'title' ); ?>" type="text" value="<?= $title; ?>" />
    </p>

    <div class="mml-footer-logos-loop">
        <?php if ( ! count($logos) ) :
            $logos[] = array(); // make sure there's always at least one element as the JS uses it to set up a template
        endif;
        foreach ($logos as $i => $logo) :
            $link    = isset($logo['link']) ? $logo['link'] : '';
            $img_id  = isset($logo['image_id']) ? $logo['image_id'] : '';
            $img_src = wp_get_attachment_image_src( $img_id, 'thumbnail' );
            ?>
            <div class="mml-footer-logos-logo">
                <p>
                    <?php if ( is_array( $img_src ) ) : ?>
                        <img src="<?= $img_src[0] ?>" alt="" />
                    <?php endif; ?>
                    <a href="#" class="mml-footer-logos-add-image">Choose image</a>
                </p>

                <p>
                    <label>Link image to:
                        <input class="widefat" placeholder="optional" name="<?= $this->get_field_name( 'logos' ); ?>[<?= $i + 1 ?>][link]" type="text" value="<?= $link ?>" />
                    </label>

                    <input class="mml-footer-logos-logo-id" name="<?= $this->get_field_name( 'logos' ); ?>[<?= $i + 1 ?>][image_id]" type="hidden" value="<?= $img_id ?>" />
                </p>

                <a href="#" class="mml-footer-logos-remove-logo dashicons-before dashicons-trash" title="remove item"></a>
            </div>

        <?php endforeach; ?>
    </div>

    <p class="text-right">
        <input type="hidden" class="mml-footer-logos-next-id" value="<?= $i + 2 ?>" />
        <a href="#" class="mml-footer-logos-add-logo button">Add another logo</a>
    </p>
</div>

