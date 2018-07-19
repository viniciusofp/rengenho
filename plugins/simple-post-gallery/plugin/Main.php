<?php

namespace PostGallery;

use Amostajo\WPPluginCore\Plugin;

/**
 * Main class.
 * Registers HOOKS used within the plugin.
 * Acts like a bridge or router of actions between Wordpress and the plugin.
 *
 * @link http://wordpress-dev.evopiru.com/documentation/main-class/
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality
 * @package PostGallery
 * @version 1.0
 */
class Main extends Plugin
{
    /**
     * Admin menu settings key.
     * @since 1.0
     * @var string
     */
    const ADMIN_MENU_SETTINGS = 'post-gallery-settings';

	/**
	 * Declares public HOOKS.
	 * @since 1.0
	 */
	public function init()
	{
		$this->add_shortcode( 'post_gallery', 'GalleryController@show' );
		$this->add_action( 'wp_enqueue_scripts', 'ConfigController@enqueue' );
	}

	/**
	 * Declares admin dashboard HOOKS.
	 * @since 1.0
	 */
	public function on_admin()
	{
        $this->add_action( 'admin_menu', 'AdminController@menu' );
		$this->add_action( 'admin_enqueue_scripts', 'AdminController@enqueue' );
		$this->add_action( 'add_meta_boxes', 'GalleryController@add_metabox', 10 );
		$this->add_action( 'save_post', 'GalleryController@save', 20 );
	}
}