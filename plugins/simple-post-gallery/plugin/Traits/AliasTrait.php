<?php

namespace PostGallery\Traits;

/**
 * Alias trait.
 * Provides with alias functionality.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @license copyright
 * @package PostGallery
 * @version 1.0.0
 */
trait AliasTrait
{
    /**
     * Getter function.
     * @since 1.0.0
     *
     * @param string $property
     *
     * @return mixed
     */
    public function &__get( $property )
    {
        $value = null;
        $property = $this->get_alias_property( $property );

        if ( preg_match( '/field_/', $property )
            && array_key_exists( preg_replace( '/field_/', '', $property ), $this->attributes )
        ) {
            return $this->attributes[preg_replace( '/field_/', '', $property )];
        }

        if ( preg_match( '/func_/', $property ) ) {

            $function_name = preg_replace( '/func_/', '', $property );

            $value = $this->$function_name();
        }
        return $value;
    }

    /**
     * Setter function.
     * @since 1.0.0
     *
     * @param string $property
     * @param mixed  $value
     *
     * @return object
     */
    public function __set( $property, $value )
    {
        $property = $this->get_alias_property( $property );

        if ( preg_match( '/field_/', $property ) ) {

            $this->attributes[preg_replace( '/field_/', '', $property )] = $value;

        }
    }

    /**
     * Returns object converted to array.
     * @since 1.0.0
     *
     * @param array.
     */
    public function to_array()
    {
        $output = array();

        // Attributes
        foreach ($this->attributes as $property => $value) {
            $output[$this->get_alias('field_' . $property)] = $value;
        }

        // Functions
        foreach ($this->aliases as $alias => $property) {
            if ( preg_match( '/func_/', $property ) ) {
                $function_name = preg_replace( '/func_/', '', $property );
                $output[$alias] = $this->$function_name();
            }
        }

        // Hidden
        foreach ( $this->hidden as $key ) {
            unset( $output[$key] );
        }

        return $output;
    }

    /**
     * Returns json string.
     * @since 1.0.0
     *
     * @param string
     */
    public function to_json()
    {
        return json_encode( $this->to_array() );
    }

    /**
     * Returns string.
     * @since 1.0.0
     *
     * @param string
     */
    public function __toString()
    {
        return $this->to_json();
    }

    /**
     * Returns property mapped to alias.
     * @since 1.0.0
     *
     * @param string $alias Alias.
     *
     * @return string
     */
    private function get_alias_property( $alias )
    {
        if ( array_key_exists( $alias, $this->aliases ) )
            return $this->aliases[$alias];

        return $alias;
    }

    /**
     * Returns alias name mapped to property.
     * @since 1.0.0
     *
     * @param string $property Property.
     *
     * @return string
     */
    private function get_alias( $property )
    {
        if ( in_array( $property, $this->aliases ) )
            return array_search( $property, $this->aliases );

        return $property;
    }
}