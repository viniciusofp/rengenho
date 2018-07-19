<?php

namespace PostGallery\Controllers;

use Amostajo\LightweightMVC\Controller;

/**
 * Config Controller.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 1.0.0
 */
class ConfigController extends Controller
{
    /**
     * Enqueues and registers scripts.
     * @since 1.0.0
     */
    public function enqueue()
    {
        wp_register_style(
            'lightbox',
            asset_url( '/../css/lightbox.css', __FILE__ ),
            [],
            '2.8.2'
        );
        wp_register_script(
            'lightbox',
            asset_url( '/../js/lightbox.js', __FILE__ ),
            [ 'jquery' ],
            '2.8.2',
            true
        );
    }
}