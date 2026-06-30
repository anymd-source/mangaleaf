<?php 
defined("ABSPATH") || die("!");
get_header(); 
?>

<?php get_template_part('template-parts/home/home','hot'); ?>

<div class="postbody">
	<?php get_template_part('template-parts/home/home','project'); ?>
	<?php get_template_part('template-parts/home/home','latest'); ?>
	<?php echo do_shortcode(get_option('schome')); ?>
	<?php get_template_part('template-parts/home/home','random-genres'); ?>
	<?php get_template_part('template-parts/home/home','blog'); ?>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>