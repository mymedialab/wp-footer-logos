<?php
if ( ! defined( 'ABSPATH' ) ) {
     // Exit if accessed directly
    exit;
}
 if ( !count($logos) ) {
    // output nothing if no logos are setup
    return;
 } ?>

<ul class="footer-logos">

    <?php foreach ($logos as $logo) : ?>

        <li class="footer-logos__item">

            <?php if ($logo['link']) : ?>
                <a class="footer-logos__link" href="<?= $logo['link'] ?>">
            <?php endif; ?>

            <?= wp_get_attachment_image($logo['image_id'], 'full', array('class' => 'footer-logos__img')); ?>

            <?php if ($logo['link']) : ?>
                </a>
            <?php endif; ?>

        </li>

    <?php endforeach; ?>

</ul>
