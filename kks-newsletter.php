<?php
/**
 * Plugin Name:       KKS Newsletter
 * Description:       Displays MailerLite Newsletters via iframe
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.3
 * Author:            Shrinkray
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kks-newsletter
 *
 * @package           kks
 * @return void
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register the block type
 */
function kks_newsletter_block_register(): void
{
    register_block_type(
        __DIR__ . '/build/block.json',
        [
            'render_template' => plugin_dir_path(__FILE__) . 'build/newsletter.php'
        ]
    );

    if (function_exists('acf_register_block_type')) {
        acf_register_block_type([
            'name'              => 'kks-newsletter',
            'title'            => __('KKS Newsletter'),
            'description'      => __('Displays MailerLite newsletters via iframe'),
            'render_template'  => plugin_dir_path(__FILE__) . 'build/newsletter.php',
            'category'         => 'acf-blocks',
            'icon'             => 'email',
            'mode'             => 'preview',
            'supports'         => [
                'mode' => false,
                'align' => true,
                'jsx' => true
            ]
        ]);
    }
}

/**
 * Register ACF fields
 */
function kks_newsletter_register_include_fields(): void
{
	$path                     = __DIR__ . '/acf-fields.json';
    $field_json               = json_decode( file_get_contents( $path ), true );
    $field_json['location']   = array(
        array(
            array(
                'param'    => 'block',
                'operator' => '==',
                'value'    => 'kks/kks-newsletter', // block.json name.
            ),
        ),
    );
    $field_json['local']      = 'json';
    $field_json['local_file'] = $path;

    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group( $field_json ); // This simplifies the process of adding fields without duplicating code.

}

add_action( 'kks/include_fields', 'kks_newsletter_register_include_fields' );

/**
 * Initialize the plugin
 */
function kks_newsletter_init() {
    add_action('init', 'kks_newsletter_block_register', 5);
    add_action('acf/init', 'kks_newsletter_register_include_fields', 99);
}

// Initialize the plugin
add_action('plugins_loaded', 'kks_newsletter_init');

// Register block category
function kks_newsletter_block_categories(array $block_categories): array
{
    $block_categories = array_merge(
        [
            [
                'slug'  => 'acf-blocks',
                'title' => __( 'KKS Blocks', 'kks-newsletter-block' ),
                'icon'  => 'pm',
            ]
        ],
        $block_categories,
    );

    return $block_categories;
}
add_filter( 'block_categories_all', 'kks_newsletter_block_categories' );