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
$id = 'kks/kks-newsletter-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'block-kks/kks-newsletter';
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
    

    <div class="wp-block-column wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="flex-basis:33.33%; ">

        

        <div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
        
            <table>
            <thead>
                <tr>
                    <th padding="1rem;">Type <span>&uarr;</span></th>
                    <th padding="1rem;">Year <span>&uarr;</span></th>
                    <th padding="1rem;">Name <span>&uarr;</span></th>
                </tr>
            </thead>

            <tbody>
                <?php 

                if (have_rows('stem_newsletter_list')) :
                    while (have_rows('stem_newsletter_list')) : the_row();
                        $news_source    = get_sub_field( 'news_source' );
                        $stem_year      = (int)get_sub_field('year');
                        $news_name      = get_sub_field('newsletter_name');
                        $news_url       = get_sub_field('newsletter_url');

                        ($news_source === 'stemtech') ? $source = 'STEM Tech' : $source = 'Coding';
                ?>
                        <tr>
                            <td class="type"><?php echo  $source; ?></td>
                            <td class="year"><?php echo esc_attr( $stem_year ); ?></td>
                            <td class="url">
                                <a href="<?php echo esc_url( $news_url ); ?>" 
                                target="news-frame">
                                <?php echo esc_textarea( $news_name ); ?>
                                </a>
                            </td>
                        </tr>

                    <?php
                        endwhile;
                    else :
                        // No rows found
                    endif; ?>
                </tbody>
                <caption>Kool Kat Science Newsletter listings</caption>
            </table>
                
        </div>

    </div>
    <div class="wp-block-column wp-block-column is-layout-flow wp-block-column-is-layout-flow" style="display:flex; flex-basis:66.66%; ">
        <figure class="iframe-container">
            <iframe name="news-frame" loading="lazy" src="" frameborder="0" scrolling="yes"></iframe>
        </figure>
    </div>
</section>

<!-- https://github.com/VFDouglas/HTML-Order-Table-By-Column -->
<script>
	window.onload = function() {
		document.querySelectorAll('th').forEach((element) => { // Table headers
			element.addEventListener('click', function() {
				let table = this.closest('table');

				// If the column is sortable
				if (this.querySelector('span')) {
					let order_icon = this.querySelector('span');
					let order      = encodeURI(order_icon.innerHTML).includes('%E2%86%91') ? 'desc' : 'asc';
					let separator  = '-----'; // Separate the value of it's index, so data keeps intact

					let value_list = {}; // <tr> Object
					let obj_key    = []; // Values of selected column

					let string_count = 0;
					let number_count = 0;

					// <tbody> rows
					table.querySelectorAll('tbody tr').forEach((line, index_line) => {
						// Value of each field
						let key = line.children[element.cellIndex].textContent.toUpperCase();

						// Check if value is date, numeric or string
						if (line.children[element.cellIndex].hasAttribute('data-timestamp')) {
							// if value is date, we store it's timestamp, so we can sort like a number
							key = line.children[element.cellIndex].getAttribute('data-timestamp');
						}
						else if (key.replace('-', '').match(/^[0-9,.]*$/g)) {
							number_count++;
						}
						else {
							string_count++;
						}

						value_list[key + separator + index_line] = line.outerHTML.replace(/(\t)|(\n)/g, ''); // Adding <tr> to object
						obj_key.push(key + separator + index_line);
					});
					if (string_count === 0) { // If all values are numeric
						obj_key.sort(function(a, b) {
							return a.split(separator)[0] - b.split(separator)[0];
						});
					}
					else {
						obj_key.sort();
					}

					if (order === 'desc') {
						obj_key.reverse();
						order_icon.innerHTML = '&darr;';
					}
					else {
						order_icon.innerHTML = '&uarr;';
					}

					let html = '';
					obj_key.forEach(function(chave) {
						html += value_list[chave];
					});
					table.getElementsByTagName('tbody')[0].innerHTML = html;
				}
			});
		});
	}
</script>
