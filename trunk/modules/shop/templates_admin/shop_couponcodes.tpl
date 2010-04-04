{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}

<h4>{#CouponCodes#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=couponcodes&cp={$sess}&sub=save" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr>
			<td width="1%" class="tableheader" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
			<td width="100" class="tableheader">{#CouponCodeCode#}</td>
			<td class="tableheader" align="center">{#CouponCodePercent#}</td>
			<td width="130" class="tableheader" align="center">{#CouponForAll#}</td>
			<td width="130" align="center" class="tableheader">{#CouponMultiUse#} </td>
			<td class="tableheader" >{#CouponGuilty#}</td>
			<td class="tableheader" >{#CouponTransId#}</td>
		</tr>

		{foreach from=$couponCodes item=ss}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%" align="center">
					<input title="{#Delete#}" name="Del[{$ss->Id}]" type="checkbox" value="1" />
				</td>

				<td>
					<input name="Code[{$ss->Id}]" type="text" style="width:100px" value="{$ss->Code|stripslashes}" maxlength="100" {if $ss->Eingeloest==1}disabled="disabled" {/if}/>
				</td>

				<td width="50" align="center">
					<input name="Prozent[{$ss->Id}]" type="text" style="width:60px" value="{$ss->Prozent}" maxlength="10" {if $ss->Eingeloest==1}disabled="disabled" {/if}/>
				</td>

				<td align="center">
					<input type="radio" name="AlleBenutzer[{$ss->Id}]" value="1" {if $ss->AlleBenutzer=='1'}checked {/if} {if $ss->Eingeloest==1}disabled="disabled" {/if}>{#Yes#}&nbsp;
					<input type="radio" name="AlleBenutzer[{$ss->Id}]" value="0" {if $ss->AlleBenutzer=='0'}checked {/if} {if $ss->Eingeloest==1}disabled="disabled" {/if}>{#No#}
				</td>

				<td align="center">
					<input type="radio" name="Mehrfach[{$ss->Id}]" value="1" {if $ss->Mehrfach=='1'}checked {/if} {if $ss->Eingeloest==1}disabled="disabled" {/if}/>{#Yes#}&nbsp;
					<input type="radio" name="Mehrfach[{$ss->Id}]" value="0" {if $ss->Mehrfach=='0'}checked {/if} {if $ss->Eingeloest==1}disabled="disabled" {/if}/>{#No#}
				</td>

				<td>
					<input style="width:80px" name="GueltigVon[{$ss->Id}]" type="text" value="{$ss->GueltigVon}" maxlength="10" {if $ss->Eingeloest==1}disabled="disabled" {/if}/>
					&nbsp;-&nbsp;
					<input style="width:80px" name="GueltigBis[{$ss->Id}]" type="text" value="{$ss->GueltigBis}" maxlength="10" {if $ss->Eingeloest==1}disabled="disabled" {/if}/>
				</td>

				<td>
					{if $ss->BestellId != ''}
						<a title="{#CouponTransId#} :: {$ss->BIdLink}" href="#">{#CouponShowTransIds#}</a>
					{else}
						-
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form><br />
<br />

{if $page_nav}
	{$page_nav}<br />
	<br />
{/if}

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=couponcodes_new&cp={$sess}">

	<h4>{#CouponcodeNew#}</h4>

	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr class="tableheader">
			<td width="100">{#CouponCodeCode#}</td>
			<td width="100" align="center">{#CouponCodePercent#}</td>
			<td width="130" align="center">{#CouponForAll#}</td>
			<td width="130" align="center">{#CouponMultiUse#} </td>
			<td>&nbsp;</td>
		</tr>

		<tr>
			<td width="100" class="second">
				<input name="Code" type="text" id="Code" style="width:100px" value="{$randomVar}" maxlength="100">
			</td>
			<td width="100" align="center" class="second">
				<input name="Prozent" type="text" id="Prozent" style="width:60px" value="10.00" maxlength="10">
			</td>
			<td align="center" class="second">
				<input type="radio" name="AlleBenutzer" value="1" />{#Yes#}&nbsp;
				<input name="AlleBenutzer" type="radio" value="0" checked="checked" />{#No#}
			</td>
			<td align="center" class="second">
				<input type="radio" name="Mehrfach" value="1" />{#Yes#}&nbsp;
				<input name="Mehrfach" type="radio" value="0" checked="checked" />{#No#}
			</td>
			<td class="second">&nbsp;</td>
		</tr>
	</table><br />

	<input type="submit" class="button" value="{#ButtonSave#}">
</form>

{/strip}