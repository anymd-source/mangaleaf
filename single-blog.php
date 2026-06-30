<?php get_header(); ?>
<div class="pd-expand"></div>
<div class="postbody">
	<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> hentry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<?php wpb_set_post_views(get_the_ID()); ?>
		<div class="bixbox blogpost">
			<header class="entry-header">
				<h1 class="entry-title" itemprop="headline">
						<?php the_title(); ?>
				</h1>
				<div class="entry-meta">
					<span class="author vcard"><i class="far fa-user"></i> <b><?php echo GOV_lang::get('series_info_posted_by_label')?>:</b> <i class="fn"><?php $author_id = get_post_field( 'post_author', get_the_ID() ); echo get_the_author_meta('display_name', $author_id); ?></i></span> · 
					<span><i class="far fa-calendar-alt"></i> <b><?php echo GOV_lang::get('series_info_posted_on_label');?>:</b> <time itemprop="datePublished" datetime="<?php the_time('c'); ?>" class="updated"><?php the_time('F j, Y'); ?></time></span>
				<span class="hide"><time itemprop="dateModified" datetime="<?php the_modified_date('c'); ?>"><?php the_modified_date('F j, Y'); ?></time></span>
				<?php echo get_the_term_list( get_the_ID(), 'post_tag', ' · <span><i class="fa fa-tags" aria-hidden="true"></i> <b>Tags:</b> ', ', ', '</span>' ); ?>
				</div>
			</header>
			<?php if(get_option('blogfeatured')=='1'){
			if(has_post_thumbnail()){ ?>
			<div class="thumb">
				<?php the_post_thumbnail('',array('itemprop'=>'image')); ?>
			</div>
			<?php } } ?>
			<div class="entry-content" itemprop="text">
				<?php the_content(); ?>
			</div>
			<?php get_template_part('template-parts/general/social-share'); ?>
		</div>
		<?php endwhile; endif; ?>
		
		<?php
		$metas = get_the_ID();
		$args=array(
		'post_type' => 'blog',
		'post__not_in' => array($metas),
		'posts_per_page'=> 3,
		'orderby' => 'rand',
		'ignore_sticky_posts'=>1
		);
		$my_query = new wp_query( $args );
		if( $my_query->have_posts() ) { ?>
		<div class="bixbox">
			<div class="releases"><h2><?php echo GOV_lang::get('related_blog_label');?></h2></div>
			<div class="bloglist">
				<?php while( $my_query->have_posts() ) { $my_query->the_post(); get_template_part('template-parts/general/main','blog'); } ?>
			</div>
		</div>
		<?php } wp_reset_query(); ?>
		
		<div id="comments" class="bixbox comments-area">
			<div class="releases"><h2><span><?php echo GOV_lang::get('comment_label');?></span></h2></div>
			<div class="cmt commentx">
				<?php if ( comments_open() || get_comments_number() ) : comments_template(); endif; ?>
			</div>
		</div>
	</article>
</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>