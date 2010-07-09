<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">{#CustomerDInf#}</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#CustomerDiscounts#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=customerdiscounts&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="200" class="tableheader">{#CustomerDGroup#}</td>
			<td class="tableheader">{#CouponCodePercent#}</td>
		</tr>

		{foreach from=$Groups item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="200"><strong>{$ss->user_group_name|escape}</strong></td>
				<td><input name="Wert[{$ss->user_group}]" type="text" style="width:60px" value="{$ss->Wert}" maxlength="10" /> %</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>