<script src="editarea/edit_area_full.js"></script>

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#ModSettingGal#}</h2>
	</div>
	<div class="HeaderText">&nbsp;</div>
</div>

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=gallery&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#GalView#}</a>
</div><br />

<form method="post" name="gallery_form" action="index.php?do=modules&action=modedit&mod=gallery&moduleaction=editgallery&id={$smarty.request.id|escape}&cp={$sess}&sub=save">
	{assign var=js_form value='gallery_form'}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="200" class="first">
		<col class="second">
		<tr>
			<td class="tableheader">{#GallerySetParam#}</td>
			<td class="tableheader">{#GallerySetVal#}</td>
		</tr>

		<tr>
			<td>{#GalleryTitle#}</td>
			<td>
				<input name="gallery_title" type="text" id="gallery_title" value="{$gallery.gallery_title|escape}" size="40" style="width:500px" />
				<input name="gallery_title_old" type="hidden" value="{$gallery.gallery_title|escape}" />
			</td>
		</tr>

		<tr>
			<td>{#GalleryDesc#}</td>
			<td>
				<textarea name="gallery_description" cols="40" rows="5" id="gallery_description" style="width:500px">{$gallery.gallery_description|escape}</textarea>
			</td>
		</tr>

		<tr>
			<td>{#GalleryFolder#}</td>
			<td>
				<input name="gallery_folder" title="{#GalleryFolderDesc#}" type="text" id="gallery_folder" size="40" value="{$gallery.gallery_folder|escape}" style="width:500px" />
				<input name="gallery_folder_old" type="hidden" value="{$gallery.gallery_folder|escape}" />
			</td>
		</tr>

		<tr>
			<td>{#Watermark#}</td>
			<td>
				<input name="gallery_watermark" type="text" id="gallery_watermark" value="{$gallery.gallery_watermark|escape}" size="40" style="width:500px" />
			</td>
		</tr>

		<tr>
			<td>{#MaxWidth#}</td>
			<td>
				<input name="gallery_thumb_width" title="{#MaxWidthWarn#}" type="text" id="gallery_thumb_width" value="{$gallery.gallery_thumb_width}" size="5" maxlength="3" />
				<input name="thumb_width_old" type="hidden" value="{$gallery.gallery_thumb_width}" />
			</td>
		</tr>

		<tr>
			<td>{#MaxImagesERow#}</td>
			<td>
				<input name="gallery_image_on_line" type="text" id="gallery_image_on_line" value="{$gallery.gallery_image_on_line}" size="5" maxlength="2" />
			</td>
		</tr>

		<tr>
			<td class="first">{#MaxImagesPage#}</td>
			<td>
				<input name="gallery_image_on_page" type="text" id="gallery_image_on_page" value="{$gallery.gallery_image_on_page}" size="5" maxlength="4" />
			</td>
		</tr>

		<tr>
			<td>{#ShowHeader#}</td>
			<td>
				<input name="gallery_title_show" type="checkbox" id="gallery_title_show" value="1" {if $gallery.gallery_title_show == 1}checked="checked" {/if}/>
			</td>
		</tr>

		<tr>
			<td>{#Showdescr#}</td>
			<td>
				<input name="gallery_description_show" type="checkbox" id="gallery_description_show" value="1" {if $gallery.gallery_description_show == 1}checked="checked" {/if}/>
			</td>
		</tr>

		<tr>
			<td>{#ShowSize#}</td>
			<td>
				<input name="gallery_image_size_show" type="checkbox" id="gallery_image_size_show" value="1" {if $gallery.gallery_image_size_show == 1}checked="checked" {/if}/>
			</td>
		</tr>

		<tr>
			<td>{#OrderImage#}</td>
			<td>
				<select name="gallery_orderby" style="width:200px">
					<option value="dateasc" {if $gallery.gallery_orderby == 'dateasc'}selected="selected" {/if}/>{#OrderDateAsc#}</option>
					<option value="datedesc" {if $gallery.gallery_orderby == 'datedesc'}selected="selected" {/if}/>{#OrderDateDesc#}</option>
					<option value="titleasc" {if $gallery.gallery_orderby == 'titleasc'}selected="selected" {/if}/>{#OrderTitleAsc#}</option>
					<option value="titledesc" {if $gallery.gallery_orderby == 'titledesc'}selected="selected" {/if}/>{#OrderTitleDesc#}</option>
					<option value="position" {if $gallery.gallery_orderby == 'position'}selected="selected" {/if}/>{#OrderPosition#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>{#TypeOut#}</td>
			<td>
				<select id="gallery_type" name="gallery_type" style="width:200px">
					<option value="1" {if $gallery.gallery_type == 1}selected="selected" {/if}/>{#TypeOut1#}</option>
					<option value="2" {if $gallery.gallery_type == 2}selected="selected" {/if}/>{#TypeOut2#}</option>
					<option value="3" {if $gallery.gallery_type == 3}selected="selected" {/if}/>{#TypeOut3#}</option>
					<option value="4" {if $gallery.gallery_type == 4}selected="selected" {/if}/>{#TypeOut4#}</option>
					<option value="5" {if $gallery.gallery_type == 5}selected="selected" {/if}/>{#TypeOut5#}</option>
					<option value="6" {if $gallery.gallery_type == 6}selected="selected" {/if}/>{#TypeOut6#}</option>
					<option value="7" {if $gallery.gallery_type == 7}selected="selected" {/if}/>{#TypeOut7#}</option>
				</select>
			</td>
		</tr>

		<tr class="tr-toggle">
			<td>{#GalleryScripts#}</td>
			<td>
				<textarea name="gallery_script" cols="80" rows="10" id="gallery_script" style="width:100%">{$gallery.gallery_script|escape}</textarea>
				{assign var=js_textfeld value='gallery_script'}
			</td>
		</tr>

		<tr class="tr-toggle">
			<td>{#GalleryScriptsTag#}</td>
			<td>
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<col class="first" width="130">
					<col class="first">
					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:gal:id]', '');">[tag:gal:id]</a></strong></td>
						<td>{#GalleryTagId#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:gal:folder]', '');">[tag:gal:folder]</a></strong></td>
						<td>{#GalleryTagFolder#}</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr class="tr-toggle">
			<td>{#ImageTpl#}</td>
			<td>
				<textarea name="gallery_image_template" cols="80" rows="10" id="gallery_image_template" style="width:100%">{$gallery.gallery_image_template|escape}</textarea>
				<div class="infobox">
					{assign var=js_textfeld value='gallery_image_template'}
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<p>', '</p>');">P</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<strong>', '</strong>');">B</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<em>', '</em>');">I</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h1>', '</h1>');">H1</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h2>', '</h2>');">H2</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h3>', '</h3>');">H3</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<div>', '</div>');">DIV</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<span>', '</span>');">SPAN</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<pre>', '</pre>');">PRE</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<br />', '');">BR</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '\t', '');">TAB</a>&nbsp;
				</div>
			</td>
		</tr>

		<tr class="tr-toggle">
			<td>{#ImageTplTag#}</td>
			<td>
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<col class="first" width="130">
					<col class="first">
					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:gal:id]', '');">[tag:gal:id]</a></strong></td>
						<td>{#GalleryTagId#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:gal:folder]', '');">[tag:gal:folder]</a></strong></td>
						<td>{#GalleryTagFolder#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:img:id]', '');">[tag:img:id]</a></strong></td>
						<td>{#GalleryTagImgId#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:img:title]', '');">[tag:img:title]</a></strong></td>
						<td>{#GalleryTagImgTitle#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:img:description]', '');">[tag:img:description]</a></strong></td>
						<td>{#GalleryTagImgDesc#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:img:filename]', '');">[tag:img:filename]</a></strong></td>
						<td>{#GalleryTagImgFilename#}</td>
					</tr>

					<tr>
						<td scope="row"><strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:img:thumbnail]', '');">[tag:img:thumbnail]</a></strong></td>
						<td>{#GalleryTagImgThumb#}</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="third">
				<input type="submit" class="button" value="{#ButtonSave#}" />
			</td>
		</tr>
	</table><br />
</form>

<script>
{if $empty_gallery_title == 1}
alert("{#EmptyGalleryTitle#}");
{/if}{if $folder_exist == 1}
alert("{#FolderExists#}");
{/if}{if $gallery.gallery_type != 7}
$('.tr-toggle').hide();
{/if}
$(document).ready(function(){ldelim}
	$('#gallery_type').change(function(){ldelim}
		var gtype = $('#gallery_type').val();
		if (gtype == 7) $('.tr-toggle').show();
		else $('.tr-toggle').hide();
	{rdelim});
{rdelim});
</script>