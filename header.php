<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width" />
	<?php $metac = get_option('themecolor'); if($metac==''){$metac='#3367d6';} ?>
	<meta name="theme-color" content="<?php echo $metac; ?>">
	<meta name="msapplication-navbutton-color" content="<?php echo $metac; ?>">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo $metac; ?>">
<?php wp_head(); ?>
</head>
<body class="<?php echo get_option('defaulttheme'); ?><?php if(is_singular('post')){ echo ' black'; } ?>" itemscope="itemscope" itemtype="http://schema.org/WebPage"><?php tsia_after_body(); ?>
	
<?php 
	$headerstyle = get_option('styleheader'); if($headerstyle==''){ $headerstyle = '1'; }
	get_template_part('template-parts/header/style',$headerstyle);
?>

<?php if(is_home() && ! get_query_var( 'themesia-mangalist' )){ get_template_part('template-parts/home/home','slider'); } ?>

<div id="content"<?php if(is_singular('post')){ echo ' class="readercontent"'; } else if(is_singular('manga')){ if(get_option('styleseries')=='3'){ $servar = 'mangatere';} else { $servar = 'mangastyle';} echo ' class="manga-info '.$servar.'"'; } ?>>
	
<?php if(!is_singular('manga')){ $kln = get_option('toprec'); if($kln) { ?><div class="blox mlb kln"><?php echo $kln; ?></div><br/><?php } } ?>
	
<div class="wrapper">