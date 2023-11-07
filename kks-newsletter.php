<?php
/**
 * Plugin Name:       KKS Newsletter
 * Description:       Displays Mad Mimi Newsletters via iframe
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Shrinkray
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       kks-newsletter
 *
 * @package           kks
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function kks_newsletter_block_register(): void
{
    register_block_type( dirname(__FILE__) . '/build/block.json' );
}
add_action( 'init', 'kks_newsletter_block_register', 5 );


/**
 * Register our block's fields into ACF.
 *
 * @return void
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

    acf_add_local_field_group( $field_json );
}

add_action( 'acf/init', 'kks_newsletter_register_include_fields' );

/**
 * Register a custom block category for our blocks.
 *
 * @link https://developer.wordpress.org/reference/hooks/block_categories_all/
 *
 * @param array $block_categories Existing block categories
 * @return array Block categories
 */
function kks_newsletter_block_categories(array $block_categories ): array
{

	$block_categories = array_merge(
		[
			[
				'slug'  => 'acf-blocks',
				'title' => __( 'KKS Blocks', 'kks-newsletter-block' ),
				'icon'  => '<svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
<g id="katzhead" clip-path="url(#clip0_36_826)">
<path id="headshapefill" fill-rule="evenodd" clip-rule="evenodd" d="M15.9399 6.87022C16.8833 4.78086 18.1705 2.76782 19.8016 0.831386C20.6245 -0.242285 21.2051 -0.311434 21.4928 0.831386C21.9875 2.87181 21.6298 5.65081 20.9769 8.68538C23.5628 10.2553 24.4295 12.562 23.2702 15.737C22.3059 16.5974 21.1481 17.3032 19.8016 17.858C18.5604 20.0966 16.9918 20.5593 15.2154 19.8931C14.0819 20.8641 12.7753 21.4543 11.2598 21.5843C8.20107 21.7636 6.52181 19.6854 5.98537 15.737C4.75505 14.6657 3.60399 13.5681 2.54149 12.441C1.87686 11.7359 1.24707 11.0194 0.653985 10.2907C-0.155856 8.9782 -0.0172921 8.24948 2.00106 8.68538C4.31409 9.0157 6.51197 9.74948 8.67208 10.6154C9.96569 8.11065 12.4298 6.929 15.9399 6.87022Z" fill="#E9B832"/>
</g>
<defs>
<clipPath id="clip0_36_826">
<rect width="24" height="21.5745" fill="white"/>
</clipPath>
</defs>
</svg>
',
			]
		],
		$block_categories,
	);

	return $block_categories;
}
add_filter( 'block_categories_all', 'kks_newsletter_block_categories' );