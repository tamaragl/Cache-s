<?php


	/**
	 * EXPIRATION CACHE :: MAX-AGE
	 * ------------------------------------------
	 */
		//8 hours
		header('Cache-Control: max-age=28800');


	/**
	 * EXPIRATION CACHE :: EXPIRATION HEADER
	 * ------------------------------------------
	 */
		//header( 'Expires: '.gmdate( 'D, d M Y H:i:s', strtotime( "now" ) + 3600 ) );
		
		$datetime = time() + (7 * 24 * 60 * 60);
		$expiration = date('D, d M Y H:i:s', $datetime) . ' GMT';
		header('Expires:' . $expiration);		
		
		//header('Pragma: cache');		
		//header('Cache-control: public');


	/**
	 * VALIDATION CACHE :: eTag
	 * ------------------------------------------
	 */
		//session_cache_limiter('public');

		$etag_hash = md5($_SERVER['REQUEST_URI']);	
		
		//Para preguntar al servidor si se ha modificado el recurso
		$if_none_match = $_SERVER['HTTP_IF_NONE_MATCH'];
		
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
		
		/******** other example **************/
		
		$filetime = filemtime('file.txt');
 
		if ( isset( $_SERVER['HTTP_IF_MODIFIED_SINCE'] && strtotime( $_SERVER['HTTP_IF_MODIFIED_SINCE'] ) == $filetime )
		{
			header( 'HTTP/1.1 304 Not Modified' );
		}
		else
		{
			header( 'Last-Modified: '.gmdate( 'D, d M Y H:i:s', $filemtime ) );
			// Acciones y llamadas si se ha detectado que el archivo ha sido modificado.
		}