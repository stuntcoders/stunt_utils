<?php
/**
 * This file allows for automatic login if user is on specified domain.
 *
 * @package Stuntcoders
 * @link https://github.com/stuntcoders/stunt_utils
 */

// Get envs from phpdotenv.
$login_url_env  = getenv( 'WORDPRESS_LOGIN_URL' );
$login_name_env = getenv( 'WORDPRESS_LOGIN_NAME' );

// If phpdotenv is not available, manually set this up.
$default_url 	= 'http://localhost';
$default_login  = 'admin';

$http_host      = '';

// If admin login name and url are not set, use defaults.
if( ! isset( $login_url_env ) || empty( $login_url_env ) ) {
	$login_url_env = $default_url;
}

if( ! isset( $login_name_env ) || empty( $login_name_env ) ) {
	$login_name_env = $default_login;
}

// Check if $_SERVER is set.
if ( ! isset( $_SERVER ) ) {
	echo '$_SERVER global variable is not set.';
	die;
}

// Check if ssl is enabled. If not, return url with http.
$http_host 	 = strval( $_SERVER['HTTP_HOST'] ); // @phpcs:ignore
$ssl_enabled = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'];
$site_url    = ( $ssl_enabled ? 'https://' : 'http://' ) . $http_host;

// Die if on any other domain.
if ( $login_url_env !== $site_url ) {
	echo 'Site url does not match provided domain. Check environment variables in dockerfile.';
	die;
}

define( 'WP_USE_THEMES', false );
require '../wp-blog-header.php';

$user_login_name = getenv( $login_name_env );
$user            = get_user_by( 'login', $user_login_name );

wp_set_current_user( $user->ID, $user_login_name );
wp_set_auth_cookie( $user->ID );
do_action( 'wp_login', $user_login, $user );
header( 'location: /wp-admin/' );
