<?php 
/**
 * Block template file: newsletter.php
 *
 * Kks/kks Newsletter Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */


    // Create id attribute allowing for custom "anchor" value.

    $id = 'newsletter-' . $block['id'];
    if ( ! empty($block['anchor'] ) ) {
        $id = $block['anchor'];
    }


// Create id attribute allowing for custom "anchor" value.
$id = 'kks-newsletter-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-kks';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

?>
<style type="text/css">
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
?>
       
<section <?= $wrapper_attributes; ?>>

<div class="wp-block-columns is-layout-flex wp-container-core-columns-layout-3 wp-block-columns-is-layout-flex">

    <div class="wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:33.33%">

        <div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">

           
            <ul>
        
                <?php 

                if (have_rows('stem_newsletter_list')) :
                    while (have_rows('stem_newsletter_list')) : the_row();
                        $news_source    = get_sub_field( 'news_source' );
                        $news_name      = get_sub_field('newsletter_name');
                        $news_url       = get_sub_field('newsletter_url');
                ?>
                    
                        <li class="news-links">
                            <?php echo $news_source . ": " ?>
                        <a href="<?= esc_url( $news_url ); ?>" target="news-frame" class="" >
                                <?= esc_textarea( $news_name ); ?></a>
                        </li>


                    <?php
                        endwhile;
                    else :
                        // No rows found
                    endif; ?>
                </ul>
                
        </div>

    </div>
    <div class="wp-block-column .kks-news-issue-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:66.66%">
        <figure class="iframe-container">
            <iframe name="news-frame" loading="lazy" src="" frameborder="0" scrolling="yes"></iframe>
        </figure>
    </div>
</section>

<!-- https://github.com/VFDouglas/HTML-Order-Table-By-Column -->
