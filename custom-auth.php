<?php

/*
Plugin Name: Собственная форма авторизации пользователя
Plugin URI: https://github.com/nikolays93
Description:
Version: 0.0.1
Author: NikolayS93
Author URI: https://vk.com/nikolays_93
Author EMAIL: nikolayS93@ya.ru
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Хуки плагина:
 * $pageslug . _after_title (default empty hook)
 * $pageslug . _before_form_inputs (default empty hook)
 * $pageslug . _inside_page_content
 * $pageslug . _inside_side_container
 * $pageslug . _inside_advanced_container
 * $pageslug . _after_form_inputs (default empty hook)
 * $pageslug . _after_page_wrap (default empty hook)
 *
 * Фильтры плагина:
 * "get_{DOMAIN}_option_name" - имя опции плагина
 * "get_{DOMAIN}_option" - значение опции плагина
 * "load_{DOMAIN}_file_if_exists" - информация полученная с файла
 * "get_{DOMAIN}_plugin_dir" - Дирректория плагина (доступ к файлам сервера)
 * "get_{DOMAIN}_plugin_url" - УРЛ плагина (доступ к внешним файлам)
 *
 * $pageslug . _form_action - Аттрибут action формы на странице настроек плагина
 * $pageslug . _form_method - Аттрибут method формы на странице настроек плагина
 *
 *  register_login_header_text
 *  lost_password_login_header_text
 */

namespace NikolayS93\Auth;

if ( ! defined( 'ABSPATH' ) )
  exit; // disable direct access

const PLUGIN_DIR = __DIR__;
const DOMAIN = 'custom-auth';

define('LOGINPAGE', '/auth/');
define('REGISTERPAGE', '/register/');
define('LOSTPWDPAGE', '/lostpassword/');

// Нужно подключить заранее для подключения файлов @see include_required_files()
// активации и деактивации плагина @see activate(), uninstall();
require __DIR__ . '/utils.php';

class Plugin
{
    private static $initialized;
    private function __construct() {}

    static function activate() {

        Utils::load_file_if_exists( Utils::get_plugin_dir('/.install.php') );
    }

    static function uninstall() {

        Utils::load_file_if_exists( Utils::get_plugin_dir('/.uninstall.php') );
    }

    public static function initialize()
    {
        if( self::$initialized )
            return false;

        load_plugin_textdomain( DOMAIN, false, basename(PLUGIN_DIR) . '/languages/' );
        self::include_required_files();

        self::$initialized = true;
    }

    /**
     * Подключение файлов нужных для работы плагина
     */
    private static function include_required_files()
    {
        $plugin_dir = Utils::get_plugin_dir();

        $classes = array(
            // __NAMESPACE__ . '\WP_List_Table'  => '/vendor/nikolays93/wp-list-table.php',
            // __NAMESPACE__ . '\WP_Admin_Page'  => '/vendor/nikolays93/wp-admin-page.php',
            // 'NikolayS93\WPAdminForm\Version'  => '/vendor/nikolays93/WPAdminForm/init.php',
            // __NAMESPACE__ . '\WP_Post_Boxes'  => '/vendor/nikolays93/wp-post-boxes.php',
        );

        foreach ($classes as $classname => $path) {
            $filename = $plugin_dir . $path;
            if( ! class_exists($classname) ) {
                Utils::load_file_if_exists( $filename );
            }
        }

        // Utils::load_file_if_exists( $plugin_dir . '/includes/actions.php' );
        // Utils::load_file_if_exists( $plugin_dir . '/includes/filters.php' );

        // includes
        // Utils::load_file_if_exists( $plugin_dir . '/includes/admin-settings-page.php' );
        Utils::load_file_if_exists( $plugin_dir . '/includes/filters.php' );
        Utils::load_file_if_exists( $plugin_dir . '/includes/actions.php' );
        Utils::load_file_if_exists( $plugin_dir . '/includes/authorize.php' );
    }

    static function set_path()
    {
        $login_path = get_template_directory() . '/wp-login.php';
        $login_url = file_exists($login_path) ?
            str_replace(site_url(), '', get_template_directory_uri() . '/wp-login.php') :
            'wp-content/plugins/'.DOMAIN.'/wp-login.php';

        add_rewrite_rule( ltrim(LOGINPAGE, '/') . '/?$', $login_url );

        add_rewrite_rule( ltrim(REGISTERPAGE, '/') . '/?$', $login_url . '?action=register' );
        add_rewrite_rule( ltrim(LOSTPWDPAGE, '/') . '/?$', $login_url . '?action=lostpassword' );
    }
}

register_activation_hook( __FILE__, array( __NAMESPACE__ . '\Plugin', 'activate' ) );
register_uninstall_hook( __FILE__, array( __NAMESPACE__ . '\Plugin', 'uninstall' ) );
// register_deactivation_hook( __FILE__, array( __NAMESPACE__ . '\Plugin', 'deactivate' ) );

add_action( 'plugins_loaded', array( __NAMESPACE__ . '\Plugin', 'initialize' ), 10 );

add_action('init', array(__NAMESPACE__ . '\Plugin', 'set_path'));

  /**
   * Логотип на форме входа
   */
  add_action('login_header', __NAMESPACE__ . '\login_header_logo_css');
  function login_header_logo_css() {
    if( $logo_id = get_theme_mod( 'custom_logo' ) ) {
      $logo_src = wp_get_attachment_image_src( $logo_id, 'full' );
      echo "
      <style type=\"text/css\">
        body.login {
          background:;
        }
        #login.left {
          width: 1200px;
        }
        #login.left h1,
        #login.left #loginform,
        #login.left #nav,
        #login.left #backtoblog {
            display: block;
            width: 320px;
            padding-left: 24px;
            padding-right: 24px;
        }
        #login.right h1,
        #login.right #loginform,
        #login.right #nav,
        #login.right #backtoblog {
            margin-left: auto;
        }
        #login h1 a {
          background: url('$logo_src[0]') center no-repeat;
          background-size: contain;
          width: $logo_src[1]px;
          max-width: 100%;
        }
      </style> \r\n";
    }
  }

  add_filter( 'login_headerurl', 'home_url', 10, 0 );