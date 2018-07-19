<?php
/**
 * Metabox input attachment view/template.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 1.0
 */ 
?>
<div id="<?php echo isset( $attachment ) ? $attachment->ID : '{{id}}' ?>"
    class="attachment attachment-<?php echo isset( $attachment ) ? $attachment->ID : '{{id}}' ?>"
>
    <div class="wrapper">
        <span class="remove from-gallery">
            <i class="fa fa-trash-o" aria-hidden="true"></i>
        </span>
        <img alt="<?php echo isset( $attachment ) ? $attachment->alt : '{{alt}}' ?>"
            <?php if ( isset( $attachment ) ) : ?>
                src="<?php echo $attachment->edit_url ?>"
            <?php endif ?>
            style="height: 65px"
        />
        <input type="hidden"
            name="media[]"
            value="<?php echo isset( $attachment ) ? $attachment->ID : '{{id}}' ?>"
        />
    </div>
</div>