<?php

namespace PostGallery\Models;

use PostGallery\Models\OptionModel;
use Amostajo\LightweightMVC\Model;
use Amostajo\LightweightMVC\Traits\FindTrait;
use Amostajo\WPPluginCore\Log;
use Amostajo\WPPluginCore\Cache;

/**
 * PostGallery Settings model.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 1.0.0
 */
class PostGallery extends OptionModel
{
    /**
     * Instance information.
     * @since 1.0.0
     * @var object
     */
    protected static $instance;

    /**
     * Model id.
     * @since 1.0.0
     * @var string
     */
    protected $id = 'post_gallery';

    /**
     * Field aliases and definitions.
     * @since 1.0.0
     * @var array
     */
    protected $aliases = [
        'can_enqueue'       => 'field_can_enqueue',
        'types'             => 'field_types',
        'metabox_context'   => 'field_metabox_context',
        'metabox_priority'  => 'field_metabox_priority',
    ];

    /**
     * Finds and returns record from db.
     * @since 1.0.0
     *
     * @return object
     */
    public static function find()
    {
        return new self();
    }

    /**
     * Instance constructor.
     * @since 1.0.0.0
     *
     * @return this for chaining
     */
    public static function instance()
    {
        if ( isset( self::$instance ) )
            return self::$instance;
        self::$instance = Cache::remember(
            'post_gallery',
            43200,
            function() {
                return self::find();
            }
        );
        return self::$instance;
    }

    /**
     * Returns flag indicating if model has a specific post type configured.
     * @since 1.0.0
     *
     * @param string $type Post type slug.
     *
     * @return bool
     */
    public function has_type( $type )
    {
        if ( ! $this->types && ! is_array( $this->types ) ) return false;
        for ( $i = count( $this->types ) - 1; $i >= 0; --$i ) {
            if ( $this->types[$i] == $type )
                return true;
        }
        return false;
    }

    /**
     * Clears models cache.
     * @since 1.0.0
     */
    public function clear()
    {
        Cache::forget( 'post_gallery' );
    }
}