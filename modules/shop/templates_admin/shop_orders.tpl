{literal}
<style type="text/css">
.orders_wait {background-color:#ccc; width:20px;height:20px; border:1px solid #fff}
.orders_progress {background-color:#FFCC00; width:20px;height:20px; border:1px solid #fff}
.orders_ok {background-color:#009900; width:20px;height:20px; border:1px solid #fff}
.orders_ok_send {background-color:#0099FF; width:20px;height:20px; border:1px solid #fff}
.orders_failed {background-color:#FF0000; width:20px;height:20px; border:1px solid #fff}
</style>
{/literal}
{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{if $smarty.request.pop==1}
{else}
{include file="$source/shop_topnav.tpl"}
{/if}
{*
<script language="javascript" src="../modules/shop/js/admin_funcs.js"></script>
*}
<h4>{#ProductOrdersSSearch#}</h4>

<div class="infobox" style="padding:0px">
	<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&search=1">
		<table width="100%" border="0" cellpadding="8" cellspacing="1">
			<tr>
				<td width="120" class="first">
					{#ProductOrdersSSearch#}&nbsp;<a title="{#ProductOrdersSSearchInf#}" href="#">[?]</a>
				</td>

				<td width="100" class="second">
					<input class="mod_shop_inputfields" style="width:170px" name="Query" id="pq" type="text" value="{$smarty.request.Query|stripslashes|escape:html}" />
				</td>

				<td width="130" class="first">
					<label for="pfpt">{#ProductOrdersSPFromTill#}</label>
				</td>

				<td class="second">
					<input class="mod_shop_inputfields" style="width:70px" type="text" name="price_start" value="{$smarty.post.price_start|stripslashes|escape:html|default:'1,00'}" />
					<input class="mod_shop_inputfields" style="width:70px" type="text" name="price_end" value="{$smarty.post.price_end|stripslashes|escape:html|default:'4000,00'}" />
				</td>
			</tr>

			<tr>
				<td width="120" class="first">
					<label for="mf">{#ProductOrdersSStatus#}</label>
				</td>

				<td width="100" class="second">
					<select style="width:170px" name="Status">
						<option value="egal">{#ProductDm#}</option>
						<option value="wait" {if $smarty.post.Status=='wait'}selected="selected"{/if}>{#StatusWait#}</option>
						<option value="progress" {if $smarty.post.Status=='progress'}selected="selected"{/if}>{#StatusProgress#}</option>
						<option value="ok" {if $smarty.post.Status=='ok'}selected="selected"{/if}>{#StatusOk#}</option>
						<option value="ok_send" {if $smarty.post.Status=='ok_send'}selected="selected"{/if}>{#StatusOkSend#}</option>
						<option value="failed" {if $smarty.post.Status=='failed'}selected="selected"{/if}>{#StatusFailed#}</option>
					</select>
				</td>

				<td width="130" class="first">
					{#ProductOrdersSpayment#}
				</td>

				<td class="second">
					<select style="width:140px" name="ZahlungsId">
						<option value="egal">{#ProductDm#}</option>
						{foreach from=$paymentMethods item=pm}
							<option value="{$pm->Id}" {if $smarty.request.ZahlungsId==$pm->Id}selected="selected"{/if}>{$pm->Name}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<tr>
				<td width="120" class="first">
					{#ProductOrdersSOdFrom#}
				</td>

				<td width="100" class="second">
					{html_select_date time=$ZeitStart prefix="start_" end_year="+0" start_year="-10" display_days=true month_format="%m" reverse_years=false day_size=1 field_order=DMY all_extra=""}
				</td>

				<td width="130" class="first">
					{#ProductOrdersPayShip#}
				</td>

				<td class="second">
					<select style="width:140px" name="VersandId">
						<option value="egal">{#ProductDm#}</option>
						{foreach from=$shippingMethods item=zm}
							<option value="{$zm->Id}" {if $smarty.request.VersandId==$zm->Id}selected="selected"{/if}>{$zm->Name}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<tr>
				<td width="120" class="first">{#ProductOrdersSOdTill#}</td>
				<td class="second">
					{html_select_date time=$ZeitEnde prefix="end_" end_year="+0" start_year="-10" display_days=true month_format="%m" reverse_years=false day_size=1 field_order=DMY all_extra=""}
				</td>

				<td class="first">
					<label for="rs">{#ProductDataSReduced#}</label>
				</td>

				<td class="second">
					<select class="mod_shop_inputfields" name="recordset" id="rs">
						{section name=recordset loop=200 step=5}
							{assign var=sel value=''}
							{if $smarty.request.recordset == ''}
								{if $smarty.section.recordset.index+5==10}
									{assign var=sel value='selected'}
								{/if}
							{else}
								{if $smarty.section.recordset.index+5==$smarty.request.recordset}
									{assign var=sel value='selected'}
								{/if}
							{/if}
							<option value="{$smarty.section.recordset.index+5}" {$sel}>{$smarty.section.recordset.index+5}</option>
						{/section}
					</select>
					{if $smarty.request.pop==1}
						<input type="hidden" name="pop" value="1" />
					{/if}

					<input type="submit" class="button" value="{#ButtonSearch#}" />
				</td>
			</tr>
		</table>
	</form>
</div>

<h4>{#ProductOrdersList#}</h4>

<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&search=1" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr class="tableheader">
			<td width="1%" nowrap="nowrap">&nbsp;</td>
			<td width="1%" nowrap="nowrap"><a class="header" href="index.php?Order={if $smarty.request.Order=='IdAsc'}IdDesc{else}IdAsc{/if}&do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&page={$smarty.request.page|default:1}">{#ProductOrdersOnr#}</a>	</td>
			<td width="5%">{#ProductOrdersTransId#}</td>
			<td><a class="header" href="index.php?Order={if $smarty.request.Order=='PaymentIdAsc'}PaymentIdDesc{else}PaymentIdAsc{/if}&do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&page={$smarty.request.page|default:1}">{#ProductOrdersSpmS#}</a></td>
			<td><a class="header" href="index.php?Order={if $smarty.request.Order=='ShippingIdAsc'}ShippingIdDesc{else}ShippingIdAsc{/if}&do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&page={$smarty.request.page|default:1}">{#ProductOrdersSshS#}</a></td>
			<td><a class="header" href="index.php?Order={if $smarty.request.Order=='IdAsc'}IdDesc{else}IdAsc{/if}&do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&page={$smarty.request.page|default:1}">{#ProductOrdersDate#}</a></td>
			<td><a class="header" href="index.php?Order={if $smarty.request.Order=='CustomerAsc'}CustomerDesc{else}CustomerAsc{/if}&do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&page={$smarty.request.page|default:1}">{#ProductOrdersCustomer#}</a></td>
			<td>{#ProductOrdersMailCT#}</td>
			<td align="right"><a class="header" href="index.php?Order={if $smarty.request.Order=='SummAsc'}SummDesc{else}SummAsc{/if}&do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}&page={$smarty.request.page|default:1}">{#ProductOrdersSumm#}</a></td>
			<td>&nbsp;</td>
			<td colspan="3" width="1%" align="center">{#Actions#}</td>
		</tr>

		{foreach from=$Orders item=i}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%" align="center" nowrap="nowrap">
					<input name="orders_{$i.Id}" type="checkbox" value="1" />
				</td>
				<td width="1%" nowrap="nowrap">{$i.Id}</td>
				<td width="5%">
					<a {if $i.ArtikelS}title="{#ProductOrdersSInf#} :: {$i.ArtikelS|escape:html}"{/if} href="#">{$i.TransId}</a>
					<br />
					{$i.ArtikelSVars}
				</td>
				<td>{$i.Zahlart}</td>
				<td width="1%" nowrap="nowrap">{$i.VersandArt|truncate:20}</td>
				<td width="1%" align="center" nowrap="nowrap" class="time">
					{$i.Datum|date_format:#DateFormatOrder#}
				</td>
				<td>
					<table width="100%" border="0" cellspacing="1" cellpadding="8">
						<tr>
							<td>{$i.Benutzer}</td>
							<td align="right"><small>{$i.BenId}</small></td>
						</tr>
					</table>
				</td>
				<td width="1%" align="center">{$i.BenutzerMail}</td>
				<td width="80" align="right">{$i.Gesamt}</td>
				<td align="center" width="1%"><span class="orders_{$i.Status}">&nbsp;&nbsp;&nbsp;</span></td>
				<td>
					<!-- ACTIONS -->
					<a title="{#EditOrder#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=showorder&cp={$sess}&pop=1&Id={$i.Id}','980','780','1','edit_order');">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="{#DokEdit#}" hspace="1" border="0" />
					</a>
				</td>
				<td>
					<a title="{#MarkDelOrder#}" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=mark_failed&cp={$sess}&Id={$i.Id}','1','1','1','markdel');">
						<img src="{$tpl_dir}/images/icon_del.gif" alt="{#ProductVarsEdit#}" border="0" />
					</a>
				</td>
				<td>
					<a title="{#DownloadsForUser#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=shop&moduleaction=shop_downloads&cp={$sess}&Id={$i.Id}&pop=1&User={$i.UserId}&N={$i.N}','sd','top=0,left=0,height=600,width=970,scrollbars=1');">
						<img hspace="2" src="{$tpl_dir}/images/icon_esd_download.gif" alt="{#ProductVarsEdit#}" border="0" />
					</a>
				</td>
			</tr>
		{/foreach}
	</table><br />

	<div class="second" style="padding:8px">
		{#ProductOrdersSSetInf#}&nbsp;
		<select name="StatusOrder">
			<option value="nothing">---</option>
			<option value="wait">{#ProductOrdersSSetToWait#}</option>
			<option value="progress">{#ProductOrdersSSetToProgress#}</option>
			<option value="failed">{#ProductOrdersSSetToFailed#}</option>
		</select>
	</div><br />

	{if $smarty.request.pop==1}
		<input type="hidden" name="pop" value="1" />
	{/if}

	<input class="button" type="submit" value="{#ButtonSave#}" />
{*	<button class="button" type="submit">{#ProductSave#}</button> *}
</form><br />

{if $page_nav}
	<div class="infobox">
		{$page_nav}
	</div><br />
{/if}
<br />

<table width="500" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<span class="orders_wait">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#StatusWait#}<br />
			<span class="orders_progress">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#StatusProgress#}<br />
			<span class="orders_ok">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#StatusOk#}<br />
			<span class="orders_ok_send">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#StatusOkSend#}<br />
			<span class="orders_failed">&nbsp;&nbsp;&nbsp;&nbsp;</span> {#StatusFailed#}
		</td>

		<td valign="top">
			<img class="absmiddle" src="{$tpl_dir}/images/icon_edit.gif" alt="{#DokEdit#}" hspace="1" border="0" />&nbsp;{#ProductOrdersSEdit#}<br />
			<img class="absmiddle" src="{$tpl_dir}/images/icon_del.gif" alt="{#ProductVarsEdit#}" border="0" />&nbsp;{#ProductOrdersSMarkFailed#}
		</td>
	</tr>
</table>

{/strip}