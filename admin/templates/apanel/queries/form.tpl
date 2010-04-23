
<!-- form.tpl -->
{strip}

<script language="Javascript" type="text/javascript" src="editarea/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript" src="editarea/queries.js"></script>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function changeRub(select) {ldelim}
	if(select.options[select.selectedIndex].value!='#') {ldelim}
		if(confirm('{#QUERY_SELECT_INFO#}')) {ldelim}
			if(select.options[select.selectedIndex].value!='#') {ldelim}
			{if $smarty.request.action=='new'}
				location.href='index.php?do=queries&action=new&RubrikId=' + select.options[select.selectedIndex].value + '{if $smarty.request.QueryName!=''}&QueryName={$smarty.request.QueryName}{/if}';
			{else}
				location.href='index.php?do=queries&action=edit&Id={$smarty.request.Id}&RubrikId=' + select.options[select.selectedIndex].value;
			{/if}
			{rdelim}
		{rdelim}
		else {ldelim}
			document.getElementById('RubrikId_{$smarty.request.RubrikId}').selected = 'selected';
		{rdelim}
	{rdelim}
{rdelim}
/*]]>*/
</script>

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_query">&nbsp;</div>
	{if $smarty.request.action=='edit'}
		<div class="HeaderTitle">
			<h2>{#QUERY_EDIT2#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$row->Titel|escape:html|stripslashes}</span></h2>
		</div>
		<div class="HeaderText">{#QUERY_EDIT_TIP#}</div>
	{else}
		<div class="HeaderTitle">
			<h2>{#QUERY_NEW#}</h2>
		</div>
		<div class="HeaderText">{#QUERY_NEW_TIP#}</div>
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

{if $smarty.request.Id==''}
	{assign var=iframe value='no'}
{/if}

{if $smarty.request.action == 'new' && $smarty.request.RubrikId == ''}
	{assign var=dis value='disabled'}
{/if}

<form name="f_tpl" method="post" action="{$formaction}">
	<input name="pop" type="hidden" id="pop" value="{$smarty.request.pop}" /><br />
	{assign var=js_form value='f_tpl'}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="208"></col>
		<tr>
			<td colspan="2" class="tableheader">{#QUERY_SETTINGS#}</td>
		</tr>

		<tr>
			<td class="first">{#QUERY_NAME2#}</td>
			<td class="second"><input {$dis} style="width:250px" name="Titel" type="text" id="l_Titel" value="{$row->Titel|escape:html|stripslashes}{$smarty.request.QueryName|escape:html}"></td>
		</tr>

		<tr>
			<td class="first">{#QUERY_SELECT_RUBRIK#}</td>
			<td class="second">
				<select onChange="changeRub(this)" style="width:250px" name="RubrikId" id="RubrikId">
					{if $smarty.request.action=='new' && $smarty.request.RubrikId==''}
						<option value="">{#QUERY_PLEASE_SELECT#}</option>
					{/if}
					{foreach from=$rubrics item=rubric}
						<option id="RubrikId_{$rubric->Id}" value="{$rubric->Id}" {if $row->RubrikId==$rubric->Id || $smarty.request.RubrikId==$rubric->Id}selected{/if}>{$rubric->RubrikName}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#QUERY_DESCRIPTION#}<br /><small>{#QUERY_INTERNAL_INFO#}</small></td>
			<td class="second"><textarea {$dis} style="width:350px; height:60px" name="Beschreibung" id="Beschreibung">{$row->Beschreibung|stripslashes|default:''}</textarea></td>
		</tr>

		<tr>
			<td class="first">{#QUERY_CONDITION#}</td>
			<td class="second">
				{if $iframe=='no'}
					<input type="checkbox" name="reedit" value="1" checked />{#QUERY_ACTION_AFTER#}
				{/if}
				{if $iframe!='no'}
					<input name="button" type="button" class="button" onclick="cp_pop('index.php?do=queries&action=konditionen&RubrikId={$smarty.request.RubrikId}&Id={$smarty.request.Id}&pop=1&cp={$sess}','750','600','1')" value="{#QUERY_BUTTON_COND#}" />
				{/if}
			</td>
		</tr>

		<tr>
			<td class="first">{#QUERY_SORT_BY#}</td>
			<td class="second">
				<select {$dis} style="width:250px" name="Sortierung" id="Sortierung">
					<option value="DokStart" {if $row->Sortierung=='DokStart'}selected{/if}>{#QUERY_BY_DATE#}</option>
					<option value="Titel" {if $row->Sortierung=='Titel'}selected{/if}>{#QUERY_BY_NAME#}</option>
					<option value="Redakteur" {if $row->Sortierung=='Redakteur'}selected{/if}>{#QUERY_BY_EDIT#}</option>
					<option value="Drucke" {if $row->Sortierung=='Drucke'}selected{/if}>{#QUERY_BY_PRINTED#}</option>
					<option value="Geklickt" {if $row->Sortierung=='Geklickt'}selected{/if}>{#QUERY_BY_VIEWS#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#QUERY_ASC_DESC#}</td>
			<td class="second">
				<select {$dis} style="width:100px" name="AscDesc" id="AscDesc">
					<option value="DESC" {if $row->AscDesc=='DESC'}selected{/if}>{#QUERY_DESC#}</option>
					<option value="ASC" {if $row->AscDesc=='ASC'}selected{/if}>{#QUERY_ASC#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#QUERY_DOC_PER_PAGE#}</td>
			<td class="second">
				<select {$dis} style="width:100px" name="Zahl" id="Zahl">
					{section name=zahl loop=300 step=1 start=0}
						<option value="{$smarty.section.zahl.index+1}" {if $row->Zahl==$smarty.section.zahl.index+1}selected{/if}>{$smarty.section.zahl.index+1}</option>
					{/section}
				</select>
			</td>
		</tr>

		<tr>
			<td class="first" scope="row">{#QUERY_SHOW_NAVI#}</td>
			<td class="second"><input name="Navi" type="checkbox" id="Navi" value="1" {if $row->Navi=='1'}checked{/if}></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#QUERY_TEMPLATE_QUERY#} </td>
		</tr>

		<tr>
			<td colspan="2" class="second">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					{assign var=js_textfeld value='AbGeruest'}
					<col width="200"></col>
					<tr>
						{if $ddid != ''}
							<td scope="row" class="first">
								<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cpctrlrub:', '{$ddid}]');">[cpctrlrub:{$ddid}]</a></strong>
							</td>
						{else}
							<td scope="row" class="first">
								<strong><a href="javascript:void(0);" onclick="alert('{#QUERY_NO_DROPDOWN#}');">[cpctrlrub:XX,XX...]</a></strong>
							</td>
						{/if}
						<td class="first">{#QUERY_CONTROL_FIELD#}</td>
					</tr>
{*
					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[sortrequest]', '');">[sortrequest]</a></strong>
						</td>
						<td class="first">{#QUERY_CONTROL_SORT#}</td>
					</tr>
*}
					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[content]', '');">[content]</a></strong>
						</td>
						<td class="first">{#QUERY_MAIN_CONTENT#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[pages]', '');">[pages]</a></strong>
						</td>
						<td class="first">{#QUERY_MAIN_NAVI#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:path]', '');">[cp:path]</a></strong>
						</td>
						<td class="first">{#QUERY_PATH#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:mediapath]', '');">[cp:mediapath]</a></strong>
						</td>
						<td class="first">{#QUERY_MEDIAPATH#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:not_empty]\n', '\n[/cp:not_empty]');">[cp:not_empty][/cp:not_empty]</a></strong>
						</td>
						<td class="first">{#QUERY_NOT_EMPTY#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:if_empty]\n', '\n[/cp:if_empty]');">[cp:if_empty][/cp:if_empty]</a></strong>
						</td>
						<td class="first">{#QUERY_IF_EMPTY#}</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="second">
{*
				<script type="text/javascript" language="JavaScript">
				function update(ID,GER) {ldelim}
					document.getElementById(ID).value = document.getElementById(GER).value;
				{rdelim}
				</script>
				<input name="cp__AbGeruest" type="hidden" id="ag" value="" />
				<textarea {$dis} onclick="update('ag','AbGeruest');" onKeyDown="update('ag','AbGeruest');"  onKeyUp="update('ag','AbGeruest');" wrap="off" style="width:100%; height:200px" name="AbGeruest" id="AbGeruest">{$row->AbGeruest|escape:html|stripslashes|default:''}</textarea>
*}
				<textarea {$dis} name="AbGeruest" id="AbGeruest" wrap="off" style="width:100%; height:200px">{$row->AbGeruest|escape:html|stripslashes|default:''}</textarea>
				<div class="infobox">
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ol>', '</ol>');">OL</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ul>', '</ul>');">UL</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<li>', '</li>');">LI</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<p>', '</p>');">P</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<strong>', '</strong>');">B</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<em>', '</em>');">I</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h1>', '</h1>');">H1</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h2>', '</h2>');">H2</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h3>', '</h3>');">H3</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<div>', '</div>');">DIV</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<pre>', '</pre>');">PRE</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<br />', '');">BR</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '\t', '');">TAB</a>&nbsp;|
				</div>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader"><strong>{#QUERY_TEMPLATE_ITEMS#}</strong></td>
		</tr>

		<tr>
			<td colspan="2" class="second">{#QUERY_TEMPLATE_INFO#}<br /><br />
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					{assign var=js_textfeld value='Template'}
					<col width="200"></col>
					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="alert('{#QUERY_SELECT_IN_LIST#}');">[cpabrub:ID][XXX]</a></strong>
						</td>
						<td class="first">{#QUERY_RUB_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[link]', '');">[link]</a></strong>
						</td>
						<td class="first">{#QUERY_LINK_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[views]', '');">[views]</a></strong>
						</td>
						<td class="first">{#QUERY_VIEWS_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[comments]', '');">[comments]</a></strong>
						</td>
						<td class="first">{#QUERY_COMMENTS_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:path]', '');">[cp:path]</a></strong>
						</td>
						<td class="first">{#QUERY_PATH#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cp:mediapath]', '');">[cp:mediapath]</a></strong>
						</td>
						<td class="first">{#QUERY_MEDIAPATH#}</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="second">
				<textarea {$dis} name="Template" id="Template" wrap="off" style="width:100%; height:200px">{$row->Template|escape:html|stripslashes|default:''}</textarea>
				<div class="infobox">
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ol>', '</ol>');">OL</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<ul>', '</ul>');">UL</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<li>', '</li>');">LI</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<p>', '</p>');">P</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<strong>', '</strong>');">B</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<em>', '</em>');">I</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h1>', '</h1>');">H1</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h2>', '</h2>');">H2</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<h3>', '</h3>');">H3</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<div>', '</div>');">DIV</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<pre>', '</pre>');">PRE</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '<br />', '');">BR</a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '\t', '');">TAB</a>&nbsp;|
				</div>
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<col width="200"></col>
					<tr class="tableheader">
						<td>{#QUERY_RUBRIK_FIELD#}</td>
						<td>{#QUERY_FIELD_NAME#}</td>
						<td>{#QUERY_FIELD_TYPE#}</td>
					</tr>

					{foreach from=$tags item=tag}
						<tr>
							<td class="first"><a title="{#QUERY_INSERT_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[cpabrub:{$tag->Id}][', '150]');">[cpabrub:{$tag->Id}][150]</a></td>
							<td class="first"><strong>{$tag->Titel}</strong></td>
							<td class="first">
								{section name=feld loop=$feld_array}
									{if $tag->RubTyp == $feld_array[feld].id}
										{$feld_array[feld].name}
									{/if}
								{/section}
							</td>
						</tr>
					{/foreach}
				</table>
			</td>
		</tr>
	</table>

	{if $smarty.request.action=='edit'}
		<input {$dis} type="submit" class="button" value="{#QUERY_BUTTON_SAVE#}" />
	{else}
		<input {$dis} type="submit" class="button" value="{#QUERY_BUTTON_ADD#}" />
	{/if}
</form>

{/strip}
<!-- /form.tpl -->
