<?php defined("ABSPATH") || die("!"); ?>
<p>Please <b>BackUp</b> Your Database before using this feature.</p>
<p>
    This Feature has been tested in wordpress 4.9 and above upto 5.5. <br />
    If your wordress version is not between 4.9 and 5.5, feel free to contact us<br />
</p>
<p>
    This feature will change post date of every chapter from selected manga
</p>
<p>
    Use this feature at your own Risk.
</p>
<form id="sform">
    <input type="hidden" name="skey" value="<?php echo $skey;?>" />
    <select name="mangaID" id="manga-list" required>
        <option value=""> -- Select a Manga -- </option>
        <?php foreach($mangaList as $k => $v) { ?>
            <option value="<?php echo esc_attr($v->ID); ?>"><?php echo esc_html($v->post_title); ?></option>
        <?php } ?>
    </select>
    <input type="submit" value="Submit" />
</form>
<div id="preview" style="display:none;">
    <iframe src=""></iframe>
</div>
<script>
    jQuery("#manga-list").on('change', function(){
        jQuery("#preview iframe").attr('src', "<?php echo esc_attr(get_site_url()); ?>?embed=true&p=" + this.value);
        jQuery("#preview").show();
    });
    jQuery("#sform").on("submit", function(){
        if ( ! confirm('It is encouraged to backup your database before using this feature, want to continue?')) return false;
    });
</script>