<article class="blogbox hentry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
	<div class="innerblog">
		<div class="thumb">
			<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" itemprop="url">
				<?php the_post_thumbnail('thumbnail',array('itemprop' => 'image','title' => get_the_title())); ?>
			</a>
		</div>
		<div class="infoblog">
			<header class="entry-header">
				<h2 class="entry-title" itemprop="headline">
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" itemprop="url">
						<?php the_title(); ?>
					</a>
				</h2>
				<div class="entry-meta">
					<span class="author vcard"><b><?php echo GOV_lang::get('series_info_posted_by_label')?>:</b> <i class="fn"><?php $author_id = get_post_field( 'post_author', get_the_ID() ); echo get_the_author_meta('display_name', $author_id); ?></i></span> · 
					<span><b><?php echo GOV_lang::get('series_info_posted_on_label');?>:</b> <time itemprop="datePublished" datetime="<?php the_time('c'); ?>" class="updated"><?php the_time('F j, Y'); ?></time></span>
				<span class="hide"><time itemprop="dateModified" datetime="<?php the_modified_date('c'); ?>"><?php the_modified_date('F j, Y'); ?></time></span>
				<?php echo get_the_term_list( get_the_ID(), 'post_tag', ' · <span>', ', ', '</span>' ); ?>
				</div>
			</header>
			<div class="entry-content" itemprop="text">
				<?php the_excerpt(); ?>
			</div>
		</div>
	</div>
</article>