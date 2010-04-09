
<!-- admin_gallery_image.tpl -->
{strip}

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#Overview#}</h2>
	</div>
	<div class="HeaderText">{#OverviewT#}</div>
</div>

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#GalView#}</a>
</div><br />

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
{/if}

<form name="kform" method="post" action="index.php?do=modules&action=modedit&mod=gallery&moduleaction=showimages&id={$smarty.request.id}&cp={$sess}&sub=save&page={$smarty.request.page}">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="20">
		<col width="{$thumb_width}">
		<col width="366">
		<tr class="tableheader">
			<td align="center">
				<input name="allbox" type="checkbox" id="d" onclick="selall();" value="" />
			</td>
			<td>{#FilePrev#}</td>
			<td>{#FileTitle#} / {#FileDesc#}</td>
			<td>{#MoreInfos#}</td>
		</tr>

		{foreach from=$images item=image}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td valign="top">
					<input type="hidden" value="{$image.id}" name="gimg[]" />
					<input type="hidden" value="{$image.image_filename}" name="datei[{$image.id}]" />
					<input title="{#MarDel#}" name="del[{$image.id}]" type="checkbox" id="del[{$image.id}]" value="1" />
				</td>

				<td valign="top">
					<a href="../modules/gallery/uploads/{if $gallery_folder != ''}{$gallery_folder}/{/if}{$image.image_filename}" target="_blank">
						<img src="../modules/gallery/thumb.php?file={$image.image_filename}&type={$image.image_type}&xwidth={$thumb_width}{if $gallery_folder != ''}&folder={$gallery_folder}{/if}&compile=1" alt="" border="0" />
					</a>
				</td>

				<td valign="top">
					<input name="image_title[{$image.id}]" type="text" style="width:350px" id="image_title[{$image.id}]" value="{$image.image_title|escape}"><br />
					<textarea name="image_description[{$image.id}]" cols="40" rows="4" style="width:350px" id="image_description[{$image.id}]">{$image.image_description|escape}</textarea>
				</td>

				<td valign="top">
					<input name="image_position[{$image.id}]" type="text" style="width:50px" id="image_position[{$image.id}]" value="{$image.image_position}">{#Position#}<br />
					<br />
					{#Uploader#}: {$image.image_author|escape}<br />
					{#UploadOn#}: {$image.image_date|date_format:$TIME_FORMAT|pretty_date:$DEF_LANGUAGE}<br />
					{#Filesize#}: {$image.image_size} kb
				</td>
			</tr>
		{/foreach}

		<tr>
			<td class="second" colspan="4">
				<input class="button" type="submit" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table><br />
</form>

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
{/if}

{/strip}
<!-- /admin_gallery_image.tpl -->
