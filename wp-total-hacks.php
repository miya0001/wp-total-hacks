<?php
/*
Plugin Name: WP Total Hacks
Author: Takayuki Miyauchi
Plugin URI: http://wpist.me/wp/wp-total-hacks/
Description: WP Total Hacks can customize your WordPress.
Author: Takayuki Miyauchi
Version: 0.6.0
Author URI: http://wpist.me/
Domain Path: /languages
Text Domain: wp-total-hacks
*/


new TotalHacks();

class TotalHacks {

private $option_params = array(
    'wfb_google_analytics' => 'text',
    'wfb_favicon' => 'url',
    'wfb_admin_favicon' => 'bool',
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

public function __construct()
{
    if (is_admin()) {
        require_once(dirname(__FILE__).'/includes/admin.php');
        new TotalHacksAdmin(
            WP_PLUGIN_URL.'/'.dirname(plugin_basename(__FILE__)),
            $this->option_params
        );
    }
    if (strlen($this->op('wfb_revision'))) {
        if (!defined('WP_POST_REVISIONS')) {
            define('WP_POST_REVISIONS', $this->op('wfb_revision'));
        }
    }
    add_action('init',              array(&$this, 'init'));
    add_action('plugins_loaded',    array(&$this, 'plugins_loaded'));
    add_action('get_header',        array(&$this, 'get_header'));
    add_action('wp_head',           array(&$this, 'wp_head'));
    add_action('admin_head',        array(&$this, 'admin_head'));
    add_filter('admin_footer_text', array(&$this, 'admin_footer_text'));
    add_action('login_head',        array(&$this, 'login_head'));
    add_action('admin_menu' ,       array(&$this, 'admin_menu'));
    add_filter('login_headerurl',   array(&$this, 'login_headerurl'));
    add_filter('login_headertitle', array(&$this, 'login_headertitle'));
    add_action('pre_ping',          array(&$this, 'pre_ping'));
    add_action('wp_dashboard_setup',array(&$this, 'wp_dashboard_setup'));
    add_filter('the_content_more_link', array(&$this, 'the_content_more_link'));
    add_action('wp_print_scripts',  array(&$this, 'wp_print_scripts'));
    add_filter('wp_mail_from',      array(&$this, 'wp_mail_from'));
    add_filter('wp_mail_from_name', array(&$this, 'wp_mail_from_name'));
    add_filter('plugin_row_meta',   array(&$this, 'plugin_row_meta'), 10, 2);
    add_filter('user_contactmethods', array(&$this, 'user_contactmethods'));
    add_filter('excerpt_more',      array(&$this, 'excerpt_more'));
}

public function plugins_loaded()
{
    load_plugin_textdomain(
        "wp-total-hacks",
        false,
        dirname(plugin_basename(__FILE__)).'/languages'
    );
}

public function excerpt_more($str)
{
    if ($this->op('wfb_remove_excerpt')) {
        return null;
    }
    return $str;
}

public function user_contactmethods($meth)
{
    $del = $this->op('wfb_contact_methods');
    if ($del && is_array($del)) {
        foreach ($meth as $m => $s) {
            if (in_array($m, $del)) {
                unset($meth[$m]);
            }
        }
    }
    return $meth;
}

public function wp_mail_from($str)
{
    if ($this->op('wfb_emailaddress')) {
        if (preg_match("/^wordpress@/i", $str)) {
            return $this->op('wfb_emailaddress');
        }
    }
    return $str;
}

public function wp_mail_from_name($str)
{
    if ($this->op('wfb_sendername')) {
        if (preg_match("/^wordpress/i", $str)) {
            return $this->op('wfb_sendername');
        }
    }
    return $str;
}

public function init()
{
    if ($this->op("wfb_pageexcerpt")) {
        add_post_type_support('page', 'excerpt');
    }
}

public function wp_print_scripts()
{
    if (strlen($this->op('wfb_autosave'))) {
        wp_deregister_script('autosave');
    }
}

public function the_content_more_link($str)
{
    if ($this->op('wfb_remove_more')) {
        $str = preg_replace('/#more-[0-9]+/i', '', $str);
    }
    return $str;
}

public function get_header()
{
    if ($this->op('wfb_adjacent_posts_rel_links')) {
        if (is_page()) {
            remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
        }
    }
    if ($this->op('wfb_remove_xmlrpc')) {
        if (!$this->op("enable_app") && !$this->op('enable_xmlrpc')) {
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rsd_link');
        }
    }
    if ($this->op('wfb_hide_version')) {
        remove_action('wp_head', 'wp_generator');
    }
}

public function wp_dashboard_setup()
{
    if ($w = $this->op('wfb_widget')) {
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
    $home = $this->op( 'home' );
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
    if ($this->op("wfb_google_analytics")) {
        if ($this->op("wfb_exclude_loggedin") && is_user_logged_in()) {
        } else {
            echo stripslashes($this->op("wfb_google_analytics"));
        }
    }
    if ($this->op('wfb_favicon')) {
        $link = '<link rel="Shortcut Icon" type="image/x-icon" href="%s" />'."\n";
        printf($link, esc_url($this->op("wfb_favicon")));
    }
    if ($this->op('wfb_apple_icon')) {
        $link = '<link rel="apple-touch-icon" href="%s" />'."\n";
        printf($link, esc_url($this->op("wfb_apple_icon")));
    }
    echo $this->get_meta('google-site-verification', $this->op('wfb_google'));
    echo $this->get_meta('y_key', $this->op('wfb_yahoo'));
    echo $this->get_meta('msvalidate.01', $this->op('wfb_bing'));
}

public function admin_head()
{
    if ($this->op('wfb_favicon') && $this->op('wfb_admin_favicon')) {
        $link = '<link rel="Shortcut Icon" type="image/x-icon" href="%s" />'."\n";
        printf($link, esc_url($this->op("wfb_favicon")));
    }
    if (!$this->op("wfb_custom_logo")) {
        return;
    }
    $style = '<style type="text/css">';
    $style .= '#header-logo{background-image: url(%s) !important;}';
    $style .= '</style>';
    printf($style, esc_url($this->op("wfb_custom_logo")));
}

private function get_meta($name, $content)
{
    if ($name && $content) {
        return sprintf(
            '<meta name="%s" content="%s" />'."\n",
            $name,
            esc_attr($content)
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
            esc_url($this->op('wfb_login_logo'))
        );
    }
}

public function admin_menu()
{
    $metas = $this->op('wfb_postmetas');
    if ($metas && is_array($metas)) {
        foreach ($metas as $meta) {
            remove_meta_box($meta, 'post', 'normal');
        }
    }
    $metas = $this->op('wfb_pagemetas');
    if ($metas && is_array($metas)) {
        foreach ($metas as $meta) {
            remove_meta_box($meta, 'page', 'normal');
        }
    }
    if ($this->op('wfb_update_notification')) {
        global $user_login;
        get_currentuserinfo();
        if (!current_user_can('update_plugins')) {
            remove_action('admin_notices', 'update_nag', 3);
        }
    }
}

private function op($key, $default = false)
{
    $op = get_option($key, $default);
    if (is_array($op)) {
        return $op;
    } else {
        return trim(stripslashes($op));
    }
}

public function plugin_row_meta($links, $file)
{
    $pname = plugin_basename(__FILE__);
    if ($pname === $file) {
        $link = '<a href="%s">%s</a>';
        $links[] = sprintf(
            $link,
            admin_url('options-general.php?page=wp-biz'),
            __("Settings")
        );
        $url = "https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=8NDYFAG2ZM9TU";
        $links[] = sprintf($link, esc_url($url), __("Donate", "wp-total-hacks"));
    }
    return $links;
}

}

?>
