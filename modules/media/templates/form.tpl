
<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('Bannername').value == '') {ldelim}
		alert("{#BANNER_PLEASE_NAME#}");
		document.getElementById('Bannername').focus();
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
				<td class="second"><input name="Aktiv" type="checkbox" id="Aktiv" value="1" {if $item->Aktiv==1}checked{/if} /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_NAME_FORM#} </td>
				<td class="second"><input style="width:300px" name="Bannername" id="Bannername" type="text" value="{$item->Bannername}" /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_CATEGORY_FORM#}</td>
				<td class="second">
					<select name="KatId" id="KatId">
						{foreach from=$kategs item=k}
							<option value="{$k->Id}" {if $k->Id==$item->KatId}selected{/if}>{$k->KatName}</option>
						{/foreach}
					</select>
				</td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_TARGET_URL#}</td>
				<td class="second"><input style="width:300px" name="BannerUrl" type="text" value="{$item->BannerUrl|default:'http://'}" /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_TARGET_TYPE#}</td>
				<td class="second">
					<select name="Target">
						<option value="_blank" {if $item->Target == '_blank'}selected{/if}>{#BANNER_OPEN_IN_NEW#}</option>
						<option value="_self" {if $item->Target == '_self'}selected{/if}>{#BANNER_OPEN_IN_THIS#}</option>
					</select>
				</td>
			</tr>

			{if $smarty.request.moduleaction != 'newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_OLD_IMAGE#}</td>
					<td class="second">
					{if $item->Bannertags==''}-{else}
						{if $item->swf == false}
							<img src="../modules/{$mod_path}/files/{$item->Bannertags}" alt="" border="" />
						{else}
							<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="{$item->Width}" height="{$item->Height}" id="reklama" align="middle">
								<param name="allowScriptAccess" value="sameDomain" />
								<param name="movie" value="../modules/{$mod_path}/files/{$item->Bannertags}" />
								<param name="quality" value="high" />
								<embed src="../modules/{$mod_path}/files/{$item->Bannertags}" quality="high" width="{$item->Width}" height="{$item->Height}" name="reklama" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
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

			{if $item->Bannertags!='' && $smarty.request.moduleaction!='newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_OLD_DELETE#}</td>
					<td class="second"><input name="del" type="checkbox" id="del" value="1"></td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">{#BANNER_ALT_TEXT#}</td>
				<td class="second"><input style="width:300px" name="BildAlt" type="text" id="BildAlt" value="{$item->BildAlt}" /></td>
			</tr>

			<tr>
				<td width="300" class="first">{#BANNER_PRIOR#}</td>
				<td class="second">
					<select style="width:50px" name="Gewicht" id="Gewicht">
						<option value="1" {if $item->Gewicht==1}selected{/if}>1</option>
						<option value="2" {if $item->Gewicht==2}selected{/if}>2</option>
						<option value="3" {if $item->Gewicht==3}selected{/if}>3</option>
					</select>
					<small>{#BANNER_PRIOR_DESC#}</small>
				</td>
			</tr>

			{if $smarty.request.moduleaction!='newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_VIEW_RESET#}</td>
					<td class="second"><input name="Anzeigen" type="text" id="Anzeigen" value="{$item->Views}" size="6" /> </td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">{#BANNER_VIEWS_MAX#}<br /><small>{#BANNER_VIEWS_INFO#}</small></td>
				<td class="second"><input name="MaxViews" type="text" id="MaxViews" value="{$item->MaxViews|default:'0'}" size="6" /> <small>{#BANNER_UNLIMIT#}</small></td>
			</tr>

			{if $smarty.request.moduleaction!='newbanner'}
				<tr>
					<td width="300" class="first">{#BANNER_CLICK_RESET#}</td>
					<td class="second"><input name="Klicks" type="text" id="Klicks" value="{$item->Klicks}" size="6" /></td>
				</tr>
			{/if}

			<tr>
				<td width="300" class="first">{#BANNER_CLICKS#}<br><small>{#BANNER_CLICKS_INFO#}</small></td>
				<td class="second"><input name="MaxKlicks" type="text" id="MaxKlicks" value="{$item->MaxKlicks|default:'0'}" size="6" /> <small>{#BANNER_UNLIMIT#}</small></td>
			</tr>

			<tr>
				<td class="first">{#BANNER_HOUR_START#}<br /><small>{#BANNER_START_INFO#}</small></td>
				<td class="second">
					<select style="width:50px" name="ZStart" id="ZStart">
						{section name=s loop=25 start=1}
							<option value="{$smarty.section.s.index-1}" {if $item->ZStart==$smarty.section.s.index-1}selected{/if}>{$smarty.section.s.index-1}</option>
						{/section}
					</select>
					<small>{#BANNER_START_INFO2#}</small>
				</td>
			</tr>

			<tr>
				<td class="first">{#BANNER_HOUR_END#}<br /><small>{#BANNER_END_INFO#}</small></td>
				<td class="second">
					<select style="width:50px" name="ZEnde" id="ZEnde">
						{section name=e loop=25 start=1}
							<option value="{$smarty.section.e.index-1}" {if $item->ZEnde==$smarty.section.e.index-1}selected{/if}>{$smarty.section.e.index-1}</option>
						{/section}
					</select>
					<small>{#BANNER_END_INFO2#}</small>
				</td>
			</tr>

			<tr>
				<td class="first">{#BANNER_WIDTH_SWF#}<br /><small>{#BANNER_FOR_SWF#}</small></td>
				<td class="second"><input name="Width" type="text" id="Width" value="{$item->Width|default:'0'}" size="6" /></td>
			</tr>

			<tr>
				<td class="first">{#BANNER_HEIGHT_SWF#}<br /><small>{#BANNER_FOR_SWF#}</small></td>
				<td class="second"><input name="Height" type="text" id="Height" value="{$item->Height|default:'0'}" size="6" /></td>
			</tr>
		</table><br />

		{if $smarty.request.moduleaction == 'newbanner'}
			<input name="submit" type="submit" class="button" value="{#BANNER_BUTTON_NEW#}" />
		{else}
			<input name="submit" type="submit" class="button" value="{#BANNER_BUTTON_SAVE#}" />
		{/if}

	</form>

{/if}