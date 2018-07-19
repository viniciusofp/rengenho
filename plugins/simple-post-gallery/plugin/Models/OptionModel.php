<?php

namespace PostGallery\Models;

use PostGallery\Traits\AliasTrait;
use Amostajo\LightweightMVC\Contracts\Modelable;
use Amostajo\LightweightMVC\Contracts\Findable;
use Amostajo\LightweightMVC\Contracts\Arrayable;
use Amostajo\LightweightMVC\Contracts\JSONable;
use Amostajo\LightweightMVC\Contracts\Stringable;

/**
 * Abstract Model Class based on Wordpress Model.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license copyright
 * @package PostGallery
 * @version 1.0.0
 */
abstract class OptionModel implements Modelable, Arrayable, JSONable, Stringable
{
    use AliasTrait;

    /**
     * Option prefix.
     * @since 1.0.0
     * @var string
     */
    protected $prefix = 'model_';

    /**
     * Model id.
     * @since 1.0.0
     * @var string
     */
    protected $id;
    
    /**
     * Attributes in model.
     * @since 1.0.0
     * @var array
     */
    protected $attributes = array();

    /**
     * Attributes and aliases hidden from print.
     * @since 1.0.0
     * @var array
     */
    protected $hidden = array();

    /**
     * Field aliases.
     * @since 1.0.0
     * @var array
     */
    protected $aliases = array();

    /**
     * Default constructor.
     * @since 1.0.0
     */
    public function __construct()
    {
        if ( isset( $this->id ) && ! empty( $this->id )  )
            $this->load($this->id);
    }

    /**
     * Loads model from db.
     * @since 1.0.0
     *
     * @param string $id Option key ID.
     */
    public function load( $id )
    {
        $this->attributes = json_decode(
            get_option( $this->prefix . $this->id ),
            true
        );
        if ( $this->attributes == null )
            $this->attributes = array();
    }

    /**
     * Saves current model in the db.
     * @since 1.0.0
     *
     * @return mixed.
     */
    public function save()
    {
        if ( ! $this->is_loaded() ) return false;

        $this->fill_defaults();

        update_option(
            $this->prefix . $this->id,
            json_encode( $this->attributes )
        );

        return true;
    }

    /**
     * Deletes current model in the db.
     * @since 1.0.0
     *
     * @return mixed.
     */
    public function delete()
    {
        if ( ! $this->is_loaded() ) return false;

        delete_option( $this->prefix . $this->id);

        return true;
    }

    /**
     * Returns flag indicating if object is loaded or not.
     * @since 1.0.0
     *
     * @return bool
     */
    public function is_loaded()
    {
        return !empty( $this->attributes );
    }

    /**
     * Fills default when about to create object
     * @since 1.0.0
     */
    private function fill_defaults()
    {
        if ( ! array_key_exists('ID', $this->attributes) ) {

            $this->attributes['ID'] = $this->id;

        }
    }
}
