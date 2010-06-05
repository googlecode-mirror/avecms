<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Who is online';
    $modul['ModulPfad'] = 'whoisonline';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'ƒанный модуль предназначен дл€ отображени€ присутствующих на сайте пользователей с гео-информацией.';
    $modul['Autor'] = '&copy;';
    $modul['MCopyright'] = '&copy; 2007-2010 Overdoze.Ru';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 0;
    $modul['AdminEdit'] = 0;
    $modul['ModulFunktion'] = 'mod_online';
    $modul['CpEngineTagTpl'] = '[mod_online]';
    $modul['CpEngineTag'] = '#\\\[mod_online]#';
    $modul['CpPHPTag'] = "<?php mod_online(); ?>";
}

function mod_online()
{
	echo '
	<link rel="stylesheet" type="text/css" href="' . ABS_PATH . 'modules/whoisonline/css/styles.css" />
	<!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script> -->
	<script type="text/javascript" src="' . ABS_PATH . 'modules/whoisonline/js/widget.js"></script>
	<div class="onlineWidget">
		<div class="panel"><img class="preloader" src="' . ABS_PATH . 'modules/whoisonline/images/preloader.gif" alt="Loading.." width="22" height="22" /></div>
		<div class="count"></div>
	    <div class="label">онлайн</div>
	    <div class="arrow"></div>
	</div>
	';
}

if (!defined('ACP') && isset($_REQUEST['module']) && $_REQUEST['module'] == 'whoisonline')
{
	function get_tag($tag, $xml)
	{
		$match = array();

		preg_match_all('/<' . $tag . '>(.*)<\/' . $tag . '>$/imU', $xml, $match);

		return $match[1];
	}

	function is_bot()
	{
		/* This function will check whether the visitor is a search engine robot */

		$botlist = array("Teoma", "alexa", "froogle", "Gigabot", "inktomi",
			"looksmart", "URL_Spider_SQL", "Firefly", "NationalDirectory",
			"Ask Jeeves", "TECNOSEEK", "InfoSeek", "WebFindBot", "girafabot",
			"crawler", "www.galaxy.com", "Googlebot", "Scooter", "Slurp",
			"msnbot", "appie", "FAST", "WebBug", "Spade", "ZyBorg", "rabaz",
			"Baiduspider", "Feedfetcher-Google", "TechnoratiSnoop", "Rankivabot",
			"Mediapartners-Google", "Sogou web spider", "WebAlta Crawler",
			"TweetmemeBot", "Butterfly", "Twitturls", "Me.dium", "Twiceler");

		foreach ($botlist as $bot)
		{
			if (strpos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) return true;	// Is a bot
		}

		return false;	// Not a bot
	}

	if (empty($_REQUEST['action']) || is_bot()) die();

	switch ($_REQUEST['action'])
	{
		case 'online':
			$stringIp = $_SERVER['REMOTE_ADDR'];
			$intIp = ip2long($stringIp);

			// Checking wheter the visitor is already marked as being online:
			$counted = $AVE_DB->Query("
				SELECT 1
				FROM " . PREFIX . "_modul_who_is_online
				WHERE ip = " . $intIp
			)->NumRows();

			if (! $counted)
			{
				// This user is not in the database, so we must fetch
				// the geoip data and insert it into the online table:

				if ($_COOKIE['geoData'])
				{
					// A "geoData" cookie has been previously set by the script, so we will use it

					// Always escape any user input, including cookies:
					list($city, $countryName, $countryAbbrev) = explode('|', mysql_real_escape_string(strip_tags($_COOKIE['geoData'])));
				}
				else
				{
					// Making an API call to Hostip:

					$xml = file_get_contents('http://api.hostip.info/?ip=' . $stringIp);

					$city = get_tag('gml:name', $xml);
					$city = $city[1];

					$countryName = get_tag('countryName', $xml);
					$countryName = $countryName[0];

					$countryAbbrev = get_tag('countryAbbrev', $xml);
					$countryAbbrev = $countryAbbrev[0];

					// Setting a cookie with the data, which is set to expire in a month:
					setcookie('geoData', $city . '|' . $countryName . '|' . $countryAbbrev, time()+60*60*24*30,'/');
				}

				$countryName = str_replace('(Unknown Country?)', 'UNKNOWN', $countryName);

				// In case the Hostip API fails:

				if (!$countryName)
				{
					$countryName = 'UNKNOWN';
					$countryAbbrev = 'XX';
					$city = '(Unknown City?)';
				}

				$AVE_DB->Query("
					INSERT INTO " . PREFIX . "_modul_who_is_online
					SET
						ip          = " . $intIp . ",
						city        = '" . $city . "',
						country     = '" . $countryName . "',
						countrycode = '" . $countryAbbrev . "'
				");
			}
			else
			{
				// If the visitor is already online, just update the dt value of the row:
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_who_is_online
					SET dt = NOW()
					WHERE ip = " . $intIp
				);
			}

			// Removing entries not updated in the last 10 minutes:
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_who_is_online
				WHERE dt<SUBTIME(NOW(),'0 0:10:0')
			");

			// Counting all the online visitors:
			list($totalOnline) = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_who_is_online
			")->FetchArray();

			// Outputting the number as plain text:
			echo $totalOnline;
			exit;


		case 'geodata':
			// Selecting the top 15 countries with the most visitors:
			$sql = $AVE_DB->Query("
				SELECT
					countryCode,
					country,
					COUNT(*) AS total
				FROM " . PREFIX . "_modul_who_is_online
				GROUP BY countryCode
				ORDER BY total DESC
				LIMIT 15
			");
			while ($row = $sql->FetchRow())
			{
				echo '
				<div class="geoRow">
					<div class="flag"><img src="' . ABS_PATH . 'modules/whoisonline/images/countryflags/' . strtolower($row->countryCode) . '.gif" width="16" height="11" /></div>
					<div class="country" title="' . htmlspecialchars($row->country) . '">' . $row->country . '</div>
					<div class="people">' . $row->total . '</div>
				</div>
				';
			}
			exit;
	}
	exit;
}

?>