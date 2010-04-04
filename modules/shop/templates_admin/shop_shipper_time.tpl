{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#TimeShipping#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=timeshipping&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="1%" class="tableheader" align="center"><img src="{$tpl_dir}/images/icon_18.gif" alt="" hspace="2" border="0" /></td>
			<td width="160" class="tableheader">{#SShipperName#}</td>
		</tr>

		{foreach from=$st item=ss}
			<tr class="{cycle name='shipper' values='first,second'}">
				<td>
					<input title="{#Delete#}" name="Del[{$ss->Id}]" type="checkbox" id="Del[{$ss->Id}]" value="1" />
				</td>

				<td>
					<input style="width:250px" type="text" name="Name[{$ss->Id}]" value="{$ss->Name|escape:html|stripslashes}" />
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

<h4>{#TimeShippingNew#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=timeshippingnew&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="first">
				<input name="Name" type="text" style="width:250px" value="{#SShipperName#}" />&nbsp;
				<input type="submit" class="button" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table>
</form>

{/strip}