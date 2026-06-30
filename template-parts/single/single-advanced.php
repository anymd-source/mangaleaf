<?php 
defined("ABSPATH") || die("!");
$servers = $readerClass->get_sources();

?>

<div class="chapterbody">
	<div class="postarea">
		<article id="post-<?php the_ID(); ?>" class="post-<?php the_ID(); ?> hentry" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">
			<?php 
			$meta = get_post_meta( get_the_ID(), 'ero_seri', true ); 
			$theHISTORY = [
				"manga_ID" => $meta,
				"manga_title" => get_the_title($meta),
				"chapter_ID" => get_the_ID(),
				"chapter_title" => get_the_title(),
				"chapter_permalink" => get_the_permalink(),
			];
			if (have_posts()) : while (have_posts()) : the_post(); ?>
			<div class="headpost">
				<h1 class="entry-title" itemprop="name"><?php the_title(); ?></h1>
				<div class="allc"><?php echo GOV_lang::get('chapter_to_chapter_list_link', ["link" => get_permalink($meta), "text" => get_the_title($meta)]);?></div>
			</div>
			<?php if(get_option('singlesocial')=='1'){ get_template_part('template-parts/general/social-share'); } ?>
			<?php breadcrumb_ts(); ?>
			
			<div class="entry-content entry-content-single maincontent" itemprop="description">
				<div class="chdesc">
					<p>
					<?php 
					echo GOV_lang::get('chapter_before_readerarea_text', [
						"manga_title" => $theHISTORY['manga_title'],
						"chapter_title" => $theHISTORY['chapter_title'],
						"blogname" => get_bloginfo('name')
					]);?>
					</p>
				</div>
				
				<div class="chnav ctop<?php if (sizeof($servers) <= 1){ echo ' nomirror'; } ?>">
					<span class="selector slc l"><?php nv($theHISTORY['manga_ID'] ,2000,'DESC'); ?></span>
					<span class="navrig">
					<?php if (sizeof($servers) > 1){ ?>
						<span class="selector mirror l">
							<select name="mirror" id="mirror" class="mirror-selector">
								<?php foreach($servers as $k => $v){ if ( ! isset($v['source'])) continue; ?>
									<option value="<?php echo $readerClass->removeNonAlphaNum($v['source']); ?>"><?php echo $v['source']; ?></option>
								<?php } ?>
							</select>
						</span>
					<?php } ?>
						<?php $rmode = get_option('readingmode'); ?>
						<span class="selector readingmode l">
							<select name="readingmode" id="readingmode">
								<option value="full"<?php if($rmode=='full'){ echo ' selected="selected"'; }?>><?php echo GOV_lang::get('reading_mode_full_label');?></option>
								<option value="single"<?php if($rmode=='single'){ echo ' selected="selected"'; }?>><?php echo GOV_lang::get('reading_mode_single_label');?></option>
							</select>
						</span>
					</span>
					<?php $dl = get_chdl(get_the_ID()); ?>
					<span class="navlef">
						<span class="npv r"><?php nextprev(); ?></span>

						<span class="amob<?php if(!$dl){ echo ' nodlx'; } ?>">
							<span class="selector pagedsel r">
								<select name="select-paged" class="ts-select-paged" id="select-paged">
									<option value="1">?/?</option>
								</select>
							</span>
						</span>
						<?php if($dl){ echo '<span class="dlx r"><a href="'.$dl.'" target="_blank"><i class="fas fa-cloud-download-alt"></i> ' .GOV_lang::get('chapter_download_label'). '</a></span>'; } ?>
					</span>
				</div>
				
				<?php $ga = get_post_meta($meta,'ero_ga',true); if($ga!='1'){ $kln = get_option('reader1');if($kln){ echo '<div class="kln">'.$kln.'</div>'; } } ?>
				
				<div id="readerarea"><?php echo $readerClass->no_script_content(); ?></div>
				<div id="readerarea-loading" style="text-align: center;">
					<img src="<?php echo $readerClass->get_assets_url("assets/img/readerarea.svg");?>" />
				</div>
				<?php if($ga!='1'){ $kln = get_option('reader2');if($kln){ echo '<div class="kln">'.$kln.'</div>'; } } ?>
				
				<div class="chnav cbot">
					<span class="selector slc l"><?php nv($theHISTORY['manga_ID'] ,1000,'DESC'); ?></span>
					<span class="amob">
						<span class="npv r"><?php nextprev(); ?></span>

						<!-- muncul jika single mode -->
						<span class="selector pagedsel r">
							<select name="select-paged" class="ts-select-paged" id="select-paged">
								<option value="">?/?</option>
							</select>
						</span>
					</span>
				</div>
				
			<?php endwhile; endif; ?>
			</div>	
			
			<div class="chaptertags">
			<p><?php echo GOV_lang::get('readerarea_tags_label');?> <?php echo GOV_lang::get('chapter_after_readerarea_tags', ["chapter_title" => $theHISTORY['chapter_title']]);?>, 
			<time class="entry-date" datetime="<?php the_time('Y-m-dTH:i:sO'); ?>" itemprop="datePublished" pubdate><?php the_time( get_option( 'date_format' ) ); ?></time>, <span itemprop="author"><?php the_author(); ?></span></p>
		</div>
		</article>	
		
		<?php
		if(get_option('relatedmangachapter')=='1'){
		$metaseries = get_post_meta( get_the_ID(), 'ero_seri', true );
		$terms = get_the_terms( $metaseries , 'genres', 'string');
		if($terms){
				$term_ids = wp_list_pluck($terms,'term_id');
				$term_ids = array_slice($term_ids, 0, 2);
				$args=array(
				'post_type' => 'manga',
				'tax_query' => array(
								array(
									'taxonomy' => 'genres',
									'field' => 'id',
									'terms' => $term_ids,
									'operator'=> 'AND'
								 )),
				'post__not_in' => array($metaseries),
				'posts_per_page'=> 7,
				'orderby' => 'rand',
				'ignore_sticky_posts'=>1
				);
				$my_query = new wp_query( $args );
				if( $my_query->have_posts() ) { ?>
				<div class="bixbox">
					<div class="releases"><h2><span><?php echo GOV_lang::get('recommended_series');?></span></h2></div>
					<div class="listupd">
						<?php while( $my_query->have_posts() ) { $my_query->the_post(); get_template_part('template-parts/general/main'); } ?>
					</div>
				</div>
				<?php } wp_reset_query(); ?>
		<?php } } ?>
	
		<div id="comments" class="bixbox comments-area">
			<div class="releases"><h2><span><?php echo GOV_lang::get('comment_label');?></span></h2></div>
			<div class="cmt commentx">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<?php echo get_post_meta(get_the_ID(), "embed", true); ?>
					<?php comments_template(); ?>
				<?php endwhile; endif; ?>
			</div>
		</div>
		
	</div>
