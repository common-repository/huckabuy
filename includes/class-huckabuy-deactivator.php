<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://huckabuy.com
 * @since      1.0.0
 *
 * @package    Huckabuy
 * @subpackage Huckabuy/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Huckabuy
 * @subpackage Huckabuy/includes
 * @author     Huckabuy <developers@huckabuy.com>
 */
class Huckabuy_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// current hostname:
		$hostname = sanitize_text_field($_SERVER['HTTP_HOST']);

		$body = array('hostname'	=> $hostname);
		
		$args = array(
                'headers'     => array('Content-Type' => 'application/json', 'Expect' => ''),
                'body'        => json_encode($body),
                'method'      => 'POST',
                'data_format' => 'body',
                'timeout'     => 45,
                'redirection' => 5,
                'httpversion' => '1.0',
                'blocking'    => true,
      );

	  $response = wp_remote_post( 'https://api.dashboard.huckabuy.com/api/wordpress-plugin/deactivated', $args );
	}

}
