<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
get_header('shop');
?>

<div id="page-header">
<?php 
    global $wp_query;
    // get the query object
    $cat = $wp_query->get_queried_object();
    // get the thumbnail id user the term_id
    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true ); 
    // get the image URL
    $image = wp_get_attachment_url( $thumbnail_id ); 
    // print the IMG HTML
    if ($image)
    echo '<img src="'.$image.'" alt="" width="960" height="200" class="cat-header" />';

?>
<?php woocommerce_breadcrumb(); ?>
<h1 class="page-title">
 
    <?php if (is_search()) : ?>
        <?php
        printf(__('Search Results: &ldquo;%s&rdquo;', 'woocommerce'), get_search_query());
        if (get_query_var('paged'))
            printf(__('&nbsp;&ndash; Page %s', 'woocommerce'), get_query_var('paged'));
        ?>
    <?php elseif (is_tax()) : ?>
        <?php echo single_term_title("", false); ?>
    <?php else : ?>
        <?php
        $shop_page = get_post(woocommerce_get_page_id('shop'));

        echo apply_filters('the_title', ( $shop_page_title = get_option('woocommerce_shop_page_title') ) ? $shop_page_title : $shop_page->post_title );
        ?>
    <?php endif; ?>
</h1>

<?php do_action('woocommerce_archive_description'); ?>


<?php if (is_tax()) : ?>
    <?php do_action('woocommerce_taxonomy_archive_description'); ?>
<?php elseif (!empty($shop_page) && is_object($shop_page)) : ?>
    <?php do_action('woocommerce_product_archive_description', $shop_page); ?>
<?php endif; ?>
</div>
<?php
/**
 * woocommerce_before_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 */
do_action('woocommerce_before_main_content');
?>

<h2>Products</h2>





   <div id="top-bar" role="complementary">
<?php
if ( is_active_sidebar( 'horizontal_widget' ) ) :
			dynamic_sidebar( 'horizontal_widget' );
else :
    ?>
<?php endif; ?></div>


<?php if (have_posts()) : ?>

    <?php do_action('woocommerce_before_shop_loop'); ?>

    <ul class="products">

        <?php woocommerce_product_subcategories(); ?>

        <?php while (have_posts()) : the_post(); ?>

            <?php woocommerce_get_template_part('content', 'product'); ?>

        <?php endwhile; // end of the loop. ?>

    </ul>

    <?php do_action('woocommerce_after_shop_loop'); ?>

<?php else : ?>

    <?php if (!woocommerce_product_subcategories(array('before' => '<ul class="products">', 'after' => '</ul>'))) : ?>

        <p><?php _e('No products found which match your selection.', 'woocommerce'); ?></p>

    <?php endif; ?>

<?php endif; ?>

<div class="clear"></div>

<?php
/**
 * woocommerce_pagination hook
 *
 * @hooked woocommerce_pagination - 10
 * @hooked woocommerce_catalog_ordering - 20
 */
do_action('woocommerce_pagination');
?>

<?php
/**
 * woocommerce_after_main_content hook
 *
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action('woocommerce_after_main_content');
?>

<?php
/**
 * woocommerce_sidebar hook
 *
 * @hooked woocommerce_get_sidebar - 10
 */
do_action('woocommerce_sidebar');
?>

<?php get_footer('shop'); ?>
