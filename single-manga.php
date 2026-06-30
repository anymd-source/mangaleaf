<?php 
defined("ABSPATH") || die("!") ;
get_header(); ?>

<?php $images = rwmb_meta( 'ero_cover','type=image&size=full' ); ?>
		<div class="bigcover">
				<?php
				if ( !empty( $images ) ) {
					foreach ( $images as $image ) { ?>
						<div class="bigbanner" style="background-image: url('<?php echo esc_url( $image['url'] ); ?>');"></div>
					<?php }
				} else { ?>
						<div class="bigbanner img-blur" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>
				<?php }
				?>
		</div>


<?php 
	$seriesstyle = get_option('styleseries'); if($seriesstyle==''){ $seriesstyle = '1'; }
	get_template_part('template-parts/series/style',$seriesstyle);
?>

<script>jQuery(document).ready(function(){jQuery.ajax({url:ajaxurl,type:'post',data:{action:'dynamic_view_ajax',post_id:<?php echo get_the_ID();?>},success:function(response){}});});</script>
<?php get_footer(); ?>