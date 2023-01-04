<?php
/**
 * Plugin Name:       Mea Post Carousel
 * Description:       Example block scaffolded with Create Block tool.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mea-post-carousel
 *
 * @package           create-block
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_mea_post_carousel_block_init() {
    register_block_type( __DIR__ . '/build', array(
        'render_callback' => 'mea_post_carousel_plugin_render_mea_content'
    ) );
}
add_action( 'init', 'create_block_mea_post_carousel_block_init' );


function mea_post_carousel_plugin_render_mea_content(  $block_attributes, $content, $block_instance ) {

    $recent_posts = wp_get_recent_posts( array(
        'numberposts' => 10,
        'post_status' => 'publish',
    ) );
    if ( count( $recent_posts ) === 0 ) {
        return 'No posts';
    }

    $output = '<div class="mea-carousel">';

        foreach ( $recent_posts as $p ){
            $post_id = $p['ID'];
            $image = has_post_thumbnail( $post_id ) ? get_the_post_thumbnail( $post_id, array(350,375) ) : '';
            $excerpt = '';
            if (has_excerpt( $post_id )) {
                $excerpt = wp_strip_all_tags(get_the_excerpt( $post_id ));
            }
            $categories = get_the_category( $post_id );



            //begin the structure

            $output .= '<div class="mea-carousel-post">';

                $output .= '<div class="mea-post-img">';
                        $output .= $image;
                $output .= '</div>';

                $output .= '<div class="mea-post-categories">';
                        foreach ( $categories as $cat ) {
                            $output .= '<span class="mea-post-category">' . $cat->name . '</span>';
                        }
                $output .= '</div>';

                $output .= '<a href="' . esc_url( get_permalink( $post_id ) ) . '">';
                    $output .= '<div class="mea-post-excerpt">' . $excerpt . '</div>';
                $output .='</a>';

            $output .= '</div>';
        }



    $output .= '</div>'; //close the carousel

    return $output ?? '<strong>Sorry. No posts matching your criteria!</strong>';

}

add_action( 'wp_enqueue_scripts', 'mea_custom_block' );
function mea_custom_block(){
    // wp_enqueue_script() with your block JS goes first...

    // block css
    wp_enqueue_style(
        'mea-slick-css',
        plugins_url( '/src/slick/slick.css', __FILE__ ),
        array( 'wp-edit-blocks' )
    );

    // block css
    wp_enqueue_style(
        'mea-slick-theme-css',
        plugins_url( '/src/slick/slick-theme.css', __FILE__ ),
        array( 'wp-edit-blocks' )
    );

        // block css
    wp_enqueue_style(
        'mea-post-carousel-css',
        plugins_url( '/src/mea-post-carousel.css', __FILE__ ),
        array( 'wp-edit-blocks' )
    );

    wp_enqueue_script(
        'mea-slick-js',
        plugins_url( '/src/slick/slick.js', __FILE__ ),
        array('jquery'), '1.0', true
    );

    wp_enqueue_script(
        'mea-post-carousel-js',
        plugins_url( '/src/mea-post-carousel.js', __FILE__ ),
        array('jquery','mea-slick-js'), '1.0', true
    );

    wp_enqueue_script(
        'boxicons-js',
        'https://unpkg.com/boxicons@2.1.4/dist/boxicons.js',
        null, '1.0', true
    );


}