<?php get_header(); ?>
<div class="postbody">
<div class="bixbox">
	<?php if (have_posts()) : ?>
	<div class="releases"><h1>Blogs</h1></div>
	<div class="bloglist">
			<?php while ( have_posts() ) : the_post(); get_template_part('template-parts/general/main','blog'); endwhile; ?>
	</div>	
	<div class="pagination">
			<?php echo paginate_links(); ?>  
		</div>
	<?php endif; ?>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>