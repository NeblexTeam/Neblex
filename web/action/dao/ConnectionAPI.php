<?php
	require_once('../neblio-api-lib-php/vendor/autoload.php');

	class ConnectionAPI {
		
		private static $apiInstance = null;
		
		public static function getAPI() {
				
			$apiInstance = new Swagger\Client\Api\NTP1Api(
				// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
				// This is optional, `GuzzleHttp\Client` will be used as default.
				/*******************************************************************
				*
				*
				*
				//put this when the website will be online
				//new GuzzleHttp\Client()
				//instead of
				//new GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ))
				*
				*
				*
				********************************************************************/
				new GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ))
			);
			return $apiInstance;
		}
	}