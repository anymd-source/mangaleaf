<?php
$scb = get_option('tssocialbtn');
$tfb = get_option('tsfacebook');
$ttw = get_option('tstwitter');
$tig = get_option('tsinstagram');
$tyt = get_option('tsyoutube');
$trss = get_option('tsrss');
if($scb){ ?>
<div class="socialbutton">
	<?php if($tfb){ echo '<a href="'.$tfb.'" class="scfb" target="_blank"><i class="fab fa-facebook-f"></i></a>'; } ?>
	<?php if($ttw){ echo '<a href="'.$ttw.'" class="sctw" target="_blank"><i class="fab fa-twitter"></i></a>'; } ?>
	<?php if($tig){ echo '<a href="'.$tig.'" class="scig" target="_blank"><i class="fab fa-instagram"></i></a>'; } ?>
	<?php if($tyt){ echo '<a href="'.$tyt.'" class="scyt" target="_blank"><i class="fab fa-youtube"></i></a>'; } ?>
	<?php if($trss){ echo '<a href="'.$trss.'" class="scrss" target="_blank"><i class="fas fa-rss"></i></a>'; } ?>
</div>
<?php } ?>