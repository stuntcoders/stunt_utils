<?php
/**
 * This file allows for automatic login if user is on specified domain.
 *
 * @package Stuntcoders
 * @link https://github.com/stuntcoders/stunt_utils
 */

$login_url_env  = 'WORDPRESS_LOGIN_URL';
$login_name_env = 'WORDPRESS_LOGIN_NAME';
$server_is_set  = isset( $_SERVER );
$env_domain     = getenv( $login_url_env );
$http_host      = '';

// Check if WORDPRESS_DOMAIN is set.
if ( empty( $env_domain ) ) {
	echo esc_html( $login_url_env ) . ' is not set. Check environmet variables in Dockerfile.';
	die;
}

// Check if $_SERVER is set.
if ( ! $server_is_set ) {
	echo '$_SERVER global variable is not set.';
	die;
}

// Check if ssl is enabled. If not, return url with http.
$http_host 	 = strval( $_SERVER['HTTP_HOST'] ); // @phpcs:ignore
$ssl_enabled = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'];
$site_url    = ( $ssl_enabled ? 'https://' : 'http://' ) . $http_host;

// Die if on any other domain.
if ( $env_domain !== $site_url ) {
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
