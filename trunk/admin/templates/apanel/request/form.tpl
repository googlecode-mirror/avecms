<script language="Javascript" type="text/javascript" src="editarea/edit_area_full.js"></script>
<script language="Javascript" type="text/javascript" src="editarea/request.js"></script>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function changeRub(select) {ldelim}
	if(select.options[select.selectedIndex].value!='#') {ldelim}
		if(confirm('{#REQUEST_SELECT_INFO#}')) {ldelim}
			if(select.options[select.selectedIndex].value!='#') {ldelim}
			{if $smarty.request.action=='new'}
				location.href='index.php?do=request&action=new&rubric_id=' + select.options[select.selectedIndex].value + '{if $smarty.request.request_title_new!=''}&request_title_new={$smarty.request.request_title_new|escape|stripslashes}{/if}';
			{else}
				location.href='index.php?do=request&action=edit&Id={$smarty.request.Id|escape}&rubric_id=' + select.options[select.selectedIndex].value;
			{/if}
			{rdelim}
		{rdelim}
		else {ldelim}
			document.getElementById('RubrikId_{$smarty.request.rubric_id|escape}').selected = 'selected';
		{rdelim}
	{rdelim}
{rdelim}
/*]]>*/
</script>

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_query">&nbsp;</div>
	{if $smarty.request.action=='edit'}
		<div class="HeaderTitle">
			<h2>{#REQUEST_EDIT2#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$row->request_title|escape}</span></h2>
		</div>
		<div class="HeaderText">{#REQUEST_EDIT_TIP#}</div>
	{else}
		<div class="HeaderTitle">
			<h2>{#REQUEST_NEW#}</h2>
		</div>
		<div class="HeaderText">{#REQUEST_NEW_TIP#}</div>
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

{if $smarty.request.Id==''}
	{assign var=iframe value='no'}
{/if}

{if $smarty.request.action == 'new' && $smarty.request.rubric_id == ''}
	{assign var=dis value='disabled'}
{/if}

<form name="f_tpl" method="post" action="{$formaction}">
	<input name="pop" type="hidden" id="pop" value="{$smarty.request.pop|escape}" /><br />
	{assign var=js_form value='f_tpl'}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="238"></col>
		<tr>
			<td colspan="2" class="tableheader">{#REQUEST_SETTINGS#}</td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_NAME2#}</td>
			<td class="second"><input {$dis} style="width:250px" name="request_title" type="text" id="l_Titel" value="{$smarty.request.request_title_new|stripslashes|default:$row->request_title|escape}"></td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_SELECT_RUBRIK#}</td>
			<td class="second">
				<select onChange="changeRub(this)" style="width:250px" name="rubric_id" id="rubric_id">
					{if $smarty.request.action=='new' && $smarty.request.rubric_id==''}
						<option value="">{#REQUEST_PLEASE_SELECT#}</option>
					{/if}
					{foreach from=$rubrics item=rubric}
						<option id="RubrikId_{$rubric->Id}" value="{$rubric->Id}"{if $row->rubric_id==$rubric->Id || $smarty.request.rubric_id==$rubric->Id} selected="selected"{/if}>{$rubric->rubric_title|escape}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_DESCRIPTION#}<br /><small>{#REQUEST_INTERNAL_INFO#}</small></td>
			<td class="second"><textarea {$dis} style="width:350px; height:60px" name="request_description" id="request_description">{$row->request_description|escape}</textarea></td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_CONDITION#}</td>
			<td class="second">
				{if $iframe=='no'}
					<input type="checkbox" name="reedit" value="1" checked />{#REQUEST_ACTION_AFTER#}
				{/if}
				{if $iframe!='no'}
					<input name="button" type="button" class="button" onclick="cp_pop('index.php?do=request&action=konditionen&rubric_id={$smarty.request.rubric_id|escape}&Id={$smarty.request.Id|escape}&pop=1&cp={$sess}','750','600','1')" value="{#REQUEST_BUTTON_COND#}" />
				{/if}
			</td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_SORT_BY#}</td>
			<td class="second">
				<select {$dis} style="width:250px" name="request_order_by" id="request_order_by">
					<option value="document_published"{if $row->request_order_by=='document_published'} selected="selected"{/if}>{#REQUEST_BY_DATE#}</option>
					<option value="document_title"{if $row->request_order_by=='document_title'} selected="selected"{/if}>{#REQUEST_BY_NAME#}</option>
					<option value="document_author_id"{if $row->request_order_by=='document_author_id'} selected="selected"{/if}>{#REQUEST_BY_EDIT#}</option>
					<option value="document_count_print"{if $row->request_order_by=='document_count_print'} selected="selected"{/if}>{#REQUEST_BY_PRINTED#}</option>
					<option value="document_count_view"{if $row->request_order_by=='document_count_view'} selected="selected"{/if}>{#REQUEST_BY_VIEWS#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_ASC_DESC#}</td>
			<td class="second">
				<select {$dis} style="width:100px" name="request_asc_desc" id="request_asc_desc">
					<option value="DESC"{if $row->request_asc_desc=='DESC'} selected="selected"{/if}>{#REQUEST_DESC#}</option>
					<option value="ASC"{if $row->request_asc_desc=='ASC'} selected="selected"{/if}>{#REQUEST_ASC#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_DOC_PER_PAGE#}</td>
			<td class="second">
				<select {$dis} style="width:100px" name="request_items_per_page" id="request_items_per_page">
					{section name=zahl loop=300 step=1 start=0}
						<option value="{$smarty.section.zahl.index+1}"{if $row->request_items_per_page==$smarty.section.zahl.index+1} selected="selected"{/if}>{$smarty.section.zahl.index+1}</option>
					{/section}
				</select>
			</td>
		</tr>

		<tr>
			<td class="first" scope="row">{#REQUEST_SHOW_NAVI#}</td>
			<td class="second"><input name="request_show_pagination" type="checkbox" id="request_show_pagination" value="1"{if $row->request_show_pagination=='1'} checked="checked"{/if}></td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#REQUEST_TEMPLATE_QUERY#} </td>
		</tr>

		<tr>
			<td colspan="2" class="second">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					{assign var=js_textfeld value='request_template_main'}
					<col width="230"></col>
					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:content]', '');">[tag:content]</a></strong>
						</td>
						<td class="first">{#REQUEST_MAIN_CONTENT#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:pages]', '');">[tag:pages]</a></strong>
						</td>
						<td class="first">{#REQUEST_MAIN_NAVI#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docid]', '');">[tag:docid]</a></strong>
						</td>
						<td class="first">{#REQUEST_DCOCID_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docdate]', '');">[tag:docdate]</a></strong>
						</td>
						<td class="first">{#REQUEST_CDATEDOC_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:path]', '');">[tag:path]</a></strong>
						</td>
						<td class="first">{#REQUEST_PATH#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:mediapath]', '');">[tag:mediapath]</a></strong>
						</td>
						<td class="first">{#REQUEST_MEDIAPATH#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:if_empty]\n', '\n[/tag:if_empty]');">[tag:if_empty][/tag:if_empty]</a></strong>
						</td>
						<td class="first">{#REQUEST_IF_EMPTY#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:if_notempty]\n', '\n[/tag:if_notempty]');">[tag:if_notempty][/tag:if_notempty]</a></strong>
						</td>
						<td class="first">{#REQUEST_NOT_EMPTY#}</td>
					</tr>
{*
					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:order]', '');">[tag:order]</a></strong>
						</td>
						<td class="first">{#REQUEST_CONTROL_SORT#}</td>
					</tr>
*}
					<tr>
						{if $ddid != ''}
							<td scope="row" class="first">
								<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:dropdown:', '{$ddid}]');">[tag:dropdown:{$ddid}]</a></strong>
							</td>
						{else}
							<td scope="row" class="first">
								<strong><a href="javascript:void(0);" onclick="alert('{#REQUEST_NO_DROPDOWN#}');">[tag:dropdown:XX,XX...]</a></strong>
							</td>
						{/if}
						<td class="first">{#REQUEST_CONTROL_FIELD#}</td>
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
				<textarea {$dis} onclick="update('ag','request_template_main');" onKeyDown="update('ag','request_template_main');"  onKeyUp="update('ag','request_template_main');" wrap="off" style="width:100%; height:200px" name="request_template_main" id="request_template_main">{$row->request_template_main|escape|default:''}</textarea>
*}
				<textarea {$dis} name="request_template_main" id="request_template_main" wrap="off" style="width:100%; height:200px">{$row->request_template_main|escape|default:''}</textarea>
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
			<td colspan="2" class="tableheader"><strong>{#REQUEST_TEMPLATE_ITEMS#}</strong></td>
		</tr>

		<tr>
			<td colspan="2" class="second">{#REQUEST_TEMPLATE_INFO#}<br /><br />
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					{assign var=js_textfeld value='request_template_item'}
					<col width="230"></col>
					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="alert('{#REQUEST_SELECT_IN_LIST#}');">[tag:rfld:ID][XXX]</a></strong>
						</td>
						<td class="first">{#REQUEST_RUB_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:link]', '');">[tag:link]</a></strong>
						</td>
						<td class="first">{#REQUEST_LINK_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docid]', '');">[tag:docid]</a></strong>
						</td>
						<td class="first">{#REQUEST_DOCID_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docdate]', '');">[tag:docdate]</a></strong>
						</td>
						<td class="first">{#REQUEST_DATEDOC_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:docviews]', '');">[tag:docviews]</a></strong>
						</td>
						<td class="first">{#REQUEST_VIEWS_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:doccomments]', '');">[tag:doccomments]</a></strong>
						</td>
						<td class="first">{#REQUEST_COMMENTS_INFO#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:path]', '');">[tag:path]</a></strong>
						</td>
						<td class="first">{#REQUEST_PATH#}</td>
					</tr>

					<tr>
						<td scope="row" class="first">
							<strong><a href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:mediapath]', '');">[tag:mediapath]</a></strong>
						</td>
						<td class="first">{#REQUEST_MEDIAPATH#}</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="second">
				<textarea {$dis} name="request_template_item" id="request_template_item" wrap="off" style="width:100%; height:200px">{$row->request_template_item|escape|default:''}</textarea>
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
					<col width="230"></col>
					<tr class="tableheader">
						<td>{#REQUEST_RUBRIK_FIELD#}</td>
						<td>{#REQUEST_FIELD_NAME#}</td>
						<td>{#REQUEST_FIELD_TYPE#}</td>
					</tr>

					{foreach from=$tags item=tag}
						<tr>
							<td class="first"><a title="{#REQUEST_INSERT_INFO#}" href="javascript:void(0);" onclick="editAreaLoader.insertTags('{$js_textfeld}', '[tag:rfld:{$tag->Id}][', '150]');">[tag:rfld:{$tag->Id}][150]</a></td>
							<td class="first"><strong>{$tag->rubric_field_title}</strong></td>
							<td class="first">
								{section name=feld loop=$feld_array}
									{if $tag->rubric_field_type == $feld_array[feld].id}
										{$feld_array[feld].name}
									{/if}
								{/section}
							</td>
						</tr>
					{/foreach}
				</table>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="third">
				{if $smarty.request.action=='edit'}
					<input {$dis} type="submit" class="button" value="{#REQUEST_BUTTON_SAVE#}" />
				{else}
					<input {$dis} type="submit" class="button" value="{#REQUEST_BUTTON_ADD#}" />
				{/if}
			</td>
		</tr>
	</table>
</form>