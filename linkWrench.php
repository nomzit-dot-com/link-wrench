<?php
/*
Plugin Name: Link Wrench
Plugin URI: http://blog.nomzit.com/link-wrench
Description: Adds a span with class="insidelink" inside your links
Version: 1.0
Author: Phil Willoughby
Author URI: http://blog.nomzit.com/
License: GPL3
*/

class LinkWrench
{
	function ApplyLinkWrench()
	{
		if ( strpos($_SERVER['REQUEST_URI'], 'wp-admin') === false )
		{
			add_action('template_redirect', array(&$this, 'ForAddAction_template_redirect_ob_start'));
		}
	}
	
	function ForAddAction_template_redirect_ob_start()
	{
		ob_start(array(&$this, 'LinkWrenchMain'));
	}

	function LinkWrenchMain($content)
	{
		$pattern = '/<a([^>]*)>(.*?)<\/a>/i';
		$result = preg_replace_callback($pattern,array(&$this,'WrenchLinks'),$content);
		return $result;
	}

	function WrenchLinks($matches)
	{
		return '<a' . $matches[1] . '><span class="insidelink">' . $matches[2] . '</span></a>';
	}
}

if( !isset($myLinkWrench)  )
{
	$myLinkWrench = new LinkWrench();
	$myLinkWrench->ApplyLinkWrench();
}
?>
