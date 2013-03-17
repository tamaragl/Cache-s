<?php


	/**
	 * EXPIRATION CACHE :: MAX-AGE
	 * ------------------------------------------
	 */
		header('Pragma: cache');
		header('Cache-control:max-age=30, public');	


	/**
	 * EXPIRATION CACHE :: EXPIRATION HEADER
	 * ------------------------------------------
	 */
		$datetime = time() + (7 * 24 * 60 * 60);
		$expiration = date('D, d M Y H:i:s', $datetime) . ' GMT';

		header('Expires:' . $expiration);		
		header('Pragma: cache');		
		header('Cache-control: public');


	/**
	 * VALIDATION CACHE :: eTag
	 * ------------------------------------------
	 */
		session_cache_limiter('public');

		$etag_hash = md5($this->server->getValue('REQUEST_URI', 'text'));	
		
		//Para preguntar al servidor si se ha modificado el recurso
		$if_none_match = $this->server->getValue('HTTP_IF_NONE_MATCH', 'text');

		if( $if_none_match )
		{
			//No se ha modificado el recurso
			header('HTTP/1.1 304 Not Modified');			
		}
		else
		{
			//HTTP 1.1 200 OK
			header('ETag: ' . $etag_hash);	
		}


	/**
	 * VALIDATION CACHE :: Last-Modified
 	 * ------------------------------------------
 	 */
	
		header('Cache-control: public');

		$last_modified = time();
		$last_modified_server = (int)$this->server->getValue('HTTP_IF_MODIFIED_SINCE', 'text');

		$date_last_modified = strtotime( $last_modified );
		$date_last_modified_server = strtotime( $last_modified_server );

		var_dump($last_modified, $last_modified_server);

		if( $last_modified > $last_modified_server)
		{
			header('Last-Modified: ' . $last_modified);
			$last_modified = time() + 5;
			
		}
		else
		{	
			header('HTTP/1.1 304 Not Modified');

		}