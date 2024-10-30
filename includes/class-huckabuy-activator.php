<?php

/**
 * Fired during plugin activation
 *
 * @link       https://huckabuy.com
 * @since      1.0.0
 *
 * @package    Huckabuy
 * @subpackage Huckabuy/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Huckabuy
 * @subpackage Huckabuy/includes
 * @author     Huckabuy <developers@huckabuy.com>
 */
class Huckabuy_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// current hostname:
		$hostname = sanitize_text_field($_SERVER['HTTP_HOST']);

		$body = array(
			'siteName'			=> sanitize_text_field( get_option('blogname') ),
			'siteDescription'	=> sanitize_textarea_field( get_option('blogdescription') ),
			'home' 				=> sanitize_text_field( get_option('home') ),
			'siteurl' 			=> sanitize_text_field( get_option('siteurl') ),
			'email'   			=> sanitize_email( get_option('admin_email') ),
			'hostname'			=> $hostname
		);
		
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

		$response = wp_remote_post( 'https://api.dashboard.huckabuy.com/api/wordpress-plugin/activated', $args );

		// if the response is not a WP_Error, then we can get the body:

		if ( ! is_wp_error( $response ) ) {
			$body = wp_remote_retrieve_body( $response );
			// $body is a JSON string, so we need to decode it:
			$body = json_decode( $body );

			// if the body is not a JSON object, then we can't get the account ID:
			if ( ! is_object( $body ) ) {
				return;
			}
			$account_id = $body->account_id;
			$paid = $body->paid;
			$status = $body->status;

			// now we can save the account ID to the database:
			$options = get_option( 'huckabuy_option_name' );
			$options['id_number'] = $account_id;
			$options['status'] = $status;
			$options['settings'] = $settings;
			update_option( 'huckabuy_option_name', $options );
		}
	}

}
