<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#DownloadsFor#} <span style="color: #000;">&nbsp;&gt;&nbsp;{$smarty.get.N|urldecode|escape|stripslashes}</span></h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />
{if $Items}
<form name="form2" method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=shop_downloads&cp={$sess}&Id={$smarty.get.Id}&User={$smarty.get.User|urlencode}&sub=save&pop=1">
	<table width="100%" border="0" cellspacing="1" cellpadding="8">
		<tr class="tableheader">
			<td>{#DownFile#}</td>
			<td width="100">URL</td>
			<td>{#DownTill#}</td>
			<td>{#DownComment#}</td>
			<td>{#DownCommentU#} </td>
			<td>{#DownDel#}</td>
		</tr>

		{foreach from=$Items item=file}
			<tr class="{cycle name='fs' values='first,second}">
				<td >{$file->Artname}
				<input type="hidden" name="Id[{$file->Id}]" value="{$file->Id}" />
				</td>

				<td width="100"><input type="text" name="UrlLizenz[{$file->Id}]" value="{$file->UrlLizenz}"></td>

				<td nowrap="nowrap">
					<select name="Tag[{$file->Id}]">
						{section name=tag loop=31}
							<option value="{$smarty.section.tag.index+1}" {if $file->TagEnde==$smarty.section.tag.index+1}selected="selected" {/if}>{$smarty.section.tag.index+1}</option>
						{/section}
					</select>

					<select name="Monat[{$file->Id}]">
						{section name=monat loop=12}
							<option value="{$smarty.section.monat.index+1}" {if $file->MonatEnde==$smarty.section.monat.index+1}selected="selected" {/if}>{$smarty.section.monat.index+1}</option>
						{/section}
					</select>

					<select name="Jahr[{$file->Id}]">
						{section name=jahr loop=$Start+15 start=$Start}
							<option value="{$smarty.section.jahr.index+1}" {if $file->JahrEnde==$smarty.section.jahr.index+1}selected="selected" {/if}>{$smarty.section.jahr.index+1}</option>
						{/section}
					</select>
				</td>

				<td><textarea name="KommentarAdmin[{$file->Id}]">{$file->KommentarAdmin|escape}</textarea></td>

				<td><textarea name="KommentarBenutzer[{$file->Id}]">{$file->KommentarBenutzer|escape}</textarea></td>

				<td>
					<input type="checkbox" name="Del[{$file->Id}]" value="1" />
				</td>
			</tr>

			<tr class="{cycle name='fs2' values='first,second}">
				<td>{#DownLocked#}</td>
				<td>
					<input type="radio" name="Gesperrt[{$file->Id}]" value="1" {if $file->Gesperrt==1}checked="checked"{/if}>{#Yes#}&nbsp;
					<input type="radio" name="Gesperrt[{$file->Id}]" value="0" {if $file->Gesperrt==0}checked="checked"{/if}>{#No#}
				</td>

				<td>{#DownLockedReason#}</td>

				<td colspan="3" ><input type="text" value="{$file->GesperrtGrund|escape}" style="width:250px;" name="GesperrtGrund[{$file->Id}]"></td>
			</tr>
		{/foreach}
	</table>

	<input type="submit" class="button" value="{#ShopButtonUpdate#}">
</form>
{/if}
<p>&nbsp;</p>

<form name="form1" method="post" action="index.php?do=modules&action=modedit&mod=shop&moduleaction=shop_downloads&cp={$sess}&Id={$smarty.get.Id}&User={$smarty.get.User|urlencode}&sub=new&pop=1">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#DownNew#}</td>
		</tr>

		<tr>
			<td width="180" class="first">{#DownFor#} </td>
			<td class="second">
				<select name="file" id="file">
					{foreach from=$Files item=file}
						<option value="{$file->ArtNr}">{$file->ArtName}</option>
					{/foreach}
				</select>
			</td>
		</tr>


		<tr>
			<td width="180" class="first">{#DownTill#}</td>
			<td class="second">
				{assign var=extra value=""}
				{html_select_date time=$row_doc->DokStart prefix="filetime" start_year="-5" end_year="+10" display_days=true month_format="%B" reverse_years=false day_size=1 field_order=DMY all_extra=$extra}
			</td>
		</tr>
	</table>

	<input type="submit" class="button" value="{#ShopButtonAdd#}">
</form>

<p>&nbsp;</p>

<hr noshade="noshade" size="1">

<p align="center">
	<input type="button" onclick="window.close();" class="button" value="{#WindowClose#}">
</p>