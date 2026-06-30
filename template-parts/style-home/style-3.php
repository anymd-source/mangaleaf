<div class="utao">
					<div class="uta">
						<div class="imgu">
							<a rel="<?php the_id(); ?>" class="series" href="<?php the_permalink() ?>" title="<?php the_title(); ?>"><?php echo GOV_manga::get_post_thumbnail(get_the_ID(),'medium', 130, 100);; ?>
							<?php $hot = get_post_meta(get_the_ID(),'ero_hot','true'); if($hot=='1'){ echo '<span class="hot">H</span>'; } ?>
							<?php 
								$pyear = get_post_meta(get_the_ID(),'ero_published',true);
								$serieslatest = GOV_manga::get_latest_chapters(get_the_ID());
								$type = get_post_meta(get_the_ID(),'ero_type',true);
								$istoday = get_the_modified_date('Ymd')===date('Ymd');
								if($istoday){
									$isnew = $pyear==date('Y') || (is_array($serieslatest) && sizeof($serieslatest)<=2);
								} else {
									$isnew = 0;
								}
								if($isnew){ echo '<span class="new">N</span>'; }
							?>
							</a>
						</div>
						<div class="luf">
							<a class="series" href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
								<h4><?php the_title(); ?></h4>
							</a>
							<?php if($serieslatest){
								echo '<ul class="'.$type.'">';
								$serieslatest = is_array($serieslatest)?$serieslatest:[];
								foreach ($serieslatest as $key => $value) {
									echo '<li><a href="'.chapter_url($value['permalink']).'">'.GOV_lang::get('mini_ch').''.$value['chapter'].'</a><span>'.human_time_diff($value['time'], current_time('timestamp')) . " ".GOV_lang::get('ago').'</span></li>';
								}
								echo '</ul>';
							} ?>
						</div>
					</div>
				</div>