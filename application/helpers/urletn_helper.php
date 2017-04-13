<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('site_url_https'))
{
	function site_url_https($uri = '')
	{
		$CI =& get_instance();
		$uri = str_replace("_", "-", $uri);
		$ft = $CI->config->site_url($uri);
		if(HTTPSSET == true)
			return str_replace("http:", "https:", $ft);
		else
			return $ft;
	}
}

