<?php
/*
 * Plugin Name:       Reset Password Removed
 * Plugin URI:        https://wordpress.org/plugins/reset-password-removed
 * Description:       Removes the ability for non-admin users to change/reset their passwords.
 * Version:           1.1
 * Requires at least: 5.0
 * Requires PHP:      7.4
 * Author:            Shovon
 * Author URI:        https://www.realitsolution.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

class Password_Reset_Removed
{
  // Constructor: Hooks into WordPress filters
  function __construct() 
  {
    add_filter('show_password_fields', array($this, 'disable'));
    add_filter('allow_password_reset', array($this, 'disable'));
    add_filter('gettext', array($this, 'remove'));
  }

  // Disable password reset for non-admins
  function disable() 
  {
    if (is_admin()) {
      $userdata = wp_get_current_user();
      $user = new WP_User($userdata->ID);
      if (!empty($user->roles) && is_array($user->roles) && $user->roles[0] == 'administrator') {
        return true;
      }
    }
    return false;
  }

  // Remove "Lost your password?" text
  function remove($text) 
  {
    return str_replace(array('Lost your password?', 'Lost your password'), '', trim($text, '?'));
  }
}

// Initialize the plugin
$pass_reset_removed = new Password_Reset_Removed();
?>