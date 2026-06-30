<?php 
$seriesid = get_post_meta(get_the_ID(),'ero_seri',true);
$latest = get_post_meta(get_the_ID(),'ero_chapter',true);
?>
<div class="bs">
	<div class="bsx">
		
		<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
		<div class="limit">
			<div class="ply"></div>
			<?php $type = rwmb_get_value( 'ero_type', '',$seriesid ); if($type){ ?><span class="type <?php echo $type; ?>"><?php rwmb_the_value('ero_type','',$seriesid); ?></span><?php } ?>
			<?php if(has_post_thumbnail()){ echo thumb_photon(get_the_ID(),'145','205'); } else { echo thumb_photon($seriesid,'145','205'); } ?>
		</div>
		<div class="bigor">
			<div class="tt">
				<?php echo get_the_title($seriesid); ?>
			</div>
			<div class="adds">
				<div class="epxs"><?php echo GOV_lang::get('widget_chapter_label'); ?> <?php echo $latest; ?></div>
			</div>
		</div>
		</a>
	</div>
</div>