<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">{#ImportInf#}</div>
</div><br />

<div class="infobox">{#ImportInfWarn#}</div><br />

{if $next!=1}
	<h4>{#ImportDataStep1#}</h4>

	<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=shopimport&cp={$sess}&pop=1&sub=importcsv" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr>
				<td width="100" class="first"> <strong>{#ImportDataFile#}</strong> <br />
				</td>
				<td class="second">
					{if $error}
						<div style="padding:4px; border:1px solid #FF0000; background-color:#FFFFCC; color:#FF0000">
							<strong>{#ImportDataError#}</strong><br />
							{$error}
						</div><br />
					{/if}
					<input name="csvfile" type="file" id="csvfile" size="40" />
				</td>
			</tr>

			<tr>
				<td class="first">&nbsp;</td>
				<td class="second">
					<input type="submit" class="button" value="{#ImportDataButtonTo2#}" />
				</td>
			</tr>
		</table>
	</form>
{/if}

{if $next==1}
	<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=shopimport&cp={$sess}&pop=1&sub=importcsv2" method="post">
	<h4>{#ImportDataStep2#}</h4>

	<div class="infobox">{#ImportInfHeader#}</div><br />
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr>
				<td width="10%" nowrap class="tableheader"><strong>{#ImportSource#}</strong> </td>
				<td nowrap class="tableheader"><strong>&nbsp; &raquo;&nbsp; </strong></td>
				<td class="tableheader"><strong>{#ImportTarget#}</strong></td>
			</tr>

			{foreach from=$field_table item=item}
				<tr class="{cycle name='fs' values='second,first'}">
					<td width="10%"> {$item.csv_field}&nbsp; </td>
					<td width="1%"><strong>&nbsp; &raquo;&nbsp; </strong></td>
					<td>
						<select name="field_{$item.id}">
							<option value=""></option>
							{foreach from=$available_fields item=field key=key}
								<option value="{$key}"{if $key==$item.my_field || $key==$item.csv_field} selected="selected"{/if}>{$field}</option>
							{/foreach}
						</select>
					</td>
				</tr>
			{/foreach}

			<tr>
				<td colspan="3" class="tableheader">{#ImportOptions#}</td>
			</tr>

			<tr>
				<td width="10%" class="second">{#ImportUpdateMethod#}</td>
				<td colspan="2" class="second">
					<input name="existing" type="radio" value="replace" checked="checked" />
					{#ImportOverv#}<br>
					<input name="existing" type="radio" value="ignore" />
					{#ImportIgnore#}
				</td>
			</tr>

			{if $method == 'shop'}
				<tr>
					<td class="second">{#ImportConvertNB#}</td>
					<td colspan="2" class="second">
						<input name="netto_to_brutto" type="checkbox" id="netto_to_brutto" value="1" />
						{#ImportConvertNBYes#}
						<input name="mpli" type="text" id="mpli" value="16" size="3" maxlength="2" />%
					</td>
				</tr>
			{/if}

			<tr>
				<td class="second">{#ImportDelData#}</td>
				<td colspan="2" class="second">
					<input name="DelData" type="checkbox" id="DelData" value="1" />{#Yes#}
				</td>
			</tr>

			<tr>
				<td width="10%" class="thirdrow">&nbsp;</td>
				<td colspan="2" class="thirdrow"><input name="fileid" type="hidden" id="fileid" value="{$fileid}">
					<input type="submit" class="button" value="{#ImportStart#}" />
				</td>
			</tr>
		</table>
	</form>
{/if}