<?php

namespace PostGallery\Controllers;

use PostGallery\Main as Software;
use PostGallery\Models\PostGallery;
use Amostajo\LightweightMVC\Controller;
use Amostajo\LightweightMVC\Request;
use Amostajo\WPPluginCore\Cache;
use Amostajo\WPPluginCore\Log;

/**
 * Handles admin methods.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 1.0.4
 */
class AdminController extends Controller
{
    /**
     * Enqueues and registers scripts.
     * @since 1.0.0
     * @since 1.0.4 Updated to version 1.0.4.
     */
    public function enqueue()
    {
        wp_register_style(
            'font-awesome',
            asset_url( '/../css/font-awesome.css', __FILE__ ),
            [],
            '4.6.1'
        );
        wp_register_style(
            'admin-post-gallery',
            asset_url( '/../css/admin.css', __FILE__ ),
            [ 'font-awesome' ],
            '1.0.4'
        );
        wp_register_script(
            'admin-post-gallery',
            asset_url( '/../js/admin.js', __FILE__ ),
            [ 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ],
            '1.0.4',
            true
        );
    }

    /**
     * Registers admin menus.
     * @since 1.0.0
     */
    public function menu()
    {
        add_submenu_page(
            'options-general.php',
            __( 'Post Gallery Settings', 'post-gallery' ),
            __( 'Galleries', 'post-gallery' ),
            'manage_options',
            Software::ADMIN_MENU_SETTINGS,
            [ &$this, 'view_settings' ]
        );
    }

    /**
     * Displays admin settings.
     * @since 1.0.0
     * @since 1.0.3 Added cache tab.
     */
    public function view_settings()
    {
        // Enqueue
        wp_enqueue_style( 'font-awesome' );
        wp_enqueue_style( 'admin-post-gallery' );
        wp_enqueue_script( 'admin-post-gallery' );
        // Render
        $postGallery = PostGallery::find();
        $this->view->show( 'plugins.post-gallery.admin.settings', [
            'notice'        => $this->save( $postGallery ),
            'error'         => Request::input( 'error' ),
            'tab'           => Request::input( 'tab', 'general' ),
            'tabs'          => apply_filters( 'inquiry_settings_tabs', [
                                'general'   => __( 'General', 'post-gallery' ),
                                'cache'     => __( '<i class="fa fa-cog" aria-hidden="true"></i> Cache', 'post-gallery' ),
                                'docs'      => __( '<i class="fa fa-book" aria-hidden="true"></i> Documentation', 'post-gallery' ),
                            ] ),
            'view'          => $this->view,
            'types'         => get_post_types(
                                [
                                    'public'   => true,
                                ],
                                'names'
                            ),
            'postGallery'   => $postGallery,
        ] );
    }

    /**
     * Saves settings.
     * Returns flag indicating success operation
     * @since 1.0.0
     * @since 1.0.3 Added cache flush.
     *
     * @param object $socialFeeder Social Feeder model
     */
    protected function save( &$model )
    {
        $notice = Request::input( 'notice' );
        // Check action
        if ( !empty( $notice ) ) return $notice;
        // Save form
        if ( $_POST ) {
            try {
                if ( $_POST['submit'] === 'cache.flush' ) {
                    Cache::flush();
                    return __( 'Cache cleared.', 'post-gallery' );
                }
                
                // General tab information
                $model->can_enqueue         = Request::input( 'can_enqueue', 0 );
                $model->types               = Request::input( 'types', [] );
                $model->metabox_context     = Request::input( 'metabox_context', 'advanced' );
                $model->metabox_priority    = Request::input( 'metabox_priority', 'default' );

                $model = apply_filters( 'postgallery_settings_before_save', $model );

                $model->save();
                $model->clear();

                return __( 'Settings saved.', 'post-gallery' );

            } catch (Exception $e) {
                Log::error($e);
            }
        }
        return;
    }
}