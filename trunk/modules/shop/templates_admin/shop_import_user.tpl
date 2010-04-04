{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#ModName#}</h2></div>
	<div class="HeaderText">{#ImportUserInf#}</div>
</div><br />

<div class="infobox">
	{#ImportInfWarn#}
</div>

{if $ImportOk==1}
	<br />
	<h2>{#ImportOk#}</h2><br />
{/if}

{if $next!=1}
	<h4>{#ImportUserStep1#}</h4>

	<form method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=userimport&cp={$sess}&pop=1&sub=importcsv" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr>
				<td width="100" class="first">
					<strong>{#ImportDataFile#}</strong><br />
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
	<h4>{#ImportUserStep2#}</h4>

	<form action="index.php?do=modules&action=modedit&mod=shop&moduleaction=userimport&cp={$sess}&pop=1&sub=importcsv2" method="post">
	<div class="infobox">{#ImportInfHeader#}</div><br />
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr>
				<td width="220" nowrap class="tableheader">{#ImportSource#} </td>
				<td nowrap class="tableheader">&nbsp; &raquo;&nbsp; </td>
				<td class="tableheader">{#ImportTarget#}</td>
			</tr>

			{foreach from=$field_table item=item}
				<tr class="{cycle name='fs' values='second,first'}">
					{* $key==$item.my_field || $key==$item.csv_field *}
					<td width="220"> {$item.csv_field}&nbsp; </td>
					<td width="1%"><strong>&nbsp; &raquo;&nbsp; </strong></td>
					<td>
						<select name="field_{$item.id}">
							<option value=""></option>
							{foreach from=$available_fields item=field key=key}
								{assign var="keks_prefix" value="field_$key"}
								{assign var="keks" value=""}
								{assign var="keks_check" value="field_$item.csv_field"}
								<option value="{$key}"{if ($key==$item.my_field || $key==$item.csv_field)} selected="selected"{/if}>
									{$field}{* ($key==$item.my_field || $key==$item.csv_field) || ({$key} - {$smarty.cookies.$keks_prefix}) *}
								</option>
								{assign var="keks_prefix" value=""}
							{/foreach}
						</select>
					</td>
				</tr>
				{assign var="keks" value=""}
				{assign var="keks_check" value=""}
			{/foreach}

			<tr>
				<td colspan="3" class="tableheader">{#ImportOptions#}</td>
			</tr>

			<tr>
				<td width="220" class="second">{#ImportUpdateMethod#}</td>
				<td colspan="2" class="second">
					<input name="existing" type="radio" value="replace" checked="checked" />
					{#ImportOverv#}<br />
					<input name="existing" type="radio" value="ignore" />
					{#ImportIgnore#}
				</td>
			</tr>

			{if $method == 'shop'}
				<tr>
					<td width="220" class="second">{#ImportUserGroup#}</td>
					<td colspan="2" class="second">
						<select name="Benutzergruppe">
							<option value="FILE">{#ImportUserGroupStandard#}</option>
							{foreach from=$Ugroups item=g}
								{if $g->Benutzergruppe!=2}
									<option value="{$g->Benutzergruppe}">{$g->Name|escape:html}</option>
								{/if}
							{/foreach}
						</select>
					</td>
				</tr>
			{/if}

			<tr>
				<td width="220" class="second">{#ImportDelData#}</td>
				<td colspan="2" class="second">
					<input name="DelData" type="checkbox" id="DelData" value="1" />{#Yes#}
				</td>
			</tr>

			<tr>
				<td width="220" class="thirdrow">&nbsp;</td>
				<td colspan="2" class="thirdrow">
					<input name="fileid" type="hidden" id="fileid" value="{$fileid}" />&nbsp;
					<input type="submit" class="button" value="{#ImportStart#}" />
				</td>
			</tr>
		</table>
	</form>
{/if}

{/strip}