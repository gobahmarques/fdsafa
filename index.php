<?php
	function isBrazil() {
		$location = file_get_contents('http://freegeoip.net/json/');
		if ($location) {
		   $data = json_decode($location, true);
		   if ($data['country_name'] == 'Brazil') {
			  return true;
		   }
		}
		return false;
	}

	if (isBrazil()) {
	   header('Location: https://www.esportscups.com.br/ptbr/');
	} else {
	   header('Location: https://www.esportscups.com.br/ptbr/');
	}
?>

<html>
  <head>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-3038725769937948",
        enable_page_level_ads: true
      });
    </script>
  </head>
  <body>
  </body>
</html>