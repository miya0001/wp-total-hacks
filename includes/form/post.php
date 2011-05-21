
<div id="post" class="tab">
<h3>Post & Pages</h3>
<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Hide Post Custom Fields</h4>
    <div class="block_content">
        <select name="wfb_hide_custom_fields" id="wfb_hide_custom_fields">
            <option value="">No</option>
            <option value="1" <?php if(get_option('wfb_hide_custom_fields')) echo 'selected="selected"'; ?>>Yes</option>
        </select>
    </div>
</div>
<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Revision Control</h4>
    <div class="block_content">
        <select name="wfb_revision" id="wfb_revision">
            <option value="">Off</option>
            <?php for($i=0; $i<21; $i++): ?>
            <?php
                if (strlen(get_option("wfb_revision")) && intval(get_option("wfb_revision")) === $i) {
                    $chk = 'selected="selected"';
                } else {
                    $chk = '';
                }
            ?>
            <option value="<?php echo $i; ?>" <?php echo $chk; ?>><?php echo $i; ?></option>
            <?php endfor; ?>
        </select>
    </div>
</div>
<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Disable Auto Save</h4>
    <div class="block_content">
        <select name="wfb_autosave" id="wfb_autosave">
            <option value="">No</option>
            <option value="1" <?php if(get_option('wfb_autosave')) echo 'selected="selected"'; ?>>Yes</option>
        </select>
    </div>
</div>
<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Stop Self Pings</h4>
    <div class="block_content">
        <select name="wfb_selfping" id="wfb_selfping">
            <option value="">No</option>
            <option value="1" <?php if(get_option('wfb_selfping')) echo 'selected="selected"'; ?>>Yes</option>
        </select>
    </div>
</div>
</div><!--end .tab-->


