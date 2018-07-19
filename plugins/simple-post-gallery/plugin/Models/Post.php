<?php

namespace PostGallery\Models;

use PostGallery\Models\Attachment;
use Amostajo\LightweightMVC\Model;
use Amostajo\LightweightMVC\Traits\FindTrait;
use Amostajo\WPPluginCore\Cache;
use Amostajo\WPPluginCore\Log;

/**
 * Post model.
 *
 * @link http://wordpress-dev.evopiru.com/documentation/models/
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 1.0.0
 */
class Post extends Model
{
	use FindTrait;

    /**
     * Default post status.
     * @since 1.0.0
     * @var string
     */
    protected $status = 'publish';

    /**
     * Model property alieases.
     * @since 1.0.0
     * @var array
     */
    protected $aliases = [
        'media'     => 'meta__gallery',
        'gallery'   => 'func_get_gallery',
    ];

    /**
     * Extension of normal find() constructor with the addition of a type.
     * The types is override to enable any post type modification.
     * @since 1.0.0
     *
     * @param int    $ID   Post ID.
     * @param string $type Post Type.
     *
     * @return object this
     */
    public static function findWithType( $ID, $type )
    {
        $model = self::find( $ID );
        $model->set_type( $type );
        return $model;
    }

    /**
     * Sets post type.
     * @since 1.0.0
     *
     * @param string $type Post Type.
     */
    public function set_type( $type )
    {
        $this->type = $type;
    }

    /**
     * Returns gallery attachments.
     * @since 1.0.0
     *
     * @return array
     */
    protected function get_gallery()
    {
        $media = $this->media;
        return Cache::remember(
            'gallery_' . $this->ID,
            43200,
            function() use( &$media ) {
                $gallery = [];
                if ( is_array( $media ) ) {
                    foreach ( $media as $media_id ) {
                        $gallery[] = Attachment::find( $media_id );
                    }
                }
                return $gallery;
            }
        );
    }

    /** 
     * Clears model cache.
     * @since 1.0.0
     */
    public function clear()
    {
        Cache::forget( 'gallery_post_' . $this->ID );
        Cache::forget( 'gallery_' . $this->ID );
    }
}