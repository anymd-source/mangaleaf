<?php if(get_option('homeblog')){ $totalblog = get_option('homeblogtotal'); ?>
<div class="bixbox">
		<div class="releases blog"><h3><?php echo GOV_lang::get('home_blog_release_label');?></h3><a class="vl" href="<?php bloginfo('url'); ?>/blog/"><?php echo GOV_lang::get('view_all_label');?></a></div>
		<div class="bloglist">
		<?php $featured = new WP_Query(array(
					"post_type"  => "blog",
					"showposts"     => $totalblog,
					"ignore_sticky_posts" => 1,
					"no_found_rows"  => true,
					"update_post_term_cache" => false,
					"update_post_meta_cache" => false,
					"cache_results" => false
				)); while($featured->have_posts()) : $featured->the_post();
					get_template_part('template-parts/general/main','blog');  						
				endwhile; ?>
		</div>
</div>
<?php } ?>