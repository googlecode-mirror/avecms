<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#ModName#}</h2>
	</div>
	<div class="HeaderText">&nbsp;</div>
</div>
<div class="infobox">
	<a href="#newg">&raquo;&nbsp;{#LinknewGal#}</a>
</div><br />

<form action="" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td width="180">{#GalleryTitle#}</td>
			<td width="180">{#CpTag#}</td>
			<td width="180">{#GalleryAuthor#}</td>
			<td width="180">{#Folder#}</td>
			<td width="180">{#Gcreated#}</td>
			<td width="5%">{#IncImages#}</td>
			<td width="1%" colspan="4" align="center">{#Actions#}</td>
		</tr>

		<form action="" method="post">
			{foreach from=$galleries item=gallery}
				<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td>
						{if $gallery.image_count > 0}
							<a title="{#ImageView#}" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=showimages&id={$gallery.id}&cp={$sess}&compile=1">{$gallery.gallery_title|escape}</a>
						{else}
							<strong>{$gallery.gallery_title|escape}</strong>
						{/if}
					</td>
					<td>
						<input name="textfield" type="text" value="[mod_gallery:{$gallery.id}]" size="17" />
					</td>
					<td>
						<a title="{#UserProfile#}" href="index.php?do=user&action=edit&id={$gallery.gallery_author}&cp={$sess}">{$gallery.username|escape}</a>
					</td>
					<td>{$gallery.gallery_folder|escape}</td>
					<td class="time">{$gallery.gallery_date|date_format:$TIME_FORMAT|pretty_date}</td>
					<td width="5%">
						<div align="center">
							{if $gallery.image_count > 0}
								<a title="{#ImageView#}" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=showimages&id={$gallery.id}&cp={$sess}">{$gallery.image_count}</a>
							{else}-{/if}
						</div>
					</td>
					<td>
						<a title="{#AddnewImages#}" href="index.php?do=modules&amp;action=modedit&amp;mod=gallery&amp;moduleaction=add&amp;id={$gallery.id}&amp;cp={$sess}"><img src="{$tpl_dir}/images/icon_add.gif" alt="" border="0" /></a>
					</td>
					<td>
						<a title="{#EditGallery#}" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=editgallery&id={$gallery.id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					</td>
					<td>
						<a title="{#DeleteGallery#}" onclick="return confirm('{#DeleteGalleryC#}');" href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=delgallery&id={$gallery.id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a>
					</td>
					<td>
						<input title="{#CheckboxCreate#}" type="checkbox" name="create[]" value="{$gallery.id}" {if $gallery.gallery_folder != ''}disabled="disabled" {/if}/>
					</td>
				</tr>
			{/foreach}
			<tr>
				<td class="second" colspan="10">
					<input type="submit" class="button" style="float:right" value="{#CreateFolder#}" />
				</td>
			</tr>
		</form>
	</table>
</form>

{if $page_nav}
	<div class="infobox">{$page_nav}</div>
{/if}

<a name="newg"></a>

<h4>{#NewGallery#}</h4>

<form action="{$formaction}" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td width="180" class="first">{#GalleryTitle#}</td>
			<td class="second">
				<input name="gallery_title" type="text" id="gallery_title" value="" style="width:300px" />
			</td>
		</tr>

		<tr>
			<td width="180" class="first">{#GalleryDesc#}</td>
			<td class="second">
				<textarea name="gallery_description" cols="50" rows="4" id="gallery_description" style="width:300px"></textarea>
			</td>
		</tr>
		<tr>
			<td width="180" class="first">{#GalleryFolder#}</td>
			<td class="second">
				<input name="gallery_folder" type="text" id="gallery_folder" size="40" value="" style="width:300px" />
			</td>
		</tr>

		<tr>
			<td class="second" colspan="2">
				<input type="submit" class="button" value="{#ButtonAdd#}" />
			</td>
		</tr>
	</table><br />
</form>

{if $alert == "folder_exists"}
	<script type="text/javascript" language="JavaScript">
		alert("{#FolderExists#}");
	</script>
{elseif $alert == "empty_gallery_title"}
	<script type="text/javascript" language="JavaScript">
		alert("{#EmptyGalleryTitle#}");
	</script>
{/if}