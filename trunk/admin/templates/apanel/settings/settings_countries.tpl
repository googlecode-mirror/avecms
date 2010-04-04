{strip}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_settings">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SETTINGS_COUNTRIES#}</h2></div>
	<div class="HeaderText">{#SETTINGS_COUNTRY_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<h4>{#SETTINGS_INFO#}</h4>

<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="index.php?do=settings&amp;cp={$sess}">
					<div class="taskTitle">{#SETTINGS_MAIN#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<h4>{#SETTINGS_COUNTRIES_ALL#}</h4>

<form method="post" action="index.php?do=settings&sub=countries&cp={$sess}&save=1">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td>{#SETTINGS_COUNTRY_NAME#}</td>
			<td>{#SETTINGS_ACTIVE#}</td>
			<td>{#SETTINGS_IN_EC#}</td>
		</tr>

		{foreach from=$laender item=land name=l}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="100">
					<input name="LandName[{$land.Id}]" type="text" id="LandName[{$land.Id}]" value="{$land.LandName}" size="35" />
				</td>

				<td width="100" nowrap>
					<input type="radio" name="Aktiv[{$land.Id}]" value="1"{if $land.Aktiv==1} checked{/if} />{#SETTINGS_YES#}&nbsp;
					<input type="radio" name="Aktiv[{$land.Id}]" value="2"{if $land.Aktiv==2} checked{/if} />{#SETTINGS_NO#}
				</td>

				<td>
					<input type="radio" name="IstEU[{$land.Id}]" value="1"{if $land.IstEU==1} checked{/if} />{#SETTINGS_YES#}&nbsp;
					<input type="radio" name="IstEU[{$land.Id}]" value="2"{if $land.IstEU==2} checked{/if} />{#SETTINGS_NO#}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#SETTINGS_BUTTON_SAVE#}" /><br />
</form><br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div><br />
{/if}
<br />

{/strip}