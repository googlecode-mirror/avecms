{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#YML_ShopSettings#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=settingsyml&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="300" valign="top" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#SettingsName#}</td>
			<td class="tableheader">{#SettingsValue#}</td>
		</tr>

		<tr>
			<td>{#YML_CompanyName#}</td>
			<td><input name="company_name" type="text" id="company_name" size="40" value="{$row->company_name}" style="width: 500px" /></td>
		</tr>

		<tr>
			<td>{#YML_Custom#}</td>
			<td>
				{html_options name=custom options=$shipper_times selected=$row->custom style="width:300px"}
			</td>
		</tr>

		<tr>
			<td>{#YML_Delivery#}</td>
			<td>
				{html_options name=delivery options=$shipper_times selected=$row->delivery style="width:300px"}
			</td>
		</tr>

		<tr>
			<td>{#YML_Downloadable#}</td>
			<td>
				{html_options name=downloadable options=$shipper_times selected=$row->downloadable style="width:300px"}
			</td>
		</tr>

		<tr>
			<td>{#YML_DeliveryLocal#}</td>
			<td>
				{html_options name=delivery_local options=$shipper_method selected=$row->delivery_local style="width:300px"}
			</td>
		</tr>

		<tr>
			<td>{#YML_TrackLabel#}</td>
			<td>
				<input type="radio" value="1" name="track_label" {if $row->track_label==1}checked="checked" {/if}/>{#Yes#}
				<input type="radio" value="0" name="track_label" {if $row->track_label==0}checked="checked" {/if}/>{#No#}
			</td>
		</tr>
	</table><br />

	<input accesskey="s" type="submit" value="{#ButtonSave#}" class="button" />
</form>

{/strip}