<?php
/**
 * Gallery view/template.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 1.0
 */ 
?>
<div class="#post-gallery">

    <?php foreach ( $post->gallery as $attachment ) : ?>

        <a href="<?php echo $attachment->large_url ?>"
            data-lightbox="post-gallery-<?php echo $post->ID ?>"
            <?php if ( $attachment->caption ) : ?>
                data-title="<?php echo $attachment->caption ?>"
            <?php endif ?>
        >
            <img src="<?php echo $attachment->thumb_url ?>"
                alt="<?php echo $attachment->alt ?>"
            />
        </a>

    <?php endforeach ?>

</div>