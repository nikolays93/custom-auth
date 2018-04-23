<?php

/*
Plugin Name: Custom form user auth wp-login.php
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
 * wp-login-file
 *
 * show_register_login
 * show_register_email
 *
 * reg_passmail_text
 *
 * register_login_header_text
 * lost_password_login_header_text
 *
 * user_login_label
 * user_pass_label
 */

namespace NikolayS93\Auth;

if ( ! defined( 'ABSPATH' ) )
  exit; // disable direct access

const PLUGIN_DIR = __DIR__;
const DOMAIN = 'custom-auth';

__('Custom form user auth wp-login.php', DOMAIN);

define('LOGINPAGE', '/auth/');
define('REGISTERPAGE', '/register/');
define('LOSTPWDPAGE', '/lostpassword/');

register_activation_hook( __FILE__, function(){
  require_once PLUGIN_DIR . '/filters-and-actions.php';
  flush_rewrite_rules();
} );

load_plugin_textdomain( DOMAIN, false, basename(PLUGIN_DIR) . '/languages/' );

require_once PLUGIN_DIR . '/filters-and-actions.php';
