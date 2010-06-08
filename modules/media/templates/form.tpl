
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('banner_name').value == '') {ldelim}
		alert("{#BANNER_PLEASE_NAME#}");
		document.getElementById('banner_name').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	{if $smarty.request.moduleaction!='newbanner'}
		<div class="HeaderTitle"><h2>{#BANNER_EDIT#}</h2></div>
		<div class="HeaderText">{#BANNER_EDIT_INFO#}</div>
	{else}
		<div class="HeaderTitle"><h2>{#BANNER_NEW_CREATE#}</h2></div>
		<div class="HeaderText">{#BANNER_NEW_INFO#}</div>
	{/if}
</div>

{if $folder_protected==1 && $smarty.request.moduleaction=='newbanner'}
	<br />{#BANNER_NOT_WRITABLE#}
{else}
	<br /><br />

	<form method="post" action="{$formaction}" enctype="multipart/form-data" onSubmit="return check_name();">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr class="tableheader">
				<td colspan="2">&nbsp;</td>
			</tr>

			<tr>
				<td class="first">{#BANNER_STATUS#}</td>
				<td class="second"><input name="banner_status" type="checkbox" id="banner_status" value="1" {if $item->banner_status==1}checked{/if} /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_NAME_FORM#} </td>
				<td class="second"><input style="width:300px" name="banner_name" id="banner_name" type="text" value="{$item->banner_name}" /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_CATEGORY_FORM#}</td>
				<td class="second">
					<select name="banner_category_id" id="banner_category_id" style="width:300px">
						{foreach from=$categories item=category}
							<option value="{$category->Id}" {if $category->Id==$item->banner_category_id}selected{/if}>{$category->banner_category_name}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_TARGET_URL#}</td>
				<td class="second"><input style="width:300px" name="banner_url" type="text" value="{$item->banner_url|default:'http://'}" /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_TARGET_TYPE#}</td>
				<td class="second">
					<select name="banner_target" style="width:300px">
						<option value="_blank" {if $item->banner_target == '_blank'}selected{/if}>{#BANNER_OPEN_IN_NEW#}</option>
						<option value="_self" {if $item->banner_target == '_self'}selected{/if}>{#BANNER_OPEN_IN_THIS#}</option>
					</select>
				</td>
			</tr>

			{if $smarty.request.moduleaction != 'newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_OLD_IMAGE#}</td>
					<td class="second">
					{if $item->banner_file_name==''}-{else}
						{if $item->swf == false}
							<img src="../modules/{$mod_path}/files/{$item->banner_file_name}" alt="" border="" />
						{else}
							<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="{$item->banner_width}" height="{$item->banner_height}" id="reklama" align="middle">
								<param name="allowScriptAccess" value="sameDomain" />
								<param name="movie" value="../modules/{$mod_path}/files/{$item->banner_file_name}" />
								<param name="quality" value="high" />
								<embed src="../modules/{$mod_path}/files/{$item->banner_file_name}" quality="high" width="{$item->banner_width}" height="{$item->banner_height}" name="reklama" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
							</object>
						{/if}
					{/if}
					</td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">
					{if $smarty.request.moduleaction != 'newbanner'}
						{#BANNER_CHANGE_ONNEW#}
					{else}
						{#BANNER_IMAGE_SELECT#}
					{/if}
				</td>
				<td class="second">{if $folder_protected==1 && $smarty.request.moduleaction!='newbanner'} {#BANNER_NOT_WRITABLE2#} {else} <input name="New" type="file" size="55" />{/if}</td>
			</tr>

			{if $item->banner_file_name!='' && $smarty.request.moduleaction!='newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_OLD_DELETE#}</td>
					<td class="second"><input name="del" type="checkbox" id="del" value="1"></td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">{#BANNER_ALT_TEXT#}</td>
				<td class="second"><input style="width:300px" name="banner_alt" type="text" id="banner_alt" value="{$item->banner_alt}" /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_PRIOR#}</td>
				<td class="second">
					<select style="width:70px" name="banner_priority" id="banner_priority">
						<option value="1" {if $item->banner_priority==1}selected{/if}>1</option>
						<option value="2" {if $item->banner_priority==2}selected{/if}>2</option>
						<option value="3" {if $item->banner_priority==3}selected{/if}>3</option>
					</select>
					<small>{#BANNER_PRIOR_DESC#}</small>
				</td>
			</tr>

			{if $smarty.request.moduleaction!='newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_VIEW_RESET#}</td>
					<td class="second"><input name="Anzeigen" type="text" id="Anzeigen" value="{$item->banner_views}" style="width:70px" size="6" /> </td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">{#BANNER_VIEWS_MAX#}<br /><small>{#BANNER_VIEWS_INFO#}</small></td>
				<td class="second"><input name="banner_max_views" type="text" id="banner_max_views" value="{$item->banner_max_views|default:'0'}" style="width:70px" size="6" /> <small>{#BANNER_UNLIMIT#}</small></td>
			</tr>

			{if $smarty.request.moduleaction!='newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_CLICK_RESET#}</td>
					<td class="second"><input name="banner_clicks" type="text" id="banner_clicks" value="{$item->banner_clicks}" style="width:70px" size="6" /></td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">{#BANNER_CLICKS#}<br><small>{#BANNER_CLICKS_INFO#}</small></td>
				<td class="second"><input name="banner_max_clicks" type="text" id="banner_max_clicks" value="{$item->banner_max_clicks|default:'0'}" style="width:70px" size="6" /> <small>{#BANNER_UNLIMIT#}</small></td>
			</tr>

			<tr>
				<td class="first">{#BANNER_HOUR_START#}<br /><small>{#BANNER_START_INFO#}</small></td>
				<td class="second">
					<select style="width:70px" name="banner_show_start" id="banner_show_start">
						{section name=s loop=25 start=1}
							<option value="{$smarty.section.s.index-1}" {if $item->banner_show_start==$smarty.section.s.index-1}selected{/if}>{$smarty.section.s.index-1}</option>
						{/section}
					</select>
					<small>{#BANNER_START_INFO2#}</small>
				</td>
			</tr>

			<tr>
				<td class="first">{#BANNER_HOUR_END#}<br /><small>{#BANNER_END_INFO#}</small></td>
				<td class="second">
					<select style="width:70px" name="banner_show_end" id="banner_show_end">
						{section name=e loop=25 start=1}
							<option value="{$smarty.section.e.index-1}" {if $item->banner_show_end==$smarty.section.e.index-1}selected{/if}>{$smarty.section.e.index-1}</option>
						{/section}
					</select>
					<small>{#BANNER_END_INFO2#}</small>
				</td>
			</tr>

			<tr>
				<td class="first">{#BANNER_WIDTH_SWF#}<br /><small>{#BANNER_FOR_SWF#}</small></td>
				<td class="second"><input name="banner_width" type="text" id="banner_width" value="{$item->banner_width|default:'0'}" style="width:70px" size="6" /></td>
			</tr>

			<tr>
				<td class="first">{#BANNER_HEIGHT_SWF#}<br /><small>{#BANNER_FOR_SWF#}</small></td>
				<td class="second"><input name="banner_height" type="text" id="banner_height" value="{$item->banner_height|default:'0'}" style="width:70px" size="6" /></td>
			</tr>
		</table><br />

		{if $smarty.request.moduleaction == 'newbanner'}
			<input name="submit" type="submit" class="button" value="{#BANNER_BUTTON_NEW#}" />
		{else}
			<input name="submit" type="submit" class="button" value="{#BANNER_BUTTON_SAVE#}" />
		{/if}

	</form>

{/if}