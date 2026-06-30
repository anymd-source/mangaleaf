</div>
</div>
<div id="footer">
	<footer id="colophon" class="site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter" role="contentinfo">
	<?php $footermenu = wp_nav_menu( array( 'theme_location' => 'footer','fallback_cb' => '','echo' => '0' ) ); if($footermenu){ echo '<div class="footermenu">'.$footermenu.'</div>'; } ?>
	<div class="footercopyright">
		<?php get_template_part('footer-az'); ?>
		<?php get_template_part('template-parts/general/social'); ?>
		<div class="copyright">
			<div class="txt">
				<p><?php echo GOV_lang::get('footer_disclaimer'); ?></p>
			</div>
		</div>
	</div>
	</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>