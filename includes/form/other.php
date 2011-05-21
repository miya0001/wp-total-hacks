
<div id="dashboard" class="tab">
<h3>Other</h3>
<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Deactive Dashboard Widgets</h4>
    <div class="block_content">
        <ul>
            <?php foreach ($this->widgets as $wgt => $pos): ?>
            <li>
<?php if (get_option('wfb_widget') && is_array(get_option('wfb_widget')) && in_array($wgt, get_option('wfb_widget'))): ?>
                <input id="wfb_widget_<?php echo $wgt; ?>" type="checkbox" name="wfb_widget[]" value="<?php echo $wgt; ?>" checked="checked" />
<?php else: ?>
                <input id="wfb_widget_<?php echo $wgt; ?>" type="checkbox" name="wfb_widget[]" value="<?php echo $wgt; ?>" />
<?php endif; ?>
                <label for="wfb_widget_<?php echo $wgt; ?>"><?php echo __($pos['title']); ?></label>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Add role "Webmaster"</h4>
    <div class="block_content">
        <select name="wfb_webmaster" id="wfb_webmaster">
            <option value="">No</option>
            <option value="1" <?php if(get_option('wfb_webmaster')) echo 'selected="selected"'; ?>>Yes</option>
        </select>
        &nbsp;"Webmaster" role is able to "Editor" + "edit_theme_options".
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" /><?php _e('Change the default eamil address', 'wpbiz'); ?></h4>
    <div class="block_content">
        <p><?php _e('Change the default eamil address and sender name.', 'wpbiz'); ?></p>
        <dl>
            <dt>Name:</dt>
            <dd><input class="text" type="text" name="wfb_sendername" value="<?php $this->op('wfb_sendername')?>" /></dd>
            <dt>Address:</dt>
            <dd><input class="text" type="text" name="wfb_emailaddress" value="<?php $this->op('wfb_emailaddress')?>" /></dd>
        </dl>
    </div>
</div>

</div><!--end .tab-->