</div>

<?php 
if(get_option('tspgbar')){
$metaseries = get_post_meta( get_the_ID(), 'ero_seri', true ); ?>
<div class="readingnav rnavtop">
	<div class="readingnavtop">
		<div class="daw backseries"><a href="<?php echo get_permalink($metaseries); ?>"><i class="fas fa-angle-double-left"></i></a></div>
		<div class="daw chpnw"><?php echo GOV_lang::get('widget_chapter_label').' '.get_post_meta(get_the_ID(),'ero_chapter',true); ?> </div>
		<?php $dl = get_chdl(get_the_ID()); if($dl){ echo '<div class="daw dl"><a href="'.$dl.'" target="_blank"><i class="fas fa-cloud-download-alt"></i></a></div>'; } ?>
	</div>
	<div class="rdnmx rdtop"></div>
</div>
<div class="readingnav rnavbot">
	<div class="rdnmx rdbot"></div>
	<div class="readingnavbot">
		<div class="readingbar"><div class="readingprogress"></div></div>
		<div class="readingoption">
			<span class="selectorx slc l"><?php nv($theHISTORY['manga_ID'] ,1000,'DESC'); ?></span>
			<?php if (sizeof($servers) > 1){ ?>
				<span class="selectorx mirror l">
					<select name="mirror" id="mirror" class="mirror-selector">
					<?php foreach($servers as $k => $v){ if ( ! isset($v['source'])) continue; ?>
						<option value="<?php echo $readerClass->removeNonAlphaNum($v['source']); ?>"><?php echo $v['source']; ?></option>
					<?php } ?>
					</select>
				</span>
			<?php } ?>
			<div class="btm-np nextprev">

				<a class="ch-prev-btn" href="#/prev/" rel="prev">
					<i class="fas fa-arrow-left"></i>
				</a>
		
				<span class="selectorx pagedsel r">
					<select name="select-paged" class="ts-select-paged" id="select-paged">
						<option value="">?/?</option>
					</select>
				</span>
				
				<a class="ch-next-btn" href="#/next/" rel="next">
					<i class="fas fa-arrow-right"></i>
				</a>

			</div>
		</div>
	</div>
</div>
<?php } ?>
<script>ts_reader.run(<?php echo $readerClass->getReaderJson();?>);</script>
<script>
	var post_id = <?=$theHISTORY['manga_ID'];?>;
	var chapter_id = <?=$theHISTORY['chapter_ID'];?>;

	loadChList();
	
	jQuery( document ).ready(function() {jQuery.ajax({url : ajaxurl,type : 'post',data : {action : 'dynamic_view_ajax',post_id : post_id},success : function( response ) {}});});
	jQuery(document).ready(function(){
		HISTORY.push(<?php echo $theHISTORY['chapter_ID'];?>, <?php echo json_encode($theHISTORY)?>);
	});
</script>