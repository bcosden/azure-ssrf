<?php

/**
 *  Check if the 'url' GET variable is set
 *  Example - http://localhost/?url=http://testphp.vulnweb.com/images/logo.gif
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
