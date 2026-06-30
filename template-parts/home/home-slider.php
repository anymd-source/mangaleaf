<?php
GOV_cache::fragment_cache("home_slider", 86400, function () {
$gpt = get_option('sliderx');if ($gpt) {?>
<div class="big-slider swiper-container">
	<div class="swiper-wrapper">
	<?php
	$featured = new WP_Query( 
		array( 
			'post_type' => 'manga',
			'showposts' => 10,
			'meta_key' => 'ero_slider',
			'meta_value' => 1,
			'orderby' =>  'rand',
			'no_found_rows' => 'true',
			'ignore_sticky_posts' => 1
		) ); if ($featured->have_posts()) : while ( $featured->have_posts() ) : $featured->the_post();
	?>
		<div class="swiper-slide">
			<a href="<?php the_permalink(); ?>">
			<div class="mainslider">
				<div class="limit">
					<div class="sliderinfo">
						<div class="sliderinfolimit">
							<span class="name"><?php the_title(); ?></span>
							<div class="meta">
								<?php $score = rwmb_get_value( 'ero_score' ); if($score){ ?>
									<span class="quality">
										<?php echo $score; ?>
									</span>
								<?php } ?>
								<?php $meta = rwmb_get_value( 'ero_type' ); if($meta){ ?>
									<span class="text">
										<?php echo GOV_lang::get('series_info_type_label')?>: <b><?php rwmb_the_value('ero_type'); ?></b>
									</span>
								<?php } ?>
								<span class="text"><?php echo GOV_lang::get('series_info_genres_label'); ?>: <?php echo strip_tags(get_the_term_list(get_the_ID(), 'genres', '', ', ', '')); ?></span>
							</div>
							<div class="desc"><?php the_excerpt(); ?></div>
						</div>
					</div>
					<?php $images = rwmb_meta( 'ero_cover',array( 'size' => 'full' ) ); 
					if ( !empty( $images ) ) {
					foreach ( $images as $image ) { ?>
						<div class="bigbanner" style="background-image: url('<?php echo esc_url( $image['url'] ); ?>');"></div>
					<?php }
				} else { ?>
						<div class="bigbanner img-blur" style="background-image: url('<?php echo get_the_post_thumbnail_url(); ?>');"></div>
				<?php } ?>
				</div>
			</div>
			</a>
		</div>
	<?php endwhile; endif; ?>
	</div>
	<div class="paging">
		<div class="centerpaging">
			<div class="swiper-pagination"></div>
		</div>
	</div>
</div>
<?php
$gpt = get_option('homegenre');if ($gpt) { $slugseries = get_option('changeslug'); if($slugseries===''){ $slugseries = 'manga'; } ?>
<div class="home-genres">
	<span class="genre-listx">
		<?php
			$taxonomy = 'genres';
			$tax_terms = get_terms($taxonomy, 'number=8');
			foreach ($tax_terms as $tax_term) {
				echo '<a href="' . esc_attr(get_term_link($tax_term, $taxonomy)) . '" title="' . sprintf(__("View all series in %s"), $tax_term->name) . '" ' . '>' . $tax_term->name . '</a>';
			}
		?>
	</span>
	<span class="alman">
		<a href="<?php echo home_url(); ?>/<?php echo $slugseries; ?>"><?php echo GOV_lang::get('home_genre_label')?></a>
	</span>
</div>
<?php } } } ); ?>