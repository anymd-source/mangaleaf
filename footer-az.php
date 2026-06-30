<?php $azslug = get_option('azslug'); if($azslug){ $azlink = get_page_link($azslug); ?> 
<div class="footer-az">
                  <span class="ftaz"><?php echo GOV_lang::get('footer_az_heading'); ?></span><span class="size-s"><?php echo GOV_lang::get('footer_az_text'); ?></span>
                  <ul class="ulclear az-list">
					  <li><a href="<?php echo $azlink; ?>?show=.">#</a></li>
					  <li><a href="<?php echo $azlink; ?>?show=0-9">0-9</a></li>
					  <?php foreach(range('a', 'z') as $letter) { ?>
					  <li><a href="<?php echo $azlink; ?>?show=<?php echo strtoupper($letter); ?>"><?php echo strtoupper($letter); ?></a></li>
					  <?php } ?>
                  </ul>
                  <div class="clear"></div>
               </div>
<?php } else { echo '<div class="sosmedmrgn"></div>'; } ?>