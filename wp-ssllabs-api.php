<?php
/**
 * WP-SSL-LABS-API (https://github.com/ssllabs/ssllabs-scan/blob/stable/ssllabs-api-docs.md)
 *
 * @package WP-SSL-LABS-API
 */

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) { exit; }


/* Check if class exists. */
if ( ! class_exists( 'SslLabsAPI' ) ) {

	/**
	 * SslLabsAPI API Class.
	 */
	class SslLabsAPI {

		/**
		 * API Endpoint
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://api.ssllabs.com/api/v2/';


		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct() {
		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}

		/**
		 * Check API Info.
		 *
		 * @access public
		 * @return void
		 */
		function check_api() {

			$request = $this->base_uri . 'info';

			return $this->fetch( $request );
		}


		/**
		 * Analyze SSL Certificate.
		 *
		 * @access public
		 * @param mixed $host
		 * @param string $publish (default: 'off')
		 * @param mixed $start_new
		 * @param mixed $from_cache
		 * @param mixed $max_age
		 * @param mixed $all
		 * @param mixed $ignore_mismatch
		 * @return void
		 */
		function analyze( $host, $publish = 'off', $start_new, $from_cache, $max_age, $all, $ignore_mismatch ) {

			$request = $this->base_uri . 'analyze?host=' . $host;

			return $this->fetch( $request );

		}

		/**
		 * Get Endpoint Data.
		 *
		 * @access public
		 * @param mixed $host
		 * @param mixed $s
		 * @param mixed $from_cache
		 * @return void
		 */
		function get_endpoint_data( $host, $s, $from_cache ) {

			$request = $this->base_uri . 'getEndpointData?host=' . $host;

			return $this->fetch( $request );
		}

		/**
		 * Get Status Codes.
		 *
		 * @access public
		 * @return void
		 */
		function get_status_codes() {

			$request = $this->base_uri . 'getStatusCodes';

			return $this->fetch( $request );

		}

		/**
		 * Get Root Certs Raw.
		 *
		 * @access public
		 * @return void
		 */
		function get_root_certs_raw() {

			$request = $this->base_uri . 'getRootCertsRaw';

			return $this->fetch( $request );
		}

	}
}
