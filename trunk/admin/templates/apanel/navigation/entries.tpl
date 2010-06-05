<script language="javascript" type="text/javascript">
function openLinkWindow(target,doc,alias) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'Title';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('index.php?doc='+doc+'&target='+target+'&alias='+alias+'&do=docs&action=showsimple&cp={$sess}&pop=1','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}

function openFileWindow(target,id,alias) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'Title';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('browser.php?id='+id+'&typ=bild&mode=fck&target=navi&cp={$sess}','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}
</script>

<div id="pageHeaderTitle" style="padding-top:7px">
	<div class="h_navi">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#NAVI_SUB_TITLE2#}<span style="color:#000">&nbsp;&gt;&nbsp;{$NavigatonName|escape:html|stripslashes}</span></h2>
	</div>
	<div class="HeaderText">&nbsp;</div>
</div>

<h4>{#NAVI_ITEMS_TIP#}</h4>
<form name="navquicksave" method="post" action="index.php?do=navigation&amp;action=quicksave&amp;id={$smarty.request.id}&amp;cp={$sess}">
	<table width="100%" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="50%">
		<col width="50%">
		<col width="27">
		<col width="21">
		<col width="55">
		<col width="224">
		<tr class="tableheader">
			<td>{#NAVI_LINK_TITLE#}</td>
			<td>{#NAVI_LINK_TO_DOCUMENT#}</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>{#NAVI_POSITION#}</td>
			<td>{#NAVI_TARGET_WINDOW#}</td>
		</tr>

		<tr>
			<input type="hidden" name="Url_N[]" id="Url_N" value="" />
			<td class="second"><input style="width:100%" name="Titel_N[]" type="text" id="Titel_N" value="" /></td>
			<td class="second"><input style="width:100%" name="Link_N[]" type="text" id="Link_N" value="" /></td>
			<td class="second"><input title="{#NAVI_BROWSE_DOCUMENTS#}" onclick="openLinkWindow('Link_N','Titel_N','Url_N');" type="button" class="button" value="... " /></td>
			<td class="second"><input title="{#NAVI_BROWSE_MEDIAPOOL#}" onclick="openFileWindow('Link_N','Link_N','Url_N');" type="button" class="button" value="#" /></td>
			<td class="second"><input name="Rang_N[]" type="text" id="Rang_N" value="10" size="4" maxlength="3" /></td>
			<td class="second" nowrap="nowrap">
				<select name="Ziel_N[]" id="Ziel_N">
					<option value="_self" selected="selected">{#NAVI_OPEN_IN_THIS#}</option>
					<option value="_blank">{#NAVI_OPEN_IN_NEW#}</option>
				</select>&nbsp;
				<input type="submit" class="button" value="{#NAVI_BUTTON_ADD#}" />
			</td>
		</tr>
	</table><br />

	<div id="pageHeaderTitle" style="padding-top:7px">
		<div class="HeaderTitle">
			<h4 class="navi">{#NAVI_LIST#}</h4>
		</div>
		<div class="Text">{#NAVI_LIST_TIP#}</div>
	</div>

	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="50%">
		<col width="50%">
		<col width="27">
		<col width="21">
		<col width="55">
		<col width="112">
		<col width="21">
		<col width="20">
		<col width="20">
		<tr class="tableheader">
			<td>{#NAVI_LINK_TITLE#}</td>
			<td>{#NAVI_LINK_TO_DOCUMENT#}</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>{#NAVI_POSITION#}</td>
			<td>{#NAVI_TARGET_WINDOW#}</td>
			<td>&nbsp;</td>
			<td align="center"><img src="{$tpl_dir}/images/icon_unlock.gif" alt="" border="0" /></td>
			<td align="center"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></td>
		</tr>

		{foreach from=$entries item=item}
			<tr id="table_rows" style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';">
				<input type="hidden" name="Url[{$item->Id}]" id="Url_{$item->Id}" value="{$item->Url|stripslashes}" />
				<td><input style="width:100%" name="Titel[{$item->Id}]" type="text" id="Titel_{$item->Id}" value="{$item->Titel|stripslashes}" /></td>
				<td><input style="width:100%" name="Link[{$item->Id}]" type="text" id="Link_{$item->Id}" value="{$item->Link|escape:html|stripslashes}" /></td>
				<td><input title="{#NAVI_BROWSE_DOCUMENTS#}" onclick="openLinkWindow('Link_{$item->Id}','Titel_{$item->Id}','Url_{$item->Id}');" type="button" class="button" value="... " /></td>
				<td><input title="{#NAVI_BROWSE_MEDIAPOOL#}" onclick="openFileWindow('Link_{$item->Id}','Link_{$item->Id}','Url_{$item->Id}');" type="button" class="button" value="#" /></td>
				<td><input name="Rang[{$item->Id}]" type="text" id="Rang_{$item->Id}" value="{$item->Rang}" size="4" maxlength="3" /></td>
				<td>
					<select name="Ziel[{$item->Id}]" id="Ziel_{$item->Id}">
						<option value="_self"{if $item->Ziel=='_self'} selected="selected"{/if}>{#NAVI_OPEN_IN_THIS#}</option>
						<option value="_blank"{if $item->Ziel=='_blank'} selected="selected"{/if}>{#NAVI_OPEN_IN_NEW#}</option>
					</select>
				</td>
				<td><input title="{#NAVI_ADD_SUBITEM#}" type="button" class="button" onclick="document.getElementById('Neu_2_{$item->Id}').style.display='';" value="{#NAVI_BUTTON_SUBITEM#}" /></td>
				<td><input title="{#NAVI_MARK_ACTIVE#}" name="Aktiv[{$item->Id}]" type="checkbox" value="1" {if $item->Aktiv==1}checked="checked" {/if}/></td>
				<td><input title="{#NAVI_MARK_DELETE#}" name="del[{$item->Id}]" type="checkbox" id="del[{$item->Id}]" value="1" /></td>
			</tr>

			<tr id="Neu_2_{$item->Id}" style="display:none">
				<input type="hidden" name="Url_Neu_2[{$item->Id}]" id="Url_Neu_2_{$item->Id}" value="" />
				<td style="background-color:#acd18f" class="level2_new"><input style="width:100%" name="Titel_Neu_2[{$item->Id}]" type="text" id="Titel_Neu_2_{$item->Id}" value="" /></td>
				<td style="background-color:#acd18f"><input style="width:100%" name="Link_Neu_2[{$item->Id}]" type="text" id="Link_Neu_2_{$item->Id}" value="" /></td>
				<td style="background-color:#acd18f"><input title="{#NAVI_BROWSE_DOCUMENTS#}" onclick="openLinkWindow('Link_Neu_2_{$item->Id}','Titel_Neu_2_{$item->Id}','Url_Neu_2_{$item->Id}');" type="button" class="button" value="... " /></td>
				<td style="background-color:#acd18f"><input title="{#NAVI_BROWSE_MEDIAPOOL#}" onclick="openFileWindow('Link_Neu_2_{$item->Id}','Link_Neu_2_{$item->Id}','Url_Neu_2_{$item->Id}');" type="button" class="button" value="#" /></td>
				<td style="background-color:#acd18f"><input name="Rang_Neu_2[{$item->Id}]" type="text" id="Rang_Neu_2_{$item->Id}" value="10" size="4" maxlength="3" /></td>
				<td style="background-color:#acd18f">
					<select name="Ziel_Neu_2[{$item->Id}]" id="Ziel_Neu_2_{$item->Id}">
						<option value="_self" selected="selected">{#NAVI_OPEN_IN_THIS#}</option>
						<option value="_blank">{#NAVI_OPEN_IN_NEW#}</option>
					</select>
				</td>
				<td style="background-color:#acd18f">&nbsp;</td>
				<td style="background-color:#acd18f">&nbsp;</td>
				<td style="background-color:#acd18f">&nbsp;</td>
			</tr>

			{foreach from=$item->ebene_2 item=item_2}
				<tr id="table_rows" style="background-color:#dae0d8">
					<input type="hidden" name="Url[{$item_2->Id}]" id="Url_{$item_2->Id}" value="{$item_2->Url|stripslashes}" />
					<td style="background-color:#dae0d8" class="level2"><input style="width:100%" name="Titel[{$item_2->Id}]" type="text" id="Titel_{$item_2->Id}" value="{$item_2->Titel|stripslashes}" /></td>
					<td style="background-color:#dae0d8"><input style="width:100%" name="Link[{$item_2->Id}]" type="text" id="Link_{$item_2->Id}" value="{$item_2->Link|escape:html|stripslashes}" /></td>
					<td style="background-color:#dae0d8"><input title="{#NAVI_BROWSE_DOCUMENTS#}" onclick="openLinkWindow('Link_{$item_2->Id}','Titel_{$item_2->Id}','Url_{$item_2->Id}');" type="button" class="button" value="... " /></td>
					<td style="background-color:#dae0d8"><input title="{#NAVI_BROWSE_MEDIAPOOL#}" onclick="openFileWindow('Link_{$item_2->Id}','Link_{$item_2->Id}','Url_{$item_2->Id}');" type="button" class="button" value="#" /></td>
					<td style="background-color:#dae0d8"><input name="Rang[{$item_2->Id}]" type="text" id="Rang_{$item_2->Id}" value="{$item_2->Rang}" size="4" maxlength="3" /></td>
					<td style="background-color:#dae0d8">
						<select name="Ziel[{$item_2->Id}]" id="Ziel_{$item_2->Id}">
							<option value="_self"{if $item_2->Ziel=='_self'} selected="selected"{/if}>{#NAVI_OPEN_IN_THIS#}</option>
							<option value="_blank"{if $item_2->Ziel=='_blank'} selected="selected"{/if}>{#NAVI_OPEN_IN_NEW#}</option>
						</select>
					</td>
					<td style="background-color:#dae0d8"><input title="{#NAVI_ADD_SUBITEM#}" type="button" class="button_lev2" onclick="document.getElementById('Neu_3_{$item_2->Id}').style.display='';" value="{#NAVI_BUTTON_SUBITEM#}" /></td>
					<td style="background-color:#dae0d8"><input title="{#NAVI_MARK_ACTIVE#}" name="Aktiv[{$item_2->Id}]" type="checkbox" value="1" {if $item_2->Aktiv==1}checked="checked" {/if}/></td>
					<td style="background-color:#dae0d8"><input title="{#NAVI_MARK_DELETE#}" name="del[{$item_2->Id}]" type="checkbox" id="del[{$item_2->Id}]" value="1" /></td>
				</tr>

				{foreach from=$item_2->ebene_3 item=item_3}
					<tr id="table_rows">
						<input type="hidden" name="Url[{$item_3->Id}]" id="Url_{$item_3->Id}" value="{$item_3->Url|stripslashes}" />
						<td style="background-color:#cdd5ca" class="level3"><input style="width:100%" name="Titel[{$item_3->Id}]" type="text" id="Titel_{$item_3->Id}" value="{$item_3->Titel|stripslashes}" /></td>
						<td style="background-color:#cdd5ca"><input style="width:100%" name="Link[{$item_3->Id}]" type="text" id="Link_{$item_3->Id}" value="{$item_3->Link|escape:html|stripslashes}" /></td>
						<td style="background-color:#cdd5ca"><input title="{#NAVI_BROWSE_DOCUMENTS#}" onclick="openLinkWindow('Link_{$item_3->Id}','Titel_{$item_3->Id}','Url_{$item_3->Id}');" type="button" class="button" value="... " /></td>
						<td style="background-color:#cdd5ca"><input title="{#NAVI_BROWSE_MEDIAPOOL#}" onclick="openFileWindow('Link_{$item_3->Id}','Link_{$item_3->Id}','Url_{$item_3->Id}');" type="button" class="button" value="#" /></td>
						<td style="background-color:#cdd5ca"><input name="Rang[{$item_3->Id}]" type="text" id="Rang_{$item_3->Id}" value="{$item_3->Rang}" size="4" maxlength="3" /></td>
						<td style="background-color:#cdd5ca">
							<select name="Ziel[{$item_3->Id}]" id="Ziel_{$item_3->Id}">
								<option value="_self"{if $item_3->Ziel=='_self'} selected="selected"{/if}>{#NAVI_OPEN_IN_THIS#}</option>
								<option value="_blank"{if $item_3->Ziel=='_blank'} selected="selected"{/if}>{#NAVI_OPEN_IN_NEW#}</option>
							</select>
						</td>
						<td style="background-color:#cdd5ca">&nbsp;</td>
						<td style="background-color:#cdd5ca"><input title="{#NAVI_MARK_ACTIVE#}" name="Aktiv[{$item_3->Id}]" type="checkbox" id="del[{$item_3->Id}]" value="1" {if $item_3->Aktiv==1}checked="checked" {/if}/></td>
						<td style="background-color:#cdd5ca"><input title="{#NAVI_MARK_DELETE#}" name="del[{$item_3->Id}]" type="checkbox" value="1" /></td>
					</tr>
				{/foreach}

				<tr id="Neu_3_{$item_2->Id}" style="display:none">
					<input type="hidden" name="Url_Neu_3[{$item_2->Id}]" id="Url_Neu_3_{$item_2->Id}" value="" />
					<td style="background-color:#acd18f" class="level3_new"><input style="width:100%" name="Titel_Neu_3[{$item_2->Id}]" type="text" id="Titel_Neu_3_{$item_2->Id}" value="" /></td>
					<td style="background-color:#acd18f"><input style="width:100%" name="Link_Neu_3[{$item_2->Id}]" type="text" id="Link_Neu_3_{$item_2->Id}" value="" /></td>
					<td style="background-color:#acd18f"><input title="{#NAVI_BROWSE_DOCUMENTS#}" onclick="openLinkWindow('Link_Neu_3_{$item_2->Id}','Titel_Neu_3_{$item_2->Id}','Url_Neu_3_{$item_2->Id}');" type="button" class="button" value="... " /></td>
					<td style="background-color:#acd18f"><input title="{#NAVI_BROWSE_MEDIAPOOL#}" onclick="openFileWindow('Link_Neu_3_{$item_2->Id}','Link_Neu_3_{$item_2->Id}','Url_Neu_3_{$item_2->Id}');" type="button" class="button" value="#" /></td>
					<td style="background-color:#acd18f"><input name="Rang_Neu_3[{$item_2->Id}]" type="text" id="Rang_Neu_3_{$item_2->Id}" value="10" size="4" maxlength="3" /></td>
					<td style="background-color:#acd18f">
						<select name="Ziel_Neu_3[{$item_2->Id}]" id="Ziel_Neu_3_{$item_2->Id}">
							<option value="_self" selected="selected">{#NAVI_OPEN_IN_THIS#}</option>
							<option value="_blank">{#NAVI_OPEN_IN_NEW#}</option>
						</select>
					</td>
					<td style="background-color:#acd18f">&nbsp;</td>
					<td style="background-color:#acd18f">&nbsp;</td>
					<td style="background-color:#acd18f">&nbsp;</td>
				</tr>
			{/foreach}
		{/foreach}
	</table>

	<input type="hidden" id="Rubrik" name="Rubrik" value="{$smarty.request.id}" /><br />
	<input type="submit" class="button" value="{#NAVI_BUTTON_SAVE#}" />
</form>