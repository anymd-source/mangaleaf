<?php defined("ABSPATH") || die("!");?>
<p>
    Title Widget: <input class="widefat" name="<?php echo $name_field_name; ?>" type="text" value="<?php echo esc_attr($name); ?>" />
</p>
<p>
    Display Series: <input class="widefat" name="<?php echo $total_field_name; ?>" type="number" min="5" value="<?php echo esc_attr($total); ?>" />
</p>