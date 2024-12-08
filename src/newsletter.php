<?php 
/**
 * Block template file: newsletter.php
 *
 * Kks/kks News Viewer Block Template with MailerLite.
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

<a href="#news-frame" class="skip-link screen-reader-text">
    Skip to newsletter content
</a>   
<section <?= $wrapper_attributes; ?> aria-label="Newsletter Display"> 
    <div class="kks-news-list-column" role="navigation" aria-label="Newsletter List">
        <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($classes); ?>">
            <ul role="list">
                <?php 
                if (have_rows('stem_newsletter_list')) :
                    while (have_rows('stem_newsletter_list')) : the_row();
                        $news_source = get_sub_field('news_source');
                        $news_name = get_sub_field('newsletter_name');
                        $news_url = get_sub_field('newsletter_url');
                ?>
                        <li class="news-links">
                            <span class="badge" role="text" aria-label="Category: <?php echo esc_attr($news_source); ?>">
                                <?php echo esc_html($news_source); ?>
                            </span>
                            <a href="<?= esc_url($news_url); ?>" 
                               target="news-frame"
                               class="link-item"
                               aria-label="Open <?php echo esc_attr($news_name); ?> newsletter">
                                <?= esc_html($news_name); ?>
                            </a>
                        </li>
                <?php
                    endwhile;
                else :
                    echo '<li role="alert">No newsletters available</li>';
                endif; 
                ?>
            </ul>
        </div>
    </div>

    <div class="kks-news-issue-column">
        <figure class="iframe-container">
            <iframe class="iframe" 
                    name="news-frame" 
                    loading="lazy" 
                    src="" 
                    frameborder="0" 
                    scrolling="yes"
                    title="Newsletter Content"
                    aria-label="Selected newsletter content will display here">
            </iframe>
        </figure>
    </div>
</section>

<!-- https://github.com/VFDouglas/HTML-Order-Table-By-Column -->
