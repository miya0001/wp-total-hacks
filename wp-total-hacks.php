<?php
/*
Plugin Name: WP Total Hacks
Author: Takayuki Miyauchi
Plugin URI: http://firegoby.theta.ne.jp/
Description: Customize your WP
Author: Takayuki Miyauchi
Version: 0.1.0
Author URI: http://firegoby.theta.ne.jp/
*/

require_once(dirname(__FILE__).'/includes/wpbiz_admin.php');
new WPBIZ_ADMIN(WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)));

new WPBIZ();

class WPBIZ {

public function __construct()
{
    load_plugin_textdomain(
        "wpbiz",
        PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/langs',
        dirname(plugin_basename(__FILE__)).'/langs'
    );
    if (strlen($this->op('wfb_revision'))) {
        define('WP_POST_REVISIONS', $this->op('wfb_revision'));
    }
    if (strlen($this->op('wfb_autosave'))) {
        define('AUTOSAVE_INTERVAL', 86400);
    }
    add_action('init',              array(&$this, 'init'));
    add_action('wp_head',           array(&$this, 'wp_head'));
    add_filter('the_generator',     array(&$this, 'the_generator'));
    add_action('admin_head',        array(&$this, 'admin_head'));
    add_filter('admin_footer_text', array(&$this, 'admin_footer_text'));
    add_action('login_head',        array(&$this, 'login_head'));
    add_action('admin_menu' ,       array(&$this, 'admin_menu'));
    add_filter('login_headerurl',   array(&$this, 'login_headerurl'));
    add_filter('login_headertitle', array(&$this, 'login_headertitle'));
    add_action('pre_ping',          array(&$this, 'pre_ping'));
    add_action('wp_dashboard_setup',array(&$this, 'wp_dashboard_setup'));
}

public function init()
{
    if (get_option('wfb_remove_xmlrpc')) {
        if (!get_option("enable_app") && !get_option('enable_xmlrpc')) {
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rsd_link');
        }
    }
}

public function wp_dashboard_setup()
{
    if ($w = get_option('wfb_widget')) {
        global $wp_meta_boxes;
        foreach ($wp_meta_boxes['dashboard']['normal']['core'] as $key => $array) {
            if (in_array($key, $w)) {
                unset($wp_meta_boxes['dashboard']['normal']['core'][$key]);
            }
        }
        foreach ($wp_meta_boxes['dashboard']['side']['core'] as $key => $array) {
            if (in_array($key, $w)) {
                unset($wp_meta_boxes['dashboard']['side']['core'][$key]);
            }
        }
    }
}

public function pre_ping(&$links)
{
    if (!$this->op('wfb_selfping')) {
        return;
    }
    $home = get_option( 'home' );
    foreach ($links as $l => $link) {
    if (0 === strpos($link, $home)) {
            unset($links[$l]);
        }
    }
}

public function login_headerurl($url)
{
    if ($op = $this->op('wfb_login_url')) {
        return $op;
    } else {
        return $url;
    }
}

public function login_headertitle($url)
{
    if ($op = $this->op('wfb_login_title')) {
        return $op;
    } else {
        return $url;
    }
}

public function wp_head()
{
    if (get_option("wfb_exclude_loggedin") && is_user_logged_in()) {
    } else {
        echo stripslashes($this->op("wfb_google_analytics"));
    }
    if ($this->op('wfb_favicon')) {
        $link = '<link rel="Shortcut Icon" type="image/x-icon" href="%s" />';
        printf($link, $this->op("wfb_favicon"));
    }
    echo $this->get_meta('google-site-verification', $this->op('wfb_google'));
    echo $this->get_meta('y_key', $this->op('wfb_yahoo'));
    echo $this->get_meta('msvalidate.01', $this->op('wfb_bing'));
}

public function the_generator($str)
{
    if ($this->op('wfb_hide_version')) {
        return '';
    } else {
        return $str;
    }
}

public function admin_head()
{
    if (!$this->op("wfb_custom_logo")) {
        return;
    }
    $style = '<style type="text/css">';
    $style .= '#header-logo{background-image: url(%s) !important;}';
    $style .= '</style>';
    printf($style, $this->op("wfb_custom_logo"));
}

private function get_meta($name, $content)
{
    if ($name && $content) {
        return sprintf(
            '<meta name="%s" content="%s">',
            $name,
            $content
        );
    }
}

public function admin_footer_text($text)
{
    if ($str = $this->op('wfb_admin_footer_text')) {
        return $str;
    } else {
        return $text;
    }
}

public function login_head()
{
    if ($this->op("wfb_login_logo")) {
        printf(
            '<style type="text/css">h1 a {background-image: url(%s) !important;}</style>',
            $this->op('wfb_login_logo')
        );
    }
}

public function admin_menu()
{
    if ($this->op("wfb_hide_custom_fields")) {
        remove_meta_box('postcustom', 'post', 'normal');
        remove_meta_box('postcustom', 'page', 'normal');
    }
}

private function op($key, $default = false)
{
    return trim(stripslashes(get_option($key, $default)));
}

}

?>
