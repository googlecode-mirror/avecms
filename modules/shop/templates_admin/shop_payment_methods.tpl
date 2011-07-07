<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#PaymentMethods#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=paymentmethods&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="250" class="tableheader">{#SShipperName#}</td>
			<td class="tableheader">{#Position#}</td>
			<td class="tableheader">{#PaymentMethodActive#} </td>
			<td class="tableheader">&nbsp;</td>
		</tr>

		{foreach from=$methods item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td><input style="width:160px" type="text" name="Name[{$ss->Id}]" value="{$ss->Name|stripslashes}"></td>
				<td width="50">
					<input name="Position[{$ss->Id}]" type="text" value="{$ss->Position}" size="3" maxlength="3" />
				</td>

				<td width="100">
					<input type="radio" name="status[{$ss->Id}]" value="1" {if $ss->status=='1'}checked {/if}/>{#Yes#}&nbsp;
					<input type="radio" name="status[{$ss->Id}]" value="0" {if $ss->status=='0'}checked {/if}/>{#No#}
				</td>

				<td>
					<a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=editpaymentmethod&cp={$sess}&pop=1&Id={$ss->Id}','800','680','1','shopshipper');">{#DokEdit#}</a>
					{if $ss->Id!=1 && $ss->Id!=2 && $ss->Id!=3 && $ss->Id!=4 && $ss->Id!=5}
						&nbsp;|&nbsp;<a onclick="return confirm('{#DelMethodC#}')" href="index.php?do=modules&action=modedit&mod=shop&moduleaction=deletemethod&MId={$ss->Id}">{#DelMethod#}</a>
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

<h4>{#NewPaymentMethod#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=newmethod&cp={$sess}">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td class="first">
				<input style="width:250px" type="text" name="Name" value="{#SShipperName#}"> <input type="submit" class="button" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table>
</form>