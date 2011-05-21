
<div id="dashboard" class="tab">
<h3>Dashboard Widgets</h3>
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

</div><!--end .tab-->


