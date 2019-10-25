<?php

/**
 *  Check if the 'url' GET variable is set
 *  Example1 - http://ipaddr/?url=http://testphp.vulnweb.com/images/logo.gif
 *  Example2 - http://ipaddr/?url=http://localhost/server-status
 *  Example3 - http://169.254.169.254/metadata/instance?api-version=2017-08-01
 **/
if (isset($_GET['url'])){
	$url = $_GET['url'];

	/**
	 * Inject values into header
	 * Metadata setting is required for IMDS
	 **/
	$opts = array(
	  'http'=>array(
	  'method'=>"GET",
	  'header'=>"Metadata: true\r\n"
          )
	);

	$context = stream_context_create($opts);

	/**
	 * Send a request vulnerable to SSRF since
	 * no validation is being done on $url before sending the request
	 **/
	$val = fopen($url, 'r', false, $context);

	/**
	 * Change response headers to appropriate stream type
	 * Example - header("Content-Type: image/png"); 
	 **/

	/**
	 * Dump the contents of the stream to browser and close
	 **/
	fpassthru($val);
    fclose($val);
}

?>
