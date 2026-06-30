<?php defined("ABSPATH") || die("!");
$counter = 0;
extract($args);
$name = apply_filters('widget_title', $instance['name']);
echo $before_widget;
if (!empty($name)) {
    echo $before_title . $name . $after_title;
}?>

<div class="ts-wpop-series-gen">
	<ul class="ts-wpop-nav-tabs">
		<li class="active"><a class="ts-wpop-tab" data-range="weekly"><?php echo GOV_lang::get('widget_popular_weekly')?></a></li>
		<li><a  class="ts-wpop-tab" data-range="monthly"><?php echo GOV_lang::get('widget_popular_monthly')?></a></li>
		<li><a  class="ts-wpop-tab" data-range="alltime"><?php echo GOV_lang::get('widget_popular_alltime')?></a></li>
	</ul>
</div>

	<div id="wpop-items">
	<div class='serieslist pop wpop wpop-weekly'>
		<ul>
			<?php $counter = 0;foreach ($data['weekly'] as $k => $v) {$counter++;?>
				<li>
					<div class="ctr"><?php echo $counter; ?></div>
					<div class="imgseries">
						<a class="series" href="<?php echo $v['url']; ?>" rel="<?php echo $v['id'];?>">
							<?php echo $v['image']; ?>
						</a>
					</div>
					<div class="leftseries">
						<h2>
							<a class="series" href="<?php echo $v['url']; ?>" rel="<?php echo $v['id'];?>"><?php echo $v['title'];?></a>
						</h2>
						<?php echo $v['genres']; ?>
						<?php $scorex = $v['score']; if(!$scorex || ! is_numeric($scorex)){ $scorex = get_option('tsscore'); }
						if($scorex){ $scorepros = $scorex * 10; ?>
						<div class="rt">
							<div class="rating">
								<div class="rating-prc">
									<div class="rtp">
										<div class="rtb"><span style="width:<?php echo $scorepros; ?>%"></span></div>
									</div>
								</div>
								<div class="numscore"><?php echo $scorex; ?></div>
							</div>
						</div>
						<?php } ?>
					</div>
				</li>
			<?php }?>
		</ul>
	</div>


	<div class='serieslist pop wpop wpop-monthly'>
		<ul>
			<?php $counter = 0;foreach ($data['monthly'] as $k => $v) {$counter++;?>
				<li>
					<div class="ctr"><?php echo $counter; ?></div>
					<div class="imgseries">
						<a class="series" href="<?php echo $v['url']; ?>" rel="<?php echo $v['id'];?>">
							<?php echo $v['image']; ?>
						</a>
					</div>
					<div class="leftseries">
						<h2>
							<a class="series" href="<?php echo $v['url']; ?>" rel="<?php echo $v['id'];?>"><?php echo $v['title'];?></a>
						</h2>
						<?php echo $v['genres']; ?>
						<?php $scorex = $v['score']; if(!$scorex || ! is_numeric($scorex)){ $scorex = get_option('tsscore'); }
						if($scorex){ $scorepros = $scorex * 10; ?>
						<div class="rt">
							<div class="rating">
								<div class="rating-prc">
									<div class="rtp">
										<div class="rtb"><span style="width:<?php echo $scorepros; ?>%"></span></div>
									</div>
								</div>
								<div class="numscore"><?php echo $scorex; ?></div>
							</div>
						</div>
						<?php } ?>
					</div>
				</li>
			<?php }?>
		</ul>
	</div>


	<div class='serieslist pop wpop wpop-alltime'>
		<ul>
			<?php $counter = 0;foreach ($data['all'] as $k => $v) {$counter++;?>
				<li>
					<div class="ctr"><?php echo $counter; ?></div>
					<div class="imgseries">
						<a class="series" href="<?php echo $v['url']; ?>" rel="<?php echo $v['id'];?>">
							<?php echo $v['image']; ?>
						</a>
					</div>
					<div class="leftseries">
						<h2>
							<a class="series" href="<?php echo $v['url']; ?>" rel="<?php echo $v['id'];?>"><?php echo $v['title'];?></a>
						</h2>
						<?php echo $v['genres']; ?>
						<?php $scorex = $v['score']; if(!$scorex || ! is_numeric($scorex)){ $scorex = get_option('tsscore'); }
						if($scorex){ $scorepros = $scorex * 10; ?>
						<div class="rt">
							<div class="rating">
								<div class="rating-prc">
									<div class="rtp">
										<div class="rtb"><span style="width:<?php echo $scorepros; ?>%"></span></div>
									</div>
								</div>
								<div class="numscore"><?php echo $scorex; ?></div>
							</div>
						</div>
						<?php } ?>
					</div>
				</li>
			<?php }?>
		</ul>
	</div>
</div>
<?php echo $after_widget; ?>
<script>ts_popular_widget.run(<?php echo time();?>);</script>
