<div class="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#gWEATHER_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#gWEATHER_MODULE_INFO#}</div>
</div>
<br>

<form method="post" action="index.php?do=modules&action=modedit&mod=gweather&moduleaction=1&cp={$sess}&sub=save">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="10" />
		<col width="220" />
		<tr class="tableheader">
			<td colspan="3">{#gWEATHER_MODULE_EDIT#}</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_CITY_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_CITY#}</td>
			<td class="second"><input type="text" name="city" value="{$row.city}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_FCITY_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_FCITY#}</td>
			<td class="second"><input type="text" name="fullcity" value="{$row.fullcity}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_LANG_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_LANG#}</td>
			<td class="second"><input type="text" name="language" value="{$row.language}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_LATITUDE_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_LATITUDE#}</td>
			<td class="second"><input type="text" name="lat" value="{$row.lat}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_LONGITUDE_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_LONGITUDE#}</td>
			<td class="second"><input type="text" name="lon" value="{$row.lon}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_TIMEZONE_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_TIMEZONE#}</td>
			<td class="second"><input type="text" name="timezone" value="{$row.timezone}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_SHOWCITY_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_SHOWCITY#}</td>
			<td class="second">
				<select name="showCity" id="showCity">
					<option value="1"{if $row.showCity=="1"} selected="selected"{/if}>{#gWEATHER_ENABLE#}</option>
					<option value="0"{if $row.showCity=="0"} selected="selected"{/if}>{#gWEATHER_DISABLE#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_SHOWHUM_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_SHOWHUM#}</td>
			<td class="second">
				<select name="showHum" id="showHum">
					<option value="1"{if $row.showHum=="1"} selected="selected"{/if}>{#gWEATHER_ENABLE#}</option>
					<option value="0"{if $row.showHum=="0"} selected="selected"{/if}>{#gWEATHER_DISABLE#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_SHOWWIND_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_SHOWWIND#}</td>
			<td class="second">
				<select name="showWind" id="showWind">
					<option value="1"{if $row.showWind=="1"} selected="selected"{/if}>{#gWEATHER_ENABLE#}</option>
					<option value="0"{if $row.showWind=="0"} selected="selected"{/if}>{#gWEATHER_DISABLE#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_UNIT_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_UNIT#}</td>
			<td class="second">
				<select name="tempUnit" id="tempUnit">
					<option value="c"{if $row.tempUnit=="c"} selected="selected"{/if}>Celsius</option>
					<option value="f"{if $row.tempUnit=="f"} selected="selected"{/if}>Farhenheit</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_AMOUNT_DAYS_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_AMOUNT_DAYS#}</td>
			<td class="second">
				<select name="amountDays" id="amountDays">
					<option value="0"{if $row.amountDays=="0"} selected="selected"{/if}>0</option>
					<option value="1"{if $row.amountDays=="1"} selected="selected"{/if}>1</option>
					<option value="2"{if $row.amountDays=="2"} selected="selected"{/if}>2</option>
					<option value="3"{if $row.amountDays=="3"} selected="selected"{/if}>3</option>
					<option value="4"{if $row.amountDays=="4"} selected="selected"{/if}>4</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_CICONSIZE_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_CICONSIZE#}</td>
			<td class="second">
				<select name="current_icon_size" id="current_icon_size">
					<option value="128"{if $row.current_icon_size=="128"} selected="selected"{/if}>128px x 128px</option>
					<option value="64"{if $row.current_icon_size=="64"} selected="selected"{/if}>64px x 64px</option>
					<option value="32"{if $row.current_icon_size=="32"} selected="selected"{/if}>32px x 32px</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_FICONSIZE_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_FICONSIZE#}</td>
			<td class="second">
				<select name="forecast_icon_size" id="forecast_icon_size">
					<option value="128"{if $row.forecast_icon_size=="128"} selected="selected"{/if}>128px x 128px</option>
					<option value="64"{if $row.forecast_icon_size=="64"} selected="selected"{/if}>64px x 64px</option>
					<option value="32"{if $row.forecast_icon_size=="32"} selected="selected"{/if}>32px x 32px</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_CACHETIME_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_CACHETIME#}</td>
			<td class="second"><input type="text" name="cacheTime" value="{$row.cacheTime}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_ENCODING_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_ENCODING#}</td>
			<td class="second"><input type="text" name="encoding" value="{$row.encoding}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_USECSS_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_USECSS#}</td>
			<td class="second">
				<select name="useCSS" id="useCSS">
					<option value="1"{if $row.useCSS=="1"} selected="selected"{/if}>{#gWEATHER_ENABLE#}</option>
					<option value="0"{if $row.useCSS=="0"} selected="selected"{/if}>{#gWEATHER_DISABLE#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_NAMECSS_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_NAMECSS#}</td>
			<td class="second"><input type="text" name="nameCSS" value="{$row.nameCSS}" /></td>
		</tr>

		<tr>
			<td class="first"><a title="{#gWEATHER_TEMPLATE_DESC#}" href="javascript:void(0);" style="cursor:help;"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first">{#gWEATHER_TEMPLATE#}</td>
			<td class="second"><input type="text" name="template" value="{$row.template}" /></td>
		</tr>

		<tr>
			<td class="third" colspan="3"><input type="submit" class="button" value="{#gWEATHER_BUTTON_SAVE#}" /></td>
		</tr>
	</table>
</form>