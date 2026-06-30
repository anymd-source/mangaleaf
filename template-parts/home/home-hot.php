<?php $gpt = get_option('thotupdate'); if($gpt){ ?>
<div class="hotslid">
<div class="bixbox hothome full">
		<div class="releases">
			<h2><?php echo GOV_lang::get('home_hot_series_update_label'); ?></h2>
		</div>
		<div class="listupd">
		<?php 
		$featured = new WP_Query(array(
			'post_status' => 'publish',
			'post_type' => 'manga',
			'meta_key' => 'ts_today_view_count',
			'orderby' => 'meta_value_num',
			'order' => 'DESC',
			"showposts"     => $gpt,
			"ignore_sticky_posts" => 1,
			"no_found_rows"  => true,
			"update_post_term_cache" => false,
		)); 
		while($featured->have_posts()) : 
			$featured->the_post(); 
			get_template_part('template-parts/general/main'); 
		endwhile; ?>
		</div>
	</div>
</div>
<?php } ?>