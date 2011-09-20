<?php

require_once(dirname(__FILE__).'/role.class.php');

class TotalHacksAdmin {

private $contributors = array(
    'Takayuki Miyauchi' => array(
        'country' => 'Japan',
        'url' => 'http://twitter.com/#!/miya0001',
    ),
    'Felix Kern' => array(
        'country' => 'Germany',
        'url' => 'http://twitter.com/#!/kernfel',
    ),
);
private $translators = array(
    'Takayuki Miyauchi' => array(
        'lang' => 'Japanese',
        'url' => 'http://twitter.com/#!/miya0001',
    ),
    'Andrea Bersi' => array(
        'lang' => 'Italian',
        'url' => 'http://www.andreabersi.com/',
    ),
    'LiVsI' => array(
        'lang' => 'Russian',
        'url' => 'http://lezhnevs.ru/',
    ),
    'Serkan Algur' => array(
        'lang' => 'Turkish',
        'url' => 'http://www.kaisercrazy.com/',
    ),
    'Felix Kern' => array(
        'lang' => 'German',
        'url' => 'http://twitter.com/#!/kernfel',
    ),
    'Guy Steyaert' => array(
        'lang' => 'Dutch',
        'url' => 'https://twitter.com/#!/ideosky/'
    ),
);
private $role = 'manage_options';
private $plugin_url = '';
private $page_title = 'WP Total Hacks';
private $params = array(
    'wfb_google_analytics' => 'text',
    'wfb_favicon' => 'url',
    'wfb_apple_icon' => 'url',
    'wfb_hide_version' => 'bool',
    'wfb_google' => 'text',
    'wfb_yahoo' => 'text',
    'wfb_bing' => 'text',
    'wfb_hide_custom_fields' => 'bool',
    'wfb_revision' => 'int',
    'wfb_autosave' => 'bool',
    'wfb_selfping' => 'bool',
    'wfb_widget' => 'array',
    'wfb_custom_logo' => 'url',
    'wfb_admin_footer_text' => 'html',
    'wfb_login_logo' => 'url',
    'wfb_login_url' => 'url',
    'wfb_login_title' => 'text',
    'wfb_webmaster' => 'bool',
    'wfb_remove_xmlrpc' => 'bool',
    'wfb_exclude_loggedin' => 'bool',
    'wfb_adjacent_posts_rel_links' => 'bool',
    'wfb_remove_more' => 'bool',
    'wfb_pageexcerpt' => 'bool',
    'wfb_postmetas' => 'array',
    'wfb_pagemetas' => 'array',
    'wfb_emailaddress' => 'email',
    'wfb_sendername' => 'text',
    'wfb_contact_methods' => 'array',
    'wfb_remove_excerpt' => 'bool',
    'wfb_update_notification' => 'bool',
);
private $widgets = array(
    'dashboard_right_now' => array(
        'position' => 'normal',
        'title' => 'Right Now'
    ),
    'dashboard_recent_comments' => array(
        'position' => 'normal',
        'title' => 'Recent Comments'
    ),
    'dashboard_incoming_links' => array(
        'position' => 'normal',
        'title' => 'Incoming Links'
    ),
    'dashboard_plugins' => array(
        'position' => 'normal',
        'title' => 'Plugins'
    ),
    'dashboard_quick_press' => array(
        'position' => 'normal',
        'title' => 'QuickPress'
    ),
    'dashboard_recent_drafts' => array(
        'position' => 'normal',
        'title' => 'Recent Drafts'
    ),
    'dashboard_primary' => array(
        'position' => 'normal',
        'title' => 'WordPress Blog'
    ),
    'dashboard_secondary' => array(
        'position' => 'normal',
        'title' => 'Other WordPress News'
    ),
);
private $post_metas = array(
    'commentstatusdiv' => array(
        'title' => 'Discussion'
    ),
    'commentsdiv' => array(
        'title' => 'Comments'
    ),
    'slugdiv' => array(
        'title' => 'Slug'
    ),
    'authordiv' => array(
        'title' => 'Author'
    ),
    'postcustom' => array(
        'title' => 'Custom Fields'
    ),
    'postexcerpt' => array(
        'title' => 'Excerpt'
    ),
    'trackbacksdiv' => array(
        'title' => 'Send Trackbacks'
    ),
    'formatdiv' => array(
        'title' => 'Format'
    ),
    'tagsdiv-post_tag' => array(
        'title' => 'Post Tags'
    ),
    'categorydiv' => array(
        'title' => 'Categories'
    ),
);
private $page_metas = array(
    'commentstatusdiv' => array(
        'title' => 'Discussion'
    ),
    'commentsdiv' => array(
        'title' => 'Comments'
    ),
    'slugdiv' => array(
        'title' => 'Slug'
    ),
    'authordiv' => array(
        'title' => 'Author'
    ),
    'postcustom' => array(
        'title' => 'Custom Fields'
    ),
);
private $contact_methods = array(
    'aim' => 'AIM',
    'yim' => 'Yahoo IM',
    'jabber' => 'Jabber / Google Talk',
);

function __construct($url)
{
    $this->plugin_url = $url;
    add_action('admin_menu', array(&$this, 'admin_menu'));
    add_filter('gettext', array(&$this, 'replace_text_in_thickbox'), 1, 3);
}

public function tiny_mce_before_init($init)
{
    $init['plugins'] = str_replace(
        array('wpfullscreen',',,'),
        array('', ','),
        $init['plugins']
    );
    return $init;
}

public function admin_styles() {
    $style = $this->plugin_url.'/css/style.css';
    printf(
        '<link rel="stylesheet" type="text/css" media="all" href="%s">',
        $style
    );
    $tabstyle = $this->plugin_url.'/css/ui.tabs.css';
    printf(
        '<link rel="stylesheet" type="text/css" media="all" href="%s">',
        $tabstyle
    );
}

public function admin_scripts() {
    global $wp_version;
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('editor');
    add_thickbox();
    wp_register_script(
        'wfb-upload',
        $this->plugin_url.'/js/wfb-upload.js',
        array('thickbox')
    );
    wp_enqueue_script('wfb-upload');
    if (version_compare($wp_version, '3.2', '<')) {
        add_action('admin_print_footer_scripts', 'wp_tiny_mce_preload_dialogs', 30);
    }
}

public function admin_menu()
{
    $hook = add_options_page(
        $this->page_title,
        'WP Total Hacks',
        $this->role,
        'wp-biz',
        array(&$this, 'options')
    );
    add_action("admin_head-".$hook, array(&$this, 'admin_head'));
    add_action('admin_print_scripts-'.$hook, array(&$this, 'admin_scripts'));
    add_action('admin_print_styles-'.$hook, array(&$this, 'admin_styles'));
    add_action("admin_init", array(&$this, 'admin_init'));
}

public function admin_head()
{
    printf(
        "<script type=\"text/javascript\" src=\"%s/js/wp-biz.js\"></script>",
        $this->plugin_url
    );
    if (isset($_GET['err']) && $_GET['err']) {
        add_action("admin_notices", array(&$this, "admin_notice"));
    }
    wp_admin_css();
    do_action("admin_print_styles-post-php");
    do_action('admin_print_styles');
    add_filter('tiny_mce_before_init', array(&$this, 'tiny_mce_before_init'), 999);
}

public function replace_text_in_thickbox($translated_text, $source_text, $domain) {
    if (isset($_GET['post_id']) && !$_GET['post_id'] && 'Insert into Post' == $source_text) {
        return __('Select File', 'wp-total-hacks');
    }
    return $translated_text;
}

public function admin_notice()
{
    if (isset($_GET['err']) && $_GET['err']) {
        echo "<div class=\"error\"><p>";
        echo "Security failure!";
        echo "</p></div>";
    }
}

public function admin_init()
{
    if (isset($_POST['wpbiz-nonce']) && $_POST['wpbiz-nonce']) {
        if (!current_user_can($this->role)) {
            wp_redirect(admin_url('options-general.php?page=wp-biz&err=true'));
        }
        $nonce = $_POST['wpbiz-nonce'];
        if (!$act = wp_verify_nonce($nonce, plugin_basename(__FILE__))) {
            wp_redirect(admin_url('options-general.php?page=wp-biz&err=true'));
        }
        $this->save();
        if (preg_match("/^[a-z]+$/", $_POST['tabid'])) {
            $tabid = $_POST['tabid'];
        } else {
            $tabid = '';
        }
        wp_redirect(admin_url('options-general.php?page=wp-biz&update=true#'.$tabid));
    }
}

public function save()
{
    foreach ($this->params as $key => $type) {
        if (isset($_POST[$key]) && is_array($_POST[$key])) {
            if (count($_POST[$key]) && $type === 'array') {
                $arr = array();
                foreach ($_POST[$key] as $str) {
                    $str = trim($str);
                    if (strlen($str)) {
                        $arr[] = $str;
                    }
                }
                if (count($arr)) {
                    update_option($key, $arr);
                    continue;
                }
            }
            delete_option($key);
        } elseif (isset($_POST[$key]) && strlen($_POST[$key])) {
            switch ($type) {
                case 'text':
                    update_option($key, trim($_POST[$key]));
                    break;
                case 'url':
                    update_option($key, trim($_POST[$key]));
                    break;
                case 'html':
                    update_option($key, trim($_POST[$key]));
                    break;
                case 'bool':
                    if ($_POST[$key] === "1") {
                        update_option($key, trim($_POST[$key]));
                    } else {
                        delete_option($key);
                    }
                    break;
                case 'int':
                    update_option($key, intval(trim($_POST[$key])));
                    break;
                case 'email':
                    if (is_email(trim($_POST[$key]))) {
                        update_option($key, trim($_POST[$key]));
                    } else {
                        delete_option($key);
                    }
                    break;
                default:
                    delete_option($key);
            }
        } else {
            delete_option($key);
        }
    } // endforeach

    if (get_option('wfb_webmaster')) {
        global $wp_roles;
        if (!isset($wp_roles->roles['webmaster'])) {
            new wfb_createNewRole(
                'webmaster',
                'Webmaster',
                'editor',
                array('edit_theme_options')
            );
        }
    } else {
        remove_role('webmaster');
    }
}

public function options()
{
    echo '<div class="wrap">';
    echo '<h2>'.$this->page_title.'</h2>';
    echo '<div id="wfb-container">';

    if (isset($_GET['err']) && $_GET['err']) {
        $this->error();
    } else {
        $this->form();
    }

    echo '<div id="wfb-footer">';
    include(dirname(__FILE__).'/form/footer.php');
    echo '</div><!--end #wfb-footer-->';
    echo '<div id="wfb-sidebar">';
    include(dirname(__FILE__).'/form/sidebar.php');
    echo '</div><!--end #wfb-sidebar-->';
    echo '</div><!--end #wfb-container-->';
    echo '</div>';
}

private function form()
{
    global $wp_version;
    if (version_compare($wp_version, '3.2', '<')) {
        wp_tiny_mce(true);
    }
    $url = admin_url('options-general.php?page=wp-biz');
    echo '<form method="post" action="'.$url.'">';
    $nonce = wp_create_nonce(plugin_basename(__FILE__));
    echo '<input type="hidden" name="wpbiz-nonce" value="'.$nonce.'" />';
    echo '<input type="hidden" id="tabid" name="tabid" value="" />';
    echo '<div id="tabs">';
    echo '<div id="wfb-notice"><div>'.__('Saved.').'</div></div>';
    echo '<ul id="menu"></ul>';
    include(dirname(__FILE__).'/form/site.php');
    include(dirname(__FILE__).'/form/post.php');
    include(dirname(__FILE__).'/form/appearance.php');
    include(dirname(__FILE__).'/form/other.php');
    echo '</div><!--end #tabs-->';
    echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="'.__('Save Changes').'" /></p>';
    echo '</form>';
}

private function error()
{
    echo '<div id="err_block">';
    echo 'Security failure.';
    echo '</div>';
}

private function get_plugin_url()
{
    return $this->plugin_url;
}

private function op($key, $display = true)
{
    $value = trim(stripslashes(get_option($key)));
    switch ($this->params[$key]) {
        case 'url':
            $value = esc_html(esc_url($value));
            break;
        case 'html':
            $value = $value;
            break;
        case 'int':
            $value = intval($value);
            break;
        case 'bool':
            $value = intval($value);
            break;
        default:
            $value = esc_html($value);
    }
    if ($display) {
        echo $value;
    } else {
        return $value;
    }
}

private function sel($id)
{
    echo '<select name="'.$id.'" id="'.$id.'">';
    echo '<option value="">'.__('Deactivate').'</option>';
    if (get_option($id)) {
        echo '<option value="1" selected="selected">'.__('Activate').'</option>';
    } else {
        echo '<option value="1">'.__('Activate').'</option>';
    }
    echo '</select>';
}

private function get_contributors()
{
    $html = '<a href="%s">%s</a> (%s)';
    $list = array();
    foreach ($this->contributors as $u => $props) {
        $list[] = sprintf($html, $props['url'], $u, $props['country']);
    }
    echo join(', ', $list);
}

private function get_translators()
{
    $html = '<a href="%s">%s</a> (%s)';
    $list = array();
    foreach ($this->translators as $u => $props) {
        $list[] = sprintf($html, $props['url'], $u, $props['lang']);
    }
    echo join(', ', $list);
}

}

?>
