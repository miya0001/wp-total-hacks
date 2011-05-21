<div id="site" class="tab">
<h3>Site Settings</h3>
<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Install Google Analytics</h4>
    <div class="block_content">
        <p>Add Google analytics code.</p>
        <textarea name="wfb_google_analytics" id="wfb_google_analytics" cols="50" rows="7"><?php $this->op('wfb_google_analytics'); ?></textarea><br />
        <?php if (get_option('wfb_exclude_loggedin')): ?>
        <input id="wfb_exclude_loggedin" type="checkbox" name="wfb_exclude_loggedin" value="1" checked="checked" />
        <?php else: ?>
        <input id="wfb_exclude_loggedin" type="checkbox" name="wfb_exclude_loggedin" value="1" />
        <?php endif; ?>
        <label for="wfb_exclude_loggedin">Exclude user logged in.</label>
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Add a favicon</h4>
    <div class="block_content">
        <p>Upload .ico image.</p>
        <input type="text" id="wfb_favicon" name="wfb_favicon" class="media" value="<?php $this->op('wfb_favicon'); ?>" />
        <a class="media-upload" href="JavaScript:void(0);" rel="wfb_favicon">Select File</a>
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Remove version number from head</h4>
    <div class="block_content">
        <p>Remove "&ltmeta name="generator" content="WordPress x.x.x" /&gt;" from head.</p>
        <select name="wfb_hide_version" id="wfb_hide_version">
            <option value="">No</option>
            <option value="1" <?php if(get_option('wfb_hide_version')) echo 'selected="selected"'; ?>>Yes</option>
        </select>
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Webmaster Tools Verification</h4>
    <div class="block_content">
        <p>Enter your meta key "content" value to verify your blog with <a href="https://www.google.com/webmasters/tools/">Google Webmaster Tools</a>, <a href="https://siteexplorer.search.yahoo.com/">Yahoo! Site Explorer</a>, and <a href="http://www.bing.com/webmaster">Bing Webmaster Center</a></p>
        <dl>
            <dt>Google:</dt>
            <dd><input class="text" type="text" name="wfb_google" value="<?php $this->op('wfb_google')?>" /></dd>
            <dt>Yahoo:</dt>
            <dd><input class="text" type="text" name="wfb_yahoo" value="<?php $this->op('wfb_yahoo')?>" /></dd>
            <dt>Bing:</dt>
            <dd><input class="text" type="text" name="wfb_bing" value="<?php $this->op('wfb_bing')?>" /></dd>
        </dl>
    </div>
</div>

<div class="block">
    <h4><img src="<?php echo $this->get_plugin_url(); ?>/img/check.png" height="24" width="24" />Enable auto remove "wlwmanifest" and "xmlrpc"</h4>
    <div class="block_content">
        <p>If you don't use "<a href="<?php echo admin_url('options-writing.php'); ?>">Remote Publishing</a>", remove unnecessary tags from head.</p>
        <select name="wfb_remove_xmlrpc" id="wfb_remove_xmlrpc">
            <option value="">No</option>
            <option value="1" <?php if(get_option('wfb_remove_xmlrpc')) echo 'selected="selected"'; ?>>Yes</option>
        </select>
    </div>
</div>


</div><!--end .tab-->

