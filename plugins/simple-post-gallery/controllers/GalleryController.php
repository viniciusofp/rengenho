<?php

namespace PostGallery\Controllers;

use PostGallery\Models\Post;
use PostGallery\Models\PostGallery;
use Amostajo\LightweightMVC\Controller;
use Amostajo\LightweightMVC\Request;
use Amostajo\WPPluginCore\Cache;
use Amostajo\WPPluginCore\Log;

/**
 * Gallery Controller.
 *
 * @author Alejandro Mostajo <http://about.me/amostajo>
 * @copyright 10Quality <http://www.10quality.com>
 * @package PostGallery
 * @version 1.0.0
 */
class GalleryController extends Controller
{
    /**
     * Returns a post gallery.
     * @since 1.0.0
     *
     * @param mixed $post_id Post ID.
     *
     * @return array
     */
    public function get( $post_id = null )
    {
        try
        {
            if ( empty( $post_id ) )
                $post_id = get_the_ID();

            $post = Cache::remember(
                'gallery_post_' . $post_id,
                43200,
                function() use( &$post_id ) {
                    return Post::find( $post_id );
                }
            );

            if ( ! $post->gallery || ! is_array( $post->gallery ) )
                return;

            return $post->gallery;
        } catch (Exception $e) {
            Log::error( $e );
        }
        return;
    }

    /**
     * Displays a post gallery.
     * @since 1.0.0
     *
     * @param mixed $post_id Post ID.
     */
    public function show( $post_id = null )
    {
        try
        {
            if ( empty( $post_id ) )
                $post_id = get_the_ID();

            $post = Cache::remember(
                'gallery_post_' . $post_id,
                43200,
                function() use( &$post_id ) {
                    return Post::find( $post_id );
                }
            );

            if ( ! $post->gallery || ! is_array( $post->gallery ) )
                return;

            // Enqueue
            $post_gallery = PostGallery::instance();
            if ( $post_gallery->can_enqueue ) {
                wp_enqueue_script( 'lightbox' );
                wp_enqueue_style( 'lightbox' );
            }
            do_action( 'post_gallery_enqueue', $post_gallery );
            // Render
            return apply_filters(
                'gallery_view',
                $this->view->get( 'plugins.post-gallery.gallery', [
                    'post'   => $post,
                ] ),
                $post
            );
        } catch (Exception $e) {
            Log::error( $e );
        }
    }

    /**
     * Registers metaboxes.
     * @since 1.0.0
     *
     * @param string $post_type Post type to validate.
     */
    public function add_metabox( $post_type )
    {
        $post_gallery = PostGallery::instance();
        if ( ! $post_gallery->has_type( $post_type ) )
            return;

        add_meta_box( 
            '10q-post-gallery',
            __( 'Gallery', 'post-gallery' ),
            [ &$this, 'metabox' ],
            $post_type,
            $post_gallery->metabox_context ? $post_gallery->metabox_context : 'advanced',
            $post_gallery->metabox_priority ? $post_gallery->metabox_priority : 'default'
        );
    }

    /**
     * Displays gallery metabox.
     * @since 1.0.0
     *
     * @param object $post Post object WP_Post.
     */
    public function metabox( $post )
    {
        // Enqueue
        wp_enqueue_media();
        wp_enqueue_style( 'admin-post-gallery' );
        wp_enqueue_script( 'admin-post-gallery' );
        // Nonce control
        wp_nonce_field( 'metabox_gallery', 'metabox_gallery_nonce' );
        // Render
        $this->view->show( 'plugins.post-gallery.admin.metaboxes.gallery', [
            'post'  => Post::findWithType( $post->ID, $post->post_type ),
            'view'  => $this->view,
        ] );
    }

    /**
     * Saves gallery information.
     * @since 1.0.0
     *
     * @param int $post_id Post id.
     */
    public function save( $post_id )
    {
        $post_gallery = PostGallery::instance();
        $post_type = get_post_type( $post_id );
        if ( ! $post_gallery->has_type( $post_type ) )
            return;

        $nonce = Request::input( 'metabox_gallery_nonce', '', true );

        if ( (defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            || empty($nonce) 
            || ! wp_verify_nonce( $nonce, 'metabox_gallery' ) 
        ) {
            return;
        }

        try {

            $post = Post::findWithType( $post_id, $post_type );

            // Gallery
            $input = Request::input( 'media', [] );
            $media = [];
            // Check and remove duplicates
            foreach ( $input as $attachment ) {
                if ( ! in_array( $attachment, $media ) )
                    $media[] = $attachment;
            }
            $post->media = $media;

            $post->save();
            $post->clear();

        } catch (Exception $e) {
            Log::error( $e );
        }
    }
}