<?php 
/*
Template Name: Bookmark
*/
defined("ABSPATH") || die("!"); ?>
<?php get_header(); ?>
<div class="postbody">
    <div class="bixbox">
        <div class="releases"><h1><span><?php echo get_the_title();?></span></h1> <span class="hapus" id="hapus"><?php echo GOV_lang::get('delete'); ?></span></div>
        <p class="ntf">
            <?php echo GOV_lang::get('bookmark_head', ['max' => get_option('bookmark')]); ?>
        </p>
        <div class="listupd" id="bookmark-pool"></div>
    </div>
</div>
<script>
    function my_rating(){
        $(document).find('.score').each(function(index, el) {
          var $El = $(el);
          $El.barrating({
            theme: 'fontawesome-stars',
            readonly: true,
            initialRating: $El.attr('data-current-rating') 
          });
        });
    }
    jQuery(document).ready(function(){
        var bookmarks = BOOKMARK.getStored();   
        if (bookmarks.length < 1){
            jQuery("#bookmark-pool").html("<h4><center><?php echo GOV_lang::get('bookmark_no_item'); ?></center></h4>");
            return;
        }   
        jQuery.post(ajaxurl, {"action": "bookmark_get","ids": BOOKMARK.getStored()})
        .done(function(d){
            if (d.error) {
				jQuery("#bookmark-pool").html("<h4><center>" + d.error + "</center></h4>");
			} else {
                if ("error_ids" in d){
					for(var i in d.error_ids){
						BOOKMARK.remove(d.error_ids[i], false);
					}
				}
				jQuery("#bookmark-pool").html(d.data);
			}
            my_rating();
        });
        jQuery("#hapus").on('click', function(){
            if (jQuery(document).find('.delmark').length <= 0) {
                jQuery(document).find('div.bsx').prepend('<div class="delmark"><?php echo GOV_lang::get('delete'); ?></div>');
            }else{
                jQuery(document).find('.delmark').remove();
            }
        });
        jQuery(document).on('click', '.delmark', function(){
            var parent = jQuery(this).parent();
            var id = parent.attr('data-id');
            BOOKMARK.remove(id);
            parent.parent().remove();
        });
    });
</script>
<?php get_sidebar(); ?>
<?php get_footer(); ?>