<div class="th headtree">
	<div class="centernav bound">
		
	<div class="shme"><i class="fa fa-bars" aria-hidden="true"></i></div>
		
	<header role="banner" itemscope itemtype="http://schema.org/WPHeader">
	<div class="site-branding logox">
	<?php 
		$topmenu = wp_nav_menu( array( 'theme_location' => 'top','fallback_cb' => '','echo' => '0' ) );
		$logo = get_option('logo');
		if($logo) { if(is_home()){ ?>
			<span class="logos">
				<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>"><span class="hdl"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span></a>
			</span>
			<?php } else { ?>
			<span class="logos">
				<a title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>" itemprop="url" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo $logo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php echo esc_attr( get_bloginfo( 'description', 'display' ) ); ?>"><span class="hdl"><?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?></span></a>
			</span>
			<?php } } ?>
			<meta itemprop="name" content="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" />
		</div>
	</header>
		
	<nav id="main-menu" class="mm">
		<span itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement" role="navigation">
		<?php 
			$nav_menu = wp_nav_menu(array('theme_location'=>'main', 'container'=>'', 'link_before'=>'<span itemprop="name">','link_after'=>'</span>','fallback_cb' => '', 'echo' => 0)); 
				if(empty($nav_menu))
					$nav_menu = '<ul>'.wp_list_categories(array('show_option_all'=>__('Home', 'dp'), 'title_li'=>'', 'echo'=>0)).'</ul>';
				echo $nav_menu;
		?>
		</span>
		<div class="clear"></div>
	</nav>
		
	<div class="searchx minmb">
 		<form action="<?php bloginfo('url'); ?>/" id="form" method="get" itemprop="potentialAction" itemscope itemtype="http://schema.org/SearchAction">
			<meta itemprop="target" content="<?php bloginfo('url'); ?>/?s={query}"/>
  			<input id="s" itemprop="query-input" class="search-live" type="text" placeholder="<?php echo GOV_lang::get('search_placeholder')?>" name="s"/>
			<button type="submit" id="submit"><i class="fas fa-search" aria-hidden="true"></i></button>
			<div class="srcmob srccls"><i class="fas fa-times-circle"></i></div>
 		</form>
	</div>
	
	<div class="srcmob"><i class="fas fa-search" aria-hidden="true"></i></div>
	<?php 
	$dmbtn = get_option('darkbutton');
	if($dmbtn){ ?>
	<div id="thememode">
			<span class="xt"><?php echo GOV_lang::get('darkmode_label')?></span>
			<label class="switch">
			  <input type="checkbox">
			  <span class="slider round"></span>
			</label>
	</div>
		
	<script>
			if (localStorage.getItem("thememode") == null){
				if (defaultTheme == "lightmode"){
					jQuery("#thememode input[type='checkbox']").prop('checked', false);
				}else{
					jQuery("#thememode input[type='checkbox']").prop('checked', true);
				}
			}else if (localStorage.getItem("thememode") == "lightmode"){
				jQuery("#thememode input[type='checkbox']").prop('checked', false);
			}else{
				jQuery("#thememode input[type='checkbox']").prop('checked', true);
			}
	</script>
	<?php } ?>	
	</div>
	<div class="clear"></div>
	</div>