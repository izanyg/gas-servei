<?php
/**
 * Plugin Name:       Bloque Categories para Gutenberg
 * Description:       Bloque de Gutenberg creado exprofeso para Gas Servei
 * Requires at least: 5.8
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            Mimotic
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       categories
 *
 * @package           mimotic
 */

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function mimotic_categories_block_init() {
	register_block_type( 
		__DIR__ . '/build', 
		array(
			'render_callback' => 'mimotic_categories_render_callback'
		) 
	);
}
add_action( 'init', 'mimotic_categories_block_init' );


function mimotic_categories_render_callback( $block_attributes, $block_content){
	$return = '<p class="wp-block-gss-categories">'. $block_content . '</p>';

	$terms = get_terms(['taxonomy' => 'product_cat','hide_empty' => false, 'parent' => 0]);

	ob_start();
	?>

	<h2 class="wp-block-gss-categories"><?php echo $block_content; ?></h2>
	<div class="wp-block-mimotic-categories-container">
		<?php
		foreach ($terms as $term):
			$subterms = get_terms(['taxonomy' => 'product_cat','hide_empty' => false, 'parent' => $term->term_id]);
			foreach ($subterms as $subterm):
				$thumbnail_id = get_term_meta($subterm->term_id, 'thumbnail_id', true);
				$image = wp_get_attachment_url( $thumbnail_id ) ? wp_get_attachment_url( $thumbnail_id ) : plugin_dir_url( __FILE__ ) . '/images/default.jpg';
				?>
				<a class="category" href="<?php echo get_term_link( $subterm->term_id, 'product_cat'); ?>">
					<div class="image"><img src="<?php echo $image; ?>" alt="<?php echo $subterm->name; ?>"></div>
					<div class="title"><?php echo $subterm->name; ?></div>
			</a>
				<?php
			endforeach;
		endforeach;
		?>
	</div>

	<?php
	
	$return = ob_get_contents();
	ob_end_clean();
	return $return;
}