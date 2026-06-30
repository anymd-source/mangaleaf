<?php get_header(); remove_action( 'pre_get_posts', 'reorder_tax' ); ?>
<div class="postbody">
<div class="bixbox seriesearch">
	<div class="releases"><h1><?php echo GOV_lang::get('advanced_search_manga_list_label'); ?></h1></div>
	<div class="mrgn">
		<?php echo do_shortcode('[lists]'); ?>
	</div>
	<div class="clear"></div>
</div>
<?php get_sidebar(); ?>
<script>$(".section .quickfilter").parent().remove()</script>
<?php get_footer(); ?>