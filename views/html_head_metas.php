<?php

		$title = "WOM-Ambassadors.com";
		
		if(isset($active_site['domain'])){
			$title = $active_site['domain'];
		}
		
		$timestamp = gmdate('D, d M Y H:i:s') . ' GMT';		
?>
 		
		<meta charset="<?php echo $charset; ?>">
		<title><?php echo $title;?></title>
		
		<meta name="application-name" content="">
		<meta name="description" content="<?php //TODO esperamos conteudos echo $community['printable_name']; ?>">
		<meta name="keywords" content="ambassadors, embaixadores, embajadores, boca a boca, wom, word-of-mouth">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- content type -->
		<meta http-equiv="content-type" content="text/html" charset="<?php echo $charset; ?>">
		
		<!-- caching -->
		<meta http-equiv="Cache-Control" content="no-cache"/>								<!-- HTTP 1.1. -->
		<meta http-equiv="Cache-Control" content="no-store" />							<!-- HTTP 1.1. -->
		<meta http-equiv="Cache-Control" content="must-revalidate"/>						<!-- HTTP 1.1. -->
		<meta http-equiv="Cache-Control" content="private, max-stale=0, post-check=0, pre-check=0" />	<!-- HTTP 1.1. -->
		<meta http-equiv="Pragma" content="no-cache" />									<!-- HTTP 1.0. -->
		<meta http-equiv="Expires" content="-1" />									<!-- Proxies -->
		<meta http-equiv="Last-Modified" content="<?php echo $timestamp; ?>" />