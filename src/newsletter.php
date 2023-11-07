<?php /**
     * Block template file: tooling.php
     *
     * Tooling Block Template.
     *
     * @param   array $block The block settings and attributes.
     * @param   string $content The block inner HTML (empty).
     * @param   bool $is_preview True during AJAX preview.
     * @param   (int|string) $post_id The post ID this block is saved to.
     */

  // Create id attribute allowing for custom "anchor" value.

    $id = 'newsletter-list-' . $block['id'];
    if ( ! empty($block['anchor'] ) ) {
        $id = $block['anchor'];
    }

    // Create class attribute allowing for custom "className" and "align" values.
    $classes = 'block-newsletter-list';
    if ( ! empty( $block['className'] ) ) {
        $classes .= ' ' . $block['className'];
    }
    if ( ! empty( $block['align'] ) ) {
        $classes .= ' align' . $block['align'];
    }
    ?>

    <style>
        <?php echo '#' . $id; ?> {
        /* Add styles that use ACF values here */
        }
    </style>
    
    <?php 
     $wrapper_attributes = get_block_wrapper_attributes(
        [
            'class' => 'newsletter'
        ]
    );

   /**
    * Newsletter List
    * This list contains each newsletter's name and URL.
    */
?>

<section <?= $wrapper_attributes; ?>>

    <div class="newsletter__container">
        <div class="newsletter__list">
            <?php 
                if ( have_rows( 'newsletter_list' ) ) : 
                while ( have_rows( 'newsletter_list' ) ) : the_row(); 
                    $newsletter_name    = get_sub_field( 'newsletter_name' );
                    $newsletter_url     = get_sub_field( 'newsletter_url' );
            ?>
                <div class="newsletter__item">
                    <a href="<?= $newsletter_url; ?>" target="_blank">
                        <?= $newsletter_name; ?>
                    </a>
                </div>
            <?php
                endwhile;
                else :
                    // No rows found
                endif;
            ?>
        </div>
    </div>

</section>
    

<?php
        endwhile;
    else :
        // No rows found
    endif;