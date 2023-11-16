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
       
<section <?= $wrapper_attributes; ?>> <!-- class="newsletter wp-block-kks-kks-newsletter" -->



    <div class="kks-news-list-column" >

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
                            <span class=""><?php echo $news_source . ": " ?></span>
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
    <div class="kks-news-issue-column" >
        <figure class="iframe-container">
            <iframe class="iframe" name="news-frame" loading="lazy" src="" frameborder="0" scrolling="yes"></iframe>
        </figure>
    
</section>

<!-- https://github.com/VFDouglas/HTML-Order-Table-By-Column -->
