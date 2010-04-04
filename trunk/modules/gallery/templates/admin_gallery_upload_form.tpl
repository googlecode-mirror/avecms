
<!-- admin_gallery_upload_form.tpl -->
{strip}

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#Upload#}</h2>
	</div>
	<div class="HeaderText">
		{#UploadInfo#}
		<strong>{foreach from=$allowed item=a}{$a} {/foreach}</strong>
	</div>
</div>
<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#GalView#}</a>
</div><br />

{if $not_writeable == 1}
	<div class="infobox">{#ErrorFolderStart#}{$upload_dir}{#ErrorFolderEnd#}</div>
{else}
	<form method="post" action="{$formaction}" enctype="multipart/form-data">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			{section name=upload_fields loop=5}
				<tr>
					<td width="1%" class="second">#{$smarty.section.upload_fields.index+1}</td>
					<td width="200" class="second"><strong>{#IName#}</strong></td>
					<td class="second">
						<input name="image_title[]" type="text" id="image_title[]" style="width:300px" />
					</td>
				</tr>

				<tr>
					<td width="1%" class="first">&nbsp;</td>
					<td width="200" class="first"><strong>{#ISelect#}</strong></td>
					<td class="first">
						<input name="file[]" type="file" id="file[]" size="43" style="width:250px" />
					</td>
				</tr>
			{/section}

			<tr>
				<td width="1%" class="second">&nbsp;</td>
				<td width="200" class="second"><strong>{#Shrink#}</strong></td>
				<td class="second">
					<select name="shrink" id="shrink">
						<option>&nbsp;</option>
						<option value="75">{#To75#}</option>
						<option value="50">{#To50#}</option>
						<option value="25">{#To25#}</option>
					</select>
				</td>
			</tr>

			<tr>
				<td width="1%" class="first">&nbsp;</td>
				<td width="200" class="first"><strong>{#MaxSize#}</strong></td>
				<td class="first">
					<input name="maxsize" type="text" value="800" maxlength="4" size="4" />&nbsp;px
				</td>
			</tr>

			<tr>
				<td width="1%" class="second">&nbsp;</td>
				<td width="200" class="second"><strong>{#LoadFromFolder#}</strong></td>
				<td class="second">
					<input name="fromfolder" type="checkbox" id="fromfolder" value="1" />
				</td>
			</tr>

			<tr>
				<td class="first" colspan="3">
					<input type="submit" class="button" value="{#ButtonSave#}" />
				</td>
			</tr>
		</table><br />
	</form>
{/if}

{/strip}
<!-- /admin_gallery_upload_form.tpl -->
