<?php

/**
 * Class module Google Weather
 *
 * @package AVE.cms
 * @subpackage module_Weather
 * @author N.Popova, npop@abv.bg
 * @since 2.09
 * @filesource
 */
class Weather
{
	var $config;
	var $content;
	var $error;
	var $icons;
	var $parsedData;

	var $_cache_filename = null;
	var $_use_filelock = true;

// -------------------

	/**
	 * Convert C -> F
	 *
	 * @param int $value
	 * @return string
	 */
	function _weatherTemperatureCel2F($value)
	{
		return floor(32 + ((5/9) * $value)) . '&deg;F';
	}

	/**
	 * Convert F -> C
	 *
	 * @param int $value
	 * @return string
	 */
	function _weatherTemperatureF2Cel($value)
	{
		return floor((5/9) * ($value - 32)) . '&deg;C';
	}

	/**
	 * Get correct temperature
	 *
	 * @param int $temp
	 * @return string
	 */
	function _weatherTemperatureGet($temp)
	{
		if ($this->parsedData['unit'] == 'US')
		{
			return ($this->config['tempUnit'] == 'c') ? $this->_weatherTemperatureF2Cel($temp) : $temp . '&deg;F';
		}

		if ($this->parsedData['unit'] == 'SI')
		{
			return ($this->config['tempUnit'] == 'f') ? $this->_weatherTemperatureCel2F($temp) : $temp . '&deg;C';
		}

		return "";
	}

	/**
	 * Read cache file
	 *
	 * @return boolean
	 */
	function _weatherCacheRead()
	{
		if (!empty($this->_cache_filename)
			&& is_file($this->_cache_filename)
			&& filesize($this->_cache_filename) > 0
			&& ((filemtime($this->_cache_filename) + $this->config['cacheTime'] * 60) > time()))
		{
			$fp = @fopen($this->_cache_filename, "rb");
	        if ($this->_use_filelock) @flock($fp, LOCK_SH);
			if ($fp)
			{
				$this->content = @fread($fp, filesize($this->_cache_filename));
				if ($this->_use_filelock) @flock($fp, LOCK_UN);
				@fclose($fp);

				return true;
			}
		}

		return false;
	}

	/**
	 * Write cache file
	 *
	 * @return boolean
	 */
	function _weatherCacheWrite()
	{
		if (! empty($this->_cache_filename))
		{
			$fp = @fopen($this->_cache_filename, "wb");
			if ($fp)
			{
				if ($this->_use_filelock) @flock($fp, LOCK_EX);
				@fwrite($fp, $this->content);
				if ($this->_use_filelock) @flock($fp, LOCK_UN);
				@fclose($fp);

				return true;
			}
		}

		return false;
	}

	/**
	 * Init class
	 *
	 */
	function weatherInit()
	{
		global $AVE_DB;

		// configuration array
		$this->config = array(
			'module_unique_id'   => 1,
			'city'               => '',
			'fcity'              => '',
			'language'           => 'en',
			'latitude'           => 'null',
			'longitude'          => 'null',
			'timezone'           => '0',
			'showCity'           => '1',
			'showHum'            => '1',
			'showWind'           => '1',
			'tempUnit'           => 'c',
			'amountDays'         => '4',
			'current_icon_size'  => '64',
			'forecast_icon_size' => '32',
			'cacheTime'          => 5,
			'encoding'           => 'cp1251',
			'template'           => 'gweather',
			'useCSS'             => '0',
			'nameCSS'            => ''
		);

		// error text
		$this->error = '';

		// icons array
		$this->icons = array(
			"/ig/images/weather/chance_of_snow.gif"  => array('chance_of_snow.png', 'chance_of_snow_night.png'),
			"/ig/images/weather/flurries.gif"        => array('flurries.png'),
			"/ig/images/weather/snow.gif"            => array('snow.png'),
			"/ig/images/weather/sleet.gif"           => array('sleet.png'),
			"/ig/images/weather/chance_of_rain.gif"  => array('chance_of_rain.png','chance_of_rain_night.png'),
			"/ig/images/weather/chance_of_storm.gif" => array('chance_of_storm.png','chance_of_storm_night.png'),
			"/ig/images/weather/mist.gif"            => array('mist.png','mist_night.png'),
			"/ig/images/weather/showers.gif"         => array('showers.png','showers_night.png'),
			"/ig/images/weather/rain.gif"            => array('rain.png'),
			"/ig/images/weather/storm.gif"           => array('storm.png','storm_night.png'),
			"/ig/images/weather/thunderstorm.gif"    => array('thunderstorm.png'),
			"/ig/images/weather/rain_snow.gif"       => array('rain_and_snow.png'),
			"/ig/images/weather/sunny.gif"           => array('sunny.png','sunny_night.png'),
			"/ig/images/weather/mostly_sunny.gif"    => array('sunny.png','sunny_night.png'),
			"/ig/images/weather/partly_cloudy.gif"   => array('partly_cloudy.png','partly_cloudy_night.png'),
			"/ig/images/weather/mostly_cloudy.gif"   => array('mostly_cloudy.png','mostly_cloudy_night.png'),
			"/ig/images/weather/cloudy.gif"          => array('cloudy.png'),
			"/ig/images/weather/fog.gif"             => array('foggy.png','foggy_night.png'),
			"/ig/images/weather/foggy.gif"           => array('foggy.png','foggy_night.png'),
			"/ig/images/weather/smoke.gif"           => array('smoke.png','smoke_night.png'),
			"/ig/images/weather/hazy.gif"            => array('hazy.png','hazy_night.png'),
			"/ig/images/weather/dusty.gif"           => array('dusty.png','dusty_night.png'),
			"/ig/images/weather/icy.gif"             => array('icy.png','icy_night.png')
		);

		// parsed from XML data
		$this->parsedData = array(
			'unit'              => '',
			'current_condition' => '',
			'current_temp_f'    => '',
			'current_temp_c'    => '',
			'current_humidity'  => '',
			'current_icon'      => '',
			'current_wind'      => '',
			'forecast'          => array()
		);

		//Load settings
		$id = 1;
		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_gweather
			WHERE Id = '" . $id . "'
			LIMIT 1
		")->FetchRow();

		$this->config['module_unique_id']   = 1 ; // unique ID, only 1 for free version
		$this->config['city']               = str_replace(' ', '%20', $row->city );
		$this->config['fcity']              = $row->fullcity;
		$this->config['language']           = $row->language;
		$this->config['latitude']           = $row->lat;
		$this->config['longitude']          = $row->lon;
		$this->config['timezone']           = $row->timezone;
		$this->config['showCity']           = $row->showCity;
		$this->config['showHum']            = $row->showHum;
		$this->config['showWind']           = $row->showWind;
		$this->config['tempUnit']           = $row->tempUnit;
		$this->config['amountDays']         = $row->amountDays;
		$this->config['current_icon_size']  = $row->current_icon_size;
		$this->config['forecast_icon_size'] = $row->forecast_icon_size;
		$this->config['cacheTime']          = $row->cacheTime;
		$this->config['encoding']           = $row->encoding;
		$this->config['template']           = $row->template;
		$this->config['useCSS']             = $row->useCSS;
		$this->config['nameCSS']            = $row->nameCSS;
	} //  init()

	/**
	 * Get correct icon
	 *
	 * @param string $icon
	 * @param int $size
	 * @return string
	 */
	function weatherIconGet($icon, $size = '128')
	{
		$img_dir = ABS_PATH . 'modules/gweather/templates/img/';

		// if selected icon exists
		if (isset($this->icons[$icon]) && is_array($this->icons[$icon]))
		{	// if user use PHP5
			if (function_exists('date_sunrise') && function_exists('date_sunset'))
			{	// if user set values for his position
				if ($this->config['latitude'] !== 'null' && $this->config['longitude'] !== 'null')
				{	// getting final icon
					// if selected icon has two icons - for day and night
					if (count($this->icons[$icon]) > 1)
					{	// getting informations about sunrise and sunset time
						$sunrise = date_sunrise(time(), SUNFUNCS_RET_TIMESTAMP, $this->config['latitude'], $this->config['longitude'], ini_get("date.sunrise_zenith"), $this->config['timezone']);
						$sunset = date_sunset(time(), SUNFUNCS_RET_TIMESTAMP, $this->config['latitude'], $this->config['longitude'], ini_get("date.sunrise_zenith"), $this->config['timezone']);

						// night check ;)
						if (time() < $sunrise || time() > $sunset)
						{	// now is night! :P
							return $img_dir . (($size == '128') ? '' : $size . '/') . $this->icons[$icon][1];
						}
					}
				}
			}
			return $img_dir . (($size == '128') ? '' : $size . '/') . $this->icons[$icon][0];
		}
		//other
		return $img_dir . (($size == '128') ? '' : $size . '/') . 'other.png';
	}

	/**
	 * Get weather data XML
	 *
	 */
	function weatherDataGet()
	{
		if ($this->config['cacheTime'] > 0)
		{
			$this->_cache_filename = BASE_DIR . '/cache/modul_gweather_' . md5($this->config['city'] . $this->config['language']) . '.xml';

			if ($this->_weatherCacheRead()) return;
		}

		if (! function_exists('curl_init'))
		{
			$this->error = 'cURL extension is not available on your server';

			return;
		}

		$curl = curl_init(); // initializing connection
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); // saves us before putting directly results of request
		curl_setopt($curl, CURLOPT_URL, 'http://www.google.com/ig/api?weather=' . $this->config['city'] . '&hl=' . $this->config['language']); // url to get
		curl_setopt($curl, CURLOPT_TIMEOUT, 20); // timeout in seconds
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // useragent
		$this->content = curl_exec($curl); // reading content
		curl_close($curl); // closing connection

		if ($this->config['cacheTime'] > 0) $this->_weatherCacheWrite();

	} // weatherDataGet()

	/**
	 * Parsing data
	 *
	 */
	function weatherDataParse()
	{
		if ($this->error === '')
		{
			// checking for 400 Bad request page
			if (strpos($this->content, '400 Bad') == FALSE)
			{
				$xml_weather = simplexml_load_string($this->content);

				if ($xml_weather)
				{
					// checking data correct
					if (! isset($xml_weather->weather->problem_cause))
					{
						$problem = false;
						// preparing shortcuts
						$forecast_info = $xml_weather->weather->forecast_information;
						$current_conditions = $xml_weather->weather->current_conditions;

						if (isset($forecast_info->unit_system) &&
							isset($current_conditions->condition) &&
							isset($current_conditions->temp_f) &&
							isset($current_conditions->temp_c) &&
							isset($current_conditions->humidity) &&
							isset($current_conditions->icon) &&
							isset($current_conditions->wind_condition))
						{
							// loading data from feed
							$this->parsedData['unit'] = $forecast_info->unit_system['data'];
							$this->parsedData['current_temp_f'] = $current_conditions->temp_f['data'];
							$this->parsedData['current_temp_c'] = $current_conditions->temp_c['data'];
							$this->parsedData['current_icon']   = $current_conditions->icon['data'];
							if ($this->config['encoding'] == 'UTF-8')
							{
								$this->parsedData['current_condition'] = $current_conditions->condition['data'];
								$this->parsedData['current_humidity']  = $current_conditions->humidity['data'];
								$this->parsedData['current_wind']      = $current_conditions->wind_condition['data'];
							}
							else
							{
								$this->parsedData['current_condition'] = iconv('UTF-8', $this->config['encoding'], $current_conditions->condition['data']);
								$this->parsedData['current_humidity']  = iconv('UTF-8', $this->config['encoding'], $current_conditions->humidity['data']);
								$this->parsedData['current_wind']      = iconv('UTF-8', $this->config['encoding'], $current_conditions->wind_condition['data']);
							}

							// parsing forecast
							for($i = 0; $i < 4; $i++)
							{
								$node = $xml_weather->weather->forecast_conditions[$i];
								if ($this->config['encoding'] <> 'UTF-8')
								{
									$tday = iconv('UTF-8', $this->config['encoding'], $node->day_of_week['data']);
									$tcondition = iconv('UTF-8', $this->config['encoding'], $node->condition['data']);
								}
								else
								{
									$tday = $node->day_of_week['data'];
									$tcondition = $node->condition['data'];
								}
								$this->parsedData['forecast'][$i] = array(
									"day"       => $tday ,
									"low"       => $node->low['data'],
									"high"      => $node->high['data'],
									"icon"      => $node->icon['data'],
									"condition" => $tcondition,
									"ficon"     => "",
									"slow"      => "",
									"shigh"     => ""
								);
							}

							// make filename forecast icons
							for($i = 0; $i < 4; $i++)
							{
								$this->parsedData['forecast'][$i]['ficon'] = $this->weatherIconGet((string)$this->parsedData['forecast'][$i]['icon'], $this->config['forecast_icon_size']);
								$this->parsedData['forecast'][$i]['slow']  = $this->_weatherTemperatureGet($this->parsedData['forecast'][$i]['low']);
								$this->parsedData['forecast'][$i]['shigh'] = $this->_weatherTemperatureGet($this->parsedData['forecast'][$i]['high']);
							}
						}
						else
						{
							$problem = true;
						}
						// if problem detected
						if ($problem == true)
						{
							$this->error = 'An error occured during parsing XML data. Please try again.';
						}
					}
					else // if specified location doesn't exist
					{
						$this->error = 'An error occured - you set wrong location or data for your location are unavailable';
					}
				}
				else
				{
					// set error
					$this->error = 'Parse error in downloaded data';
				}
			}
			else
			{
				// set error
				$this->error = 'Parse error in downloaded data (400)';
			}
		}
	}

	/**
	 * Config module
	 *
	 * @param string $tpl_dir
	 * @param string $lang_file
	 */
	function weatherSettingsEdit($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_gweather
				SET
					city               = '" . $_REQUEST['city'] . "',
					fullcity           = '" . $_REQUEST['fullcity'] . "',
					language           = '" . $_REQUEST['language'] . "',
					lat                = '" . $_REQUEST['lat'] . "',
					lon                = '" . $_REQUEST['lon'] . "',
					timezone           = '" . $_REQUEST['timezone'] . "',
					showCity           = '" . $_REQUEST['showCity'] . "',
					showHum            = '" . $_REQUEST['showHum'] . "',
					showWind           = '" . $_REQUEST['showWind'] . "',
					tempUnit           = '" . $_REQUEST['tempUnit'] . "',
					amountDays         = '" . $_REQUEST['amountDays'] . "',
					current_icon_size  = '" . $_REQUEST['current_icon_size'] . "',
					forecast_icon_size = '" . $_REQUEST['forecast_icon_size'] . "',
					cacheTime          = '" . $_REQUEST['cacheTime'] . "',
					encoding           = '" . $_REQUEST['encoding'] . "',
					template           = '" . $_REQUEST['template'] . "',
					useCSS             = '" . $_REQUEST['useCSS'] . "',
					nameCSS            = '" . $_REQUEST['nameCSS'] . "'
				WHERE id = 1
			");

			header('Location:index.php?do=modules&action=modedit&mod=gweather&moduleaction=1&cp=' . SESSION);
			exit;
		}

		$row = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_gweather WHERE id = 1")->FetchAssocArray();

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_gweather.tpl'));
	}
} // class : end

?>