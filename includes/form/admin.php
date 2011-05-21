
<div id="admin" class="tab">
<h3>Admin Settings</h3>

<div class="block">
    <h4><img alt="" src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Change admin header logo</h4>
    <div class="block_content">
        <p>Upload 30 x 30 pixel image for admin header logo.</p>
        <p><img class="caption" alt="" src="<?php echo $this->get_plugin_url(); ?>/img/admin_header_logo.png"></p>
        <input type="text" id="wfb_custom_logo" name="wfb_custom_logo" class="media" value="<?php $this->op('wfb_custom_logo'); ?>" />
        <a class="media-upload" href="JavaScript:void(0);" rel="wfb_custom_logo">Select File</a>
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Change admin footer text</h4>
    <div class="block_content">
        <p>You can edit admin footer text. Line breaks will remove.</p>
        <p><img class="caption" alt="" src="<?php echo $this->get_plugin_url(); ?>/img/admin_footer_text.png"></p>
        <div class="poststuff">
        <div class="postdivrich" class="postarea">
        <?php wp_tiny_mce(false); ?>
        <?php the_editor(trim(stripslashes(get_option('wfb_admin_footer_text'))), "wfb_admin_footer_text"); ?>
        </div><!--end #postdivrich-->
        </div><!--end #poststuff-->
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Change login logo</h4>
    <div class="block_content">
        <p>You can customize logo, URL and Title. The logo image size is recommended 310 x 70 pixel.</p>
        <p><img class="caption" alt="" src="<?php echo $this->get_plugin_url(); ?>/img/login_logo.png"></p>
        <dl>
        <dt>Logo:</dt>
        <dd><input type="text" id="wfb_login_logo" name="wfb_login_logo" class="media" value="<?php $this->op('wfb_login_logo'); ?>" />&nbsp;<a class="media-upload" href="JavaScript:void(0);" rel="wfb_login_logo">Select File</a></dd>
        <dt>URL:</dt>
        <dd><input class="text" type="text" name="wfb_login_url" value="<?php $this->op('wfb_login_url'); ?>" /></dd>
        <dt>Title:</dt>
        <dd><input class="text" type="text" name="wfb_login_title" value="<?php $this->op('wfb_login_title'); ?>" /></dd>
        </dl>
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

</div><!--end .tab-->

