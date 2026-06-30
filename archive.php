<?php get_header(); ?>
<div class="postbody full">
<div class="bixbox">
	<?php if (have_posts()) : ?>
	<div class="releases"><h1><?php single_tag_title(); ?></h1></div>
	<div class="listupd">
			<?php while ( have_posts() ) : the_post(); get_template_part('template-parts/general/main'); endwhile; ?>
	</div>	
	<div class="pagination">
			<?php echo paginate_links(); ?>  
		</div>
	<?php endif; ?>
</div>
</div>
<?php get_footer(); ?>