<?php

namespace PostGallery\Models;

use Amostajo\LightweightMVC\Model;
use Amostajo\LightweightMVC\Traits\FindTrait;
use Amostajo\WPPluginCore\Cache;
use Amostajo\WPPluginCore\Log;

/**
 * Attachment model.
 *
 * @link http://wordpress-dev.evopiru.com/documentation/models/
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 1.0.3
 */
class Attachment extends Model
{
    use FindTrait;

    /**
     * Post type.
     * @since 1.0.0
     * @var string
     */
    protected $type = 'attachment';

    /**
     * Post status.
     * @since 1.0.0
     * @var string
     */
    protected $status = 'inherit';

    /**
     * Aliases.
     * @since 1.0.0
     * @since 1.0.1 Added title, date and mime
     * @var array
     */
    protected $aliases = [
        'title'         => 'post_title',
        'date'          => 'post_date',
        'mime'          => 'post_mime_type',
        'url'           => 'guid',
        'caption'       => 'func_get_caption',
        'alt'           => 'meta__wp_attachment_image_alt',
        'thumb_url'     => 'func_get_thumb_url',
        'large_url'     => 'func_get_large_url',
        'edit_url'      => 'func_get_edit_url',
        'medium_url'    => 'func_get_medium_url',
        'path'          => 'func_get_path',
    ];

    /**
     * Hidden attributes in Array and JSON casting.
     * @since 1.0.1
     * @var array
     */
    protected $hidden = [
        'post_author',
        'post_title',
        'post_name',
        'post_content',
        'post_date',
        'post_date_gmt',
        'post_excerpt',
        'post_status',
        'comment_status',
        'ping_status',
        'post_password',
        'post_name',
        'to_ping',
        'pinged',
        'post_modified',
        'post_modified_gmt',
        'post_content_filtered',
        'post_parent',
        'guid',
        'menu_order',
        'post_type',
        'post_mime_type',
        'comment_count',
    ];

    /**
     * Returns processed caption.
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_caption()
    {
        if ($this->post_excerpt)
            return htmlentities($this->post_excerpt);
        return;
    }

    /**
     * Returns image path.
     * @since 1.0.0
     *
     * @return string
     */
    protected function get_path()
    {
        $ID = $this->ID;
        return Cache::remember(
            'attachment_' . $this->ID . '_path',
            43200,
            function() use( &$ID ) {
                $metadata = get_post_meta( $ID, '_wp_attachment_metadata', true );
                $upload_dir = wp_upload_dir();
                if ( $metadata
                    && isset( $metadata['file'] )
                    && isset( $upload_dir['basedir'] )
                ) {
                    return $upload_dir['basedir'] . '/' . $metadata['file'];
                }
                return;
            }
        );
    }

    /**
     * Returns image with proper edit resolution.
     * @since 1.0.0
     * @since 1.0.3 Adds ID on resize.
     *
     * @return string
     */
    protected function get_edit_url()
    {
        $path = $this->path;
        return Cache::remember(
            'attachment_' . $this->ID . '_edit',
            43200,
            function() use( &$path ) {
                try {
                    return resize_image(
                        $path,
                        170,
                        65,
                        false,
                        $this->ID
                    );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
        );
    }

    /**
     * Returns image with thumb resolution.
     * @since 1.0.0
     * @since 1.0.3 Adds ID on resize.
     *
     * @return string
     */
    protected function get_thumb_url()
    {
        $path = $this->path;
        return Cache::remember(
            'attachment_' . $this->ID . '_thumb',
            43200,
            function() use( &$path ) {
                try {
                    return resize_image(
                        $path,
                        get_option( 'thumbnail_size_w', 150),
                        get_option( 'thumbnail_size_h', 150),
                        true,
                        $this->ID
                    );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
        );
    }

    /**
     * Returns image with large resolution.
     * @since 1.0.0
     * @since 1.0.3 Adds ID on resize.
     *
     * @return string
     */
    protected function get_large_url()
    {
        $path = $this->path;
        return Cache::remember(
            'attachment_' . $this->ID . '_large',
            43200,
            function() use( &$path ) {
                try {
                    return resize_image(
                        $path,
                        get_option( 'large_size_w', 1024),
                        get_option( 'large_size_h', 1024),
                        false,
                        $this->ID
                    );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
        );
    }

    /**
     * Returns image with medium resolution.
     * @since 1.0.0
     * @since 1.0.3 Adds ID on resize.
     *
     * @return string
     */
    protected function get_medium_url()
    {
        $path = $this->path;
        return Cache::remember(
            'attachment_' . $this->ID . '_medium',
            43200,
            function() use( &$path ) {
                try {
                    return resize_image(
                        $path,
                        get_option( 'medium_size_w', 300),
                        get_option( 'medium_size_h', 300),
                        false,
                        $this->ID
                    );
                } catch ( Exception $e ) {
                    Log::error( $e );
                }
                return;
            }
        );
    }
}