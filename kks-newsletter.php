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
 * @return void
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

add_action( 'kks/include_fields', 'kks_newsletter_register_include_fields' );

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
				'icon'  => '<svg xmlns:xlink="http://www.w3.org/1999/xlink" width="24" xmlns="http://www.w3.org/2000/svg" height="22" id="screenshot-8a3cf441-50d2-801a-8003-6ed292a548cd" viewBox="0 0 24 22" style="-webkit-print-color-adjust: exact;" fill="none" version="1.1"><g id="shape-8a3cf441-50d2-801a-8003-6ed292a548cd" rx="0" ry="0" style="fill: rgb(0, 0, 0);"><g id="shape-8a3cf441-50d2-801a-8003-6ed292a58224"><g class="fills" id="fills-8a3cf441-50d2-801a-8003-6ed292a58224"><path fill-rule="evenodd" clip-rule="evenodd" rx="0" ry="0" d="M15.969,7.061C16.916,4.966,18.207,2.947,19.843,1.004C20.669,-0.072,21.251,-0.142,21.540,1.004C22.036,3.051,21.678,5.838,21.022,8.882C23.617,10.456,24.486,12.770,23.323,15.954C22.356,16.817,21.194,17.525,19.843,18.081C18.598,20.327,17.025,20.791,15.242,20.122C14.105,21.096,12.794,21.688,11.274,21.819C8.206,21.998,6.521,19.914,5.983,15.954C4.748,14.880,3.594,13.779,2.528,12.648C1.861,11.941,1.229,11.223,0.634,10.492C-0.178,9.175,-0.039,8.444,1.986,8.882C4.306,9.213,6.511,9.949,8.678,10.817C9.976,8.305,12.448,7.120,15.969,7.061ZZ" style="fill: rgb(233, 184, 50);"/></g></g><g id="shape-8a3cf441-50d2-801a-8003-6ed292a63981"><g class="fills" id="fills-8a3cf441-50d2-801a-8003-6ed292a63981"><path rx="0" ry="0" d="M0.863,10.367C1.440,11.075,2.068,11.790,2.729,12.490C3.761,13.585,4.914,14.687,6.154,15.766C6.194,15.801,6.220,15.849,6.227,15.902C6.766,19.868,8.413,21.717,11.262,21.550C12.675,21.428,13.961,20.878,15.087,19.914C15.148,19.862,15.232,19.847,15.307,19.876C16.186,20.205,16.949,20.229,17.639,19.949C18.382,19.648,19.048,18.973,19.620,17.943C19.644,17.899,19.682,17.865,19.728,17.846C21.030,17.310,22.160,16.623,23.089,15.804C24.157,12.833,23.432,10.633,20.872,9.080C20.792,9.031,20.751,8.937,20.771,8.845C21.550,5.228,21.709,2.840,21.288,1.102C21.190,0.714,21.051,0.473,20.908,0.444C20.816,0.425,20.543,0.459,19.986,1.184C19.984,1.187,19.982,1.189,19.980,1.192C18.371,3.101,17.084,5.112,16.154,7.170C16.119,7.247,16.043,7.298,15.958,7.299C12.429,7.358,10.117,8.542,8.889,10.919C8.837,11.020,8.717,11.064,8.611,11.022C6.012,9.981,3.972,9.391,1.998,9.109C1.993,9.108,1.988,9.107,1.983,9.106C0.835,8.859,0.555,9.053,0.488,9.148C0.413,9.254,0.362,9.553,0.863,10.367ZZM10.920,22.000C8.080,22.000,6.360,19.998,5.803,16.043C4.575,14.972,3.434,13.879,2.409,12.792C1.737,12.080,1.099,11.353,0.512,10.633C0.506,10.625,0.501,10.618,0.496,10.609C-0.007,9.795,-0.124,9.250,0.129,8.894C0.395,8.518,1.011,8.448,2.068,8.675C4.029,8.956,6.048,9.533,8.592,10.541C9.246,9.356,10.188,8.447,11.394,7.837C12.585,7.235,14.070,6.907,15.811,6.863C16.752,4.813,18.040,2.812,19.640,0.913C20.174,0.218,20.605,-0.068,20.997,0.013C21.331,0.082,21.565,0.404,21.715,0.997C22.147,2.779,21.998,5.185,21.233,8.786C23.870,10.449,24.627,12.878,23.483,16.007C23.471,16.041,23.450,16.072,23.423,16.095C22.467,16.949,21.304,17.664,19.966,18.223C18.791,20.297,17.213,21.005,15.275,20.331C14.100,21.305,12.763,21.863,11.297,21.989C11.295,21.989,11.293,21.989,11.291,21.989C11.166,21.996,11.041,22.000,10.920,22.000ZZ" style="fill: rgb(38, 28, 21);"/></g></g></g></svg>',
			]
		],
		$block_categories,
	);

	return $block_categories;
}
add_filter( 'block_categories_all', 'kks_newsletter_block_categories' );