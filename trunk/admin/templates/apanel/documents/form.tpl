
<!-- form.tpl -->
{strip}

<script type="text/javascript">
{*
function insertHTML(ed, code) {ldelim}
	document.getElementById('feld['+ed+']___Frame').contentWindow.FCK.InsertHtml(code);
{rdelim}
*}
function insert_now_date(now_date) {ldelim}
	document.getElementById(now_date).value = "{$now_date}";
	document.getElementById(now_date).focus();
{rdelim}

function openLinkWin(target,doc) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'Titel';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('index.php?do=docs&action=showsimple_edit&doc='+doc+'&target='+target+'&pop=1&cp={$sess}','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}

function openFileWin(target,id) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'Titel';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('browser.php?id='+id+'&typ=bild&mode=fck&target=navi&cp={$sess}','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}

$(document).ready(function(){ldelim}
	function check(){ldelim}
		$.ajax({ldelim}
			beforeSend: function(){ldelim}
				$("#checkResult").html('');
				{rdelim},
			url: 'index.php?do=docs&action=checkurl&cp={$sess}&id={$row_doc->Id}',
			data: ({ldelim}
				alias: $("#Url").val()
				{rdelim}),
			timeout:3000,
			success: function(data){ldelim}
				$("#checkResult").html(data);
				{rdelim}
		{rdelim});
	{rdelim};

	$("#translit").click(function(){ldelim}
		$.ajax({ldelim}
			beforeSend: function(){ldelim}
				$("#checkResult").html('');
				{rdelim},
			url:'index.php?do=docs&action=translit&cp={$sess}',
			data: ({ldelim}
				alias: $("#Url").val(),
				title: $("#Titel").val()
				{rdelim}),
			timeout:3000,
			success: function(data){ldelim}
				$("#Url").val(data);
				check();
				{rdelim}
		{rdelim});
	{rdelim});

	$("#Url").change(function(){ldelim}
		if ($("#Url").val()!='') check();
	{rdelim});

	$("#loading")
		.bind("ajaxSend", function(){ldelim}$(this).show();{rdelim})
		.bind("ajaxComplete", function(){ldelim}$(this).hide();{rdelim});

	{if $smarty.request.feld != ''}
		$("#feld_{$smarty.request.feld}").css({ldelim}
			'border' : '2px solid red',
			'font' : '120% verdana,arial',
			'background' : '#ffffff'
		{rdelim});
	{/if}
{rdelim});
</script>

<div id="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	{if $smarty.request.action=='edit'}
		<div class="HeaderTitle">
			<h2>{#DOC_EDIT_DOCUMENT#}<span style="color:#000"> &gt; {$row_doc->Titel}</span></h2>
		</div>
	{else}
		<div class="HeaderTitle">
			<h2>{#DOC_ADD_DOCUMENT#}</h2>
		</div>
	{/if}
	<div class="HeaderText">
		<strong>�������</strong> &gt; {$RubName}
	</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form method="post" name="formDocOption" action="{$formaction}" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="200" class="first">
		<col class="second">

		<tr>
			<td colspan="3" class="tableheader">{#DOC_OPTIONS#}</td>
		</tr>

		<tr>
			<td>{#DOC_NAME#}</td>
			<td><input name="Titel" type="text" id="Titel" size="40" style="width:90%" value="{$row_doc->Titel|escape}" /></td>
			<td rowspan="10" valign="top" class="first">
				<h4>{#DOC_QUERIES#}</h4>
				<div style="width:99%;overflow:auto;height:365px">
					{foreach from=$conditions item=cond}
						<input type="text" readonly="" style="width:140px" class="query" value="[cprequest:{$cond->Id}]"> <a onClick="cp_pop('index.php?do=queries&action=edit&Id={$cond->Id}&RubrikId={$cond->RubrikId}&pop=1&cp={$sess}','750','600','1','cond')" title="{$cond->Beschreibung|default:'#DOC_QUERY_NOT_INFO#'|stripslashes|escape:html}" href="javascript:void(0);">{$cond->Titel|escape:html}</a><br />
					{/foreach}
				</div>
			</td>
		</tr>

		<tr>
			<td>{#DOC_URL#}</td>
			<td nowrap="nowrap">
				<input name="Url" type="text" id="Url" size="40" style="width:90%" value="{if $row_doc->Url}{$row_doc->Url}{else}{$autoUrl}{/if}" />&nbsp;
				<input title="{#DOC_URL_INFO#}" class="button" style="cursor:help" type="button" value="?" /><br />
				<input type="button" class="button" id="translit" value="{#DOC_TRANSLIT#}" />&nbsp;
				{*<input type="button" class="button" id="check" value="{#DOC_CHECK_URL#}" />&nbsp;*}
				<span id="loading" style="display:none">&nbsp;&nbsp;&nbsp;<img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif"  border="0" /></span>
				<span id="checkResult"></span>
			</td>
		</tr>

		<tr>
			<td>{#DOC_META_KEYWORDS#}</td>
			<td>
				<input name="MetaKeywords" type="text" id="MetaKeywords" size="40" value="{$row_doc->MetaKeywords}" style="width:90%" />&nbsp;
				<input title="{#DOC_META_KEYWORDS_INFO#}" class="button" style="cursor:help" type="button" value="?" />
			</td>
		</tr>

		<tr>
			<td>{#DOC_META_DESCRIPTION#}</td>
			<td>
				<input name="MetaDescription" type="text" id="MetaDescription" size="40" style="width:90%" value="{$row_doc->MetaDescription}" maxlength="170" />&nbsp;
				<input title="{#DOC_META_DESCRIPTION_INFO#}" class="button" style="cursor:help" type="button" value="?" />
			</td>
		</tr>

		<tr>
			<td>{#DOC_INDEX_TYPE#}</td>
			<td>
				<select style="width:300px" name="IndexFollow" id="IndexFollow">
					<option value="index,follow" {if $row_doc->IndexFollow=='index,follow'}selected{/if}>{#DOC_INDEX_FOLLOW#}</option>
					<option value="index,nofollow" {if $row_doc->IndexFollow=='index,nofollow'}selected{/if}>{#DOC_INDEX_NOFOLLOW#}</option>
					<option value="noindex,nofollow" {if $row_doc->IndexFollow=='noindex,nofollow'}selected{/if}>{#DOC_NOINDEX_NOFOLLOW#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>{#DOC_START_PUBLICATION#}</td>
			<td>
				{if ($smarty.request.Id==1 || $smarty.request.Id==2) && ($smarty.request.action != 'new')}
					{assign var=extra value="disabled"}
				{else}
					{assign var=extra value=""}
				{/if}

				{html_select_date time=$row_doc->DokStart prefix="DokStart" start_year="-10" end_year="+10" display_days=true month_format="%B" reverse_years=false day_size=1 field_order=DMY all_extra=$extra}
				&nbsp;-&nbsp;
				{html_select_time prefix=Start time=$row_doc->DokStart display_seconds=false use_24_hours=true all_extra=$extra}
			</td>
		</tr>

		<tr>
			<td>{#DOC_END_PUBLICATION#}</td>
			<td>
				{if $row_doc->DokEnde<1}
					{assign var=dende value=$def_doc_end_year}
				{else}
					{assign var=dende value=$row_doc->DokEnde}
				{/if}

				{html_select_date time=$dende prefix="DokEnde" start_year="-10" end_year="+30" display_days=true month_format="%B" reverse_years=false day_size=1 field_order=DMY year_empty="" month_empty="" day_empty="" all_extra=$extra}
				&nbsp;-&nbsp;
				{html_select_time prefix=Ende time=$dende display_seconds=false use_24_hours=true all_extra=$extra}
			</td>
		</tr>

		<tr>
			<td>{#DOC_CAN_SEARCH#}</td>
			<td><input name="Suche" type="checkbox" id="Suche" value="1" {if $row_doc->Suche==1 || $smarty.request.action=='new'}checked{/if} /></td>
		</tr>

		<tr>
			<td>{#DOC_STATUS#}</td>
			<td>
				{if $smarty.request.action == 'new'}
					{if  $row_doc->dontChangeStatus==1}
						{assign var=sel_1 value=''}
						{assign var=sel_2 value='selected="selected"'}
					{else}
						{assign var=sel_1 value='selected="selected"'}
						{assign var=sel_2 value=''}
					{/if}
				{else}
					{if $row_doc->DokStatus==1}
						{assign var=sel_1 value='selected="selected"'}
						{assign var=sel_2 value=''}
					{else}
						{assign var=sel_1 value=''}
						{assign var=sel_2 value='selected="selected"'}
					{/if}
				{/if}
				<select style="width:300px" name="DokStatus" id="DokStatus"{if $row_doc->dontChangeStatus==1} disabled="disabled"{/if}>
					<option value="1" {$sel_1}>{#DOC_STATUS_ACTIVE#}</option>
					<option value="0" {$sel_2}>{#DOC_STATUS_INACTIVE#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td>{#DOC_USE_NAVIGATION#} </td>
			<td>
				{include file='navigation/tree.tpl'}
				<input title="{#DOC_NAVIGATION_INFO#}" class="button" style="cursor:help" type="button" value="?" />
			</td>
		</tr>

		<tr>
			<td colspan="3" class="tableheader">{#DOC_MAIN_CONTENT#}</td>
		</tr>

		{foreach from=$items item=df}
			<tr>
				<td><strong>{$df->Titel}</strong></td>
				<td colspan="2">{$df->Feld}</td>
			</tr>
		{/foreach}

	</table>
	<br />

	{*$hidden*}
	{if $smarty.request.action=='edit'}
		<input type="submit" class="button" value="{#DOC_BUTTON_EDIT_DOCUMENT#}" />
	{else}
		<input type="submit" class="button" value="{#DOC_BUTTON_ADD_DOCUMENT#}" />
	{/if}
</form>

{/strip}
<!-- /form.tpl -->
