<?php
/**
 * Partial template for pagination.
 * Creates numbered pagination or displays button for infinite scroll based on user selection
 *
 * @since 1.0.0
 */
global $themify;
$isFinity =   isset($themify->infinity_count) && $themify->infinity_count > 0;
if($isFinity===false){
    $isFinity =  get_post_type()==='portfolio'?themify_get('portfolio_more_posts'):themify_get('setting-more_posts',false,true);
    $isFinity=$isFinity==='infinite';
}

if ($isFinity===true && 'slider' !== $themify->post_layout) {

    if ($themify->infinity_count > 0) {
        $total_pages = $themify->infinity_count;
        $current_page = !empty($_GET['action']) && 'themify_shortcode_infinity'===$_GET['action'] && !empty($_GET['paging'])?$_GET['paging']:get_query_var('paging', 1);
        $class=' load-more-show';
    } else {
        global $wp_query;
	$class = '';
        $total_pages = $wp_query->max_num_pages;
        $current_page = is_front_page() ? get_query_var('page', 1) : get_query_var('paged', 1);
    }
    if (!$current_page) {
        $current_page = 1;
    }
    if ($total_pages > $current_page) {
        $url = $themify->infinity_count > 0 ? add_query_arg(array('paging' => $current_page+1, 'query' => $themify->infinity_query, 'action' => 'themify_shortcode_infinity'), admin_url('admin-ajax.php')) : next_posts($total_pages, false);
        Themify_Enqueue_Assets::loadinfiniteCss();
        echo '<p id="load-more" class="tf_textc tf_clear'.$class.'"><a href="' . $url . '" class="load-more-button">' . __( 'Load More', 'themify' ) . '</a><span></span></p>';
    }
    $total_pages=null;
} else {
    if ('numbered' === themify_get('setting-entries_nav','numbered',true)) {
        themify_pagenav();
    } else {
        ?>
        <div class="post-nav">
            <span class="prev"><?php next_posts_link(__('&laquo; Older Entries', 'themify')) ?></span>
            <span class="next"><?php previous_posts_link(__('Newer Entries &raquo;', 'themify')) ?></span>
        </div>
        <?php
    }
} // infinite