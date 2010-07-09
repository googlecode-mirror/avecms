{if $werror == ''}
	{if $config.useCSS == 1}
		<link href="{$ABS_PATH}modules/gweather/templates/weather.css" rel="stylesheet" type="text/css" media="screen" />
	{/if}
	<div class="gw_main" id="{$config.module_unique_id}">
		<div class="gw_current">
			<div class="gw_main_left">
				<img src="{$main_icon}" alt="{$parsedData.current_condition}" />
				<p class="gw_temp">{if $config.tempUnit == 'f'}{$parsedData.current_temp_f}&deg;F{else} {$parsedData.current_temp_c}&deg;C{/if}</p>
			</div>
			<div class="gw_main_right">
				{if $config.showCity == 1}<h2>{$config.fcity}</h2>{/if}
				<p class="gw_condition">{$parsedData.current_condition}</p>
				{if $config.showHum == 1}<p class="gw_humidity">{$parsedData.current_humidity}</p>{/if}
				{if $config.showWind == 1}<p class="gw_wind">{$parsedData.current_wind}</p>{/if}
			</div>
		</div>
		{if $config.amountDays > 0}
			<ul class="gw_next_days">
				{foreach name=fc from=$parsedData.forecast item=fday}
					{if $smarty.foreach.fc.iteration <= $config.amountDays}
						<li class="aitems-{$config.amountDays}">
							<div class="gw_fday">
								<span class="gw_day">{$fday.day}</span>
								<img src="{$fday.ficon}" title="{$fday.condition}" alt="{$fday.condition}" />
								<p class="gw_day_temp">
									<span class="gw_day_day">{$fday.shigh}</span>
									<span class="gw_day_night">{$fday.slow}</span>
								</p>
							</div>
						</li>
					{/if}
				{/foreach}
			</ul>
		{/if}
	</div>
{else}
	{$werror}
{/if}