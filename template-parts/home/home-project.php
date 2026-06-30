<?php defined("ABSPATH") || die("!"); ?>

<?php 
$project = get_option('projecthome');
$projectslug = get_option('projectslug');
if ($project) {
	$projectslug = get_page_link($projectslug);
	$project_query = new WP_Query(array(
		"post_type" => "manga",
		"orderby" => "modified",
		"showposts" => $project,
		"meta_key" => 'ero_project',
		"meta_value" => '1',
		"ignore_sticky_posts" => 1,
		"no_found_rows" => true,
		"update_post_term_cache" => false,
	));

    $style = get_option('styleproject');
    if ($style == '') {
		$style = '1';
	}
    ?>
	<?php $kln = get_option('topf'); if($kln) { ?><div class="kln"><?php echo $kln; ?></div><br/><?php } ?>
	<div class="bixbox">
		<?php if ($project_query->have_posts()): ?>
		<div class="releases">
			<h2><?php echo GOV_lang::get('home_project_release_label'); ?></h2>
			<?php if ($projectslug) { ?>
				<a class="vl" href="<?php echo $projectslug; ?>"><?php echo GOV_lang::get('view_all_label'); ?></a>
			<?php }?></div>
			<div class="listupd">
			<?php
			while ($project_query->have_posts()): 
				$project_query->the_post();
				get_template_part('template-parts/style-home/style', $style);
			endwhile;?>
		</div>
		<?php endif;?>
	</div>
<?php }?>