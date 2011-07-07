{if $config.useCSS == 1}
	<link href="{$ABS_PATH}modules/gweather/templates/weather.css" rel="stylesheet" type="text/css" media="screen" />
{/if}
<div class="gw_simple clear" id="{$config.module_unique_id}">
	<div class="gw_current">
		<div class="gw_main_left">
			<img src="{$main_icon}" alt="{$parsedData.current_condition}" />
		</div>
		<div class="gw_main_right">
			{if $config.showCity == 1}<h2>{$config.fcity}</h2>{/if}
			<p class="gw_temp">
				{if $config.tempUnit == 'f'}{$parsedData.current_temp_f}&deg;F
				{else}{$parsedData.current_temp_c}&deg;C
				{/if}, {$parsedData.current_condition}
				{if $config.showHum == 1}, {$parsedData.current_humidity}{/if}
				{if $config.showWind == 1}, {$parsedData.current_wind}{/if}
			</p>
		</div>
	</div>
</div>