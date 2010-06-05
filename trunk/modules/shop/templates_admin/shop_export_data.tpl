<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/shop_topnav.tpl"}
{*
<script language="javascript" src="../modules/shop/js/admin_funcs.js"></script>
*}
<h4>{#DataExport#}</h4>

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=dataexport&cp={$sess}&sub=export">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#ExportUser#}</td>
		</tr>

		<tr>
			<td width="250" class="first">{#ExportUserGroup#}</td>
			<td class="second">
				<select name="groups[]" size="5" multiple="multiple" id="select">
					{section name=customer loop=$groups}
						<option value="{$groups[customer].Benutzergruppe}" selected="selected">{$groups[customer].Name}</option>
					{/section}
				</select>
			</td>
		</tr>

		<tr>
			<td width="250" class="first">{#ExportFileType#}</td>
			<td class="second">
				<input name="format" type="radio" value="csv" checked="checked" />csv&nbsp;
				<input name="format" type="radio" value="txt" />txt
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportFieldSep#}</td>
			<td class="second">
				<input name="separator" type="text" id="separator" value=";" size="5" />
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportFieldEnc#}</td>
			<td class="second">
				<input name="enclosed" type="text" id="enclosed" value="&quot;" size="5">
			</td>
		</tr>

		<tr>
		<td class="first">{#ExportRowsSplit#}</td>
		<td class="second">
			<input name="cutter" type="text" id="cutter" value="\r\n" size="5">
		</td>
		</tr>

		<tr>
		<td width="250" class="first">{#ExportSetNameFirst#}</td>
		<td class="second">
			<input name="showcsvnames" type="checkbox" id="showcsvnames" value="yes" checked="checked">
		</td>
		</tr>

		<tr>
		<td class="first">&nbsp;</td>
		<td class="second">
			<span class="secondrow">
				<input name="submit" type="submit" class="button" value="{#ExportStart#}" />&nbsp;
				<input name="t" type="hidden" id="t" value="user" />
			</span>
		</td>
		</tr>
</table>
</form><br />
<br />

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=dataexport&cp={$sess}&sub=export">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#ExportOrders#}</td>
		</tr>

			<tr>
			<td width="250" class="first">{#ExportFileType#}</td>

			<td class="second">
				<input name="format" type="radio" value="csv" checked="checked" />csv&nbsp;
				<input name="format" type="radio" value="txt" />txt
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportFieldSep#}</td>
			<td class="second">
				<input name="separator" type="text" id="separator" value=";" size="5">
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportFieldEnc#}</td>
			<td class="second">
				<input name="enclosed" type="text" id="enclosed" value="&quot;" size="5">
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportRowsSplit#}</td>
			<td class="second">
				<input name="cutter" type="text" id="cutter" value="\r\n" size="5">
			</td>
		</tr>

		<tr>
			<td width="250" class="first">{#ExportSetNameFirst#}</td>
			<td class="second">
				<input name="showcsvnames" type="checkbox" id="showcsvnames" value="yes" checked="checked">
			</td>
		</tr>

		<tr>
			<td class="first">&nbsp;</td>
			<td class="second">
				<span class="secondrow">
					<input name="submit" type="submit" class="button" value="{#ExportStart#}" />&nbsp;
					<input name="t" type="hidden" id="t" value="orders" />
				</span>
			</td>
		</tr>
	</table>
</form><br />
<br />

<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=dataexport&cp={$sess}&sub=export">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#ExportProducts#}</td>
		</tr>

		<tr>
			<td class="first">{#ExportCategs#}</td>
			<td class="second">
				<select name="groups[]" size="5" multiple="multiple" id="KatId[]" style="width:250px">
					{foreach from=$ProductCategs item=pc}
						<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} selected>{$pc->visible_title}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="250" class="first">{#ExportFileType#}</td>
			<td class="second">
				<input name="format" type="radio" value="csv" checked="checked" />csv&nbsp;
				<input name="format" type="radio" value="txt" />txt
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportFieldSep#}</td>
			<td class="second">
				<input name="separator" type="text" id="separator" value=";" size="5">
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportFieldEnc#}</td>
			<td class="second">
				<input name="enclosed" type="text" id="enclosed" value="&quot;" size="5">
			</td>
		</tr>

		<tr>
			<td class="first">{#ExportRowsSplit#}</td>
			<td class="second">
				<input name="cutter" type="text" id="cutter" value="\r\n" size="5">
			</td>
		</tr>

		<tr>
			<td width="250" class="first">{#ExportSetNameFirst#}</td>
			<td class="second">
				<input name="showcsvnames" type="checkbox" id="showcsvnames" value="yes" checked="checked">
			</td>
		</tr>

		<tr>
			<td class="first">&nbsp;</td>
			<td class="second">
				<span class="secondrow">
					<input name="submit" type="submit" class="button" value="{#ExportStart#}" />&nbsp;
					<input name="t" type="hidden" id="t" value="articles" />
				</span>
			</td>
		</tr>
	</table>
</form>