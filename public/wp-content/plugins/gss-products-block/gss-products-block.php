<?php

/**
 * Plugin Name:     Gas Servei Products Blocks
 * Plugin URI:      PLUGIN SITE HERE
 * Description:     Gutenberg product block for Gas Servei
 * Author:          mimotic
 * Author URI:      mimotic.com
 * Text Domain:     gss-products-block
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Gss_Products_Block
 */

use Carbon_Fields\Block;
use Carbon_Fields\Field;


class GssProductsBlock
{

    private $title;
    private $description;
    private $limit;
    private $image;

    function __construct()
    {   
        add_action('wp_enqueue_scripts', array($this, 'gss_products_block_enqueue_script'));
        add_action('init', array($this, 'checkCarbonPlugin'));
        add_action('carbon_fields_register_fields', array($this, 'gss_products_block_options'));
    }

    function checkCarbonPlugin(){        
        // Require parent plugin
        if ( ! is_plugin_active( 'carbon-fields/carbon-fields-plugin.php' ) and current_user_can( 'activate_plugins' ) ) {
            add_action( 'admin_notices', array($this, 'gss_child_plugin_notice') );

            deactivate_plugins( plugin_basename( __FILE__ ) );         

            if ( isset( $_GET['activate'] ) ) {
                unset( $_GET['activate'] );
            }
        }
    }


    function gss_child_plugin_notice(){
        ?><div class="error"><p>El plugin "GasServei Products Block" requiere tener instalado y activo el plugin Carbon Fields.</p></div><?php
    }

    function gss_products_block_enqueue_script()
    {
        wp_enqueue_script('gss_products_block_script', plugin_dir_url(__FILE__) . 'js/scripts.js', '', '2', true);
        wp_enqueue_style('gss_products_block_style', 'https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css');
        add_filter('script_loader_tag', array($this, 'gss_add_type_attribute'), 10, 3);
    }

    function gss_add_type_attribute($tag, $handle, $src)
    {
        // if not your script, do nothing and return original $tag
        if ('gss_products_block_script' !== $handle) {
            return $tag;
        }
        // change the script tag by adding type="module" and return it.
        $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        return $tag;
    }

    function gss_products_block_options()
    {

        Block::make('GS Products')
            ->add_fields([
                // Field::make('text', 'title'),
                // Field::make('image', 'image', __('Image')),
                // Field::make('text', 'description'),
                Field::make('text', 'limit')->set_required(true),
                Field::make("select", "categories", "Category")
                    ->add_options(array($this, 'gss_get_product_cats'))
                    ->set_required(true),
            ])
            ->set_render_callback(function ($gsproducts) {
                $this->title = isset($gsproducts['title']) ? $gsproducts['title'] : '';
                $this->image = isset($gsproducts['image']) ? $gsproducts['image'] : '';
                $this->description = isset($gsproducts['description']) ? $gsproducts['description'] : '';
                $this->limit = isset($gsproducts['limit']) ? $gsproducts['limit'] : '';
                
                $category = isset($gsproducts['categories']) ? $gsproducts['categories'] : '';
                $this->category = get_term_by('term_id', $category, 'product_cat');
                $autoWidth = !empty($this->title) && empty($this->image) ? 'autowidth' : '';

                if (!empty($this->image) && !empty($this->title)) {
                    ?>
                    <div class="gss-text-container">
                        <div class="col text-container">
                            <?php $this->renderText(); ?>
                        </div>
                        <div class="col image">
                            <?php $this->renderImage(); ?>
                        </div>
                    </div>


                    <?php
                }


            ?>
            <div class="gss-slider-container <?php echo $autoWidth; ?>">
                <div class="arrow"><?php echo __('swipe', 'gasservei');  ?></div>
                <div class="gss-slider">

                    <?php

                    if (!empty($this->title) && empty($this->image)) {
                        $this->renderText();
                    }
                    if (!empty($this->category)) {
                        $this->renderProducts();
                    }

                    ?>
                    <?php
                   

                    ?>
                </div>
            </div>

<?php

            });
    }


    public function gss_get_product_cats()
    {
        $categories = get_terms('product_cat', 'orderby=name&hide_empty=0');
        $cats = array();

        if ($categories) {
            foreach ($categories as $cat) {
                $cats[$cat->term_id] = esc_html($cat->name);
            }
        }
        return $cats;
    }

    public function renderProducts()
    {
        $subcategories = get_terms(
            array(
                'taxonomy' => 'product_cat',
                'child_of' => $this->category->term_id,
                'hide_empty' => false,
            )
        );
        $all_cats = $this->category->slug;

        foreach ($subcategories as $subcat) {
            $all_cats .= ',' . $subcat->slug;
        }
        $products_args = [
            'post_type' => 'product',
            'limit' => $this->limit,
            'post_status' => 'publish',
            'product_cat' => $all_cats,
        ];
        $wc_query = new WP_Query($products_args);
        if ($wc_query->have_posts()) :
            while ($wc_query->have_posts()) : $wc_query->the_post();
                global $product;
                $class = $product->is_on_sale() ? 'onsale' : '';
                $product_categories = get_the_terms($product->get_id(), 'product_cat');
        ?>
                <div>
                    <div class="product product-box <?php echo $class; ?>">
                    <?php 
                        if($product->is_on_sale()){
                            echo "<div class='onsale'>" . __('Offer', 'gasservei') . "</div>";
                        }
                    ?>
                        <a draggable="false" href="<?php echo $product->get_permalink(); ?>">
                            <div class="image">
                                <?php                                 
                                $image = wp_get_attachment_image($product->get_image_id(), 'woocommerce_thumbnail');
                                if (!empty($image)){
                                    echo $image;
                                }else{
                                    echo '<img src="'. wc_placeholder_img_src() .'" alt="default image">';
                                }
                                 ?>
                            </div>
                        </a>
                        <a draggable="false" href="<?php echo $product->get_permalink(); ?>">
                            <div class="title"><?php echo $product->get_title(); ?></div>
                        </a>
                        <a draggable="false" href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>" class="view-product"><?php _e('View product', 'gasservei'); ?> </a>
                    </div>
                </div>
        <?php
            endwhile;
        endif;

        wp_reset_postdata();
    }
    public function renderImage()
    {
        
        $image = wp_get_attachment_metadata($this->image);
        if(wp_check_filetype($image['file'])['type'] == 'image/svg+xml'){
            echo file_get_contents(wp_get_attachment_url($this->image));
        }else{
            echo wp_get_attachment_image( $this->image, array('700', '600'), "", array( "class" => "img-responsive" ) ); 
        }
    }
    public function renderText()
    {
        ?>

        <div>
            <div class="text-slide">
                <div class="cats category"> <?php echo "<a class='category' href='" . get_term_link($this->category->term_id, 'product_cat') . "'>" .  $this->category->name  . "</a>"; ?></div>
                <h2><?php echo $this->title  ?></h2>
                <p><?php echo esc_html( $this->description ) ?></p>
                <?php echo "<a class='btn line-btn' href='" . get_term_link($this->category->term_id, 'product_cat') . "'>" . sprintf(__('%s Products', 'gasservei'), $this->category->name) . "</a>"; ?>

            </div>
        </div>

        <?php
    }
}
new GssProductsBlock;
