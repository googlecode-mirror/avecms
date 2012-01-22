{if $smarty.session.use_editor == 1}
	<!-- css -->
	<link rel="stylesheet" href="{$ABS_PATH}admin/redactor/elrte/css/elrte.min.css" type="text/css" media="screen">
	<link rel="stylesheet" href="{$ABS_PATH}admin/redactor/elfinder/css/elfinder.full.css" type="text/css" media="screen">
	<link rel="stylesheet" href="{$ABS_PATH}admin/redactor/elfinder/css/theme.css" type="text/css" media="screen"></link>
	<!-- translation messages -->
	<script src="{$ABS_PATH}admin/redactor/elrte/js/elrte.min.js" type="text/javascript"></script>
	<script src="{$ABS_PATH}admin/redactor/elrte/js/i18n/elrte.ru.js" type="text/javascript"></script>
	
	<!-- elfinder -->
	<script src="{$ABS_PATH}admin/redactor/elfinder/js/elfinder.full.js" type="text/javascript"></script>
	<script src="{$ABS_PATH}admin/redactor/elfinder/js/i18n/elfinder.ru.js" type="text/javascript"></script>
	<script src="{$ABS_PATH}admin/redactor/elfinder/js/jquery.dialogelfinder.js" type="text/javascript"></script>
	
	<script type="text/javascript" src="{$tpl_dir}/js/rle.js"></script>	
{/if}
	
{if $smarty.session.use_editor == 2}	
	<script language="Javascript" src="{$ABS_PATH}admin/redactor/innova/scripts/language/ru-RU/editor_lang.js"></script>
  <script language=JavaScript src='{$ABS_PATH}admin/redactor/innova/scripts/innovaeditor.js'></script>	
{/if}	

 <link rel="stylesheet" href="{$tpl_dir}/js/jquery/plugin/jquery-ui-time.css" type="text/css">	
 <script src="{$tpl_dir}/js/jquery/plugin/jquery-ui-time.js" type="text/javascript"></script>

<script type="text/javascript">
{*
function insertHTML(ed, code) {ldelim}
	document.getElementById('feld['+ed+']___Frame').contentWindow.FCK.InsertHtml(code);
{rdelim}
*}
function openLinkWin(target,doc) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'doc_title';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('index.php?idonly=1&do=docs&action=showsimple&doc='+doc+'&target='+target+'&pop=1&cp={$sess}','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}

function openFileWin(target,id) {ldelim}
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.6;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.6;
	if (typeof doc=='undefined') var doc = 'doc_title';
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('browser.php?id='+id+'&typ=bild&mode=fck&target=navi&cp={$sess}','pop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
{rdelim}

$(document).ready(function(){ldelim}
	function check(){ldelim}
		$.ajax({ldelim}
			beforeSend: function(){ldelim}
				$("#checkResult").html('');
				{rdelim},
			url: 'index.php',
			data: ({ldelim}
				action: 'checkurl',
				'do': 'docs',
				cp: '{$sess}',
				id: '{$document->Id}',
				alias: $("#document_alias").val()
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
			url:'index.php',
			data: ({ldelim}
				action: 'translit',
				'do': 'docs',
				cp: '{$sess}',
				alias: $("#document_alias").val(),
				title: $("#doc_title").val(),
				prefix: '{$document->rubric_url_prefix}'
				{rdelim}),
			timeout:3000,
			success: function(data){ldelim}
				$("#document_alias").val(data);
				check();
				{rdelim}
		{rdelim});
	{rdelim});

	$("#document_alias").change(function(){ldelim}
		if ($("#document_alias").val()!='') check();
	{rdelim});

	$("#loading")
		.bind("ajaxSend", function(){ldelim}$(this).show();{rdelim})
		.bind("ajaxComplete", function(){ldelim}$(this).hide();{rdelim});

	{if $smarty.request.feld != ''}
		$("#feld_{$smarty.request.feld|escape}").css({ldelim}
			'border' : '2px solid red',
			'font' : '120% verdana,arial',
			'background' : '#ffffff'
		{rdelim});
	{/if}
$('#document_published').datetimepicker({ldelim}
		timeOnlyTitle: 'Выберите время',
		timeText: 'Время',
		hourText: 'Часы',
		minuteText: 'Минуты',
		secondText: 'Секунды',
		currentText: 'Теперь',
		closeText: 'Закрыть',
		
		onClose: function(dateText, inst) {ldelim}
        var endDateTextBox = $('#document_expire');
        if (endDateTextBox.val() != '') {ldelim}
            var testStartDate = new Date(dateText);
            var testEndDate = new Date(endDateTextBox.val());
            if (testStartDate > testEndDate)
                endDateTextBox.val(dateText);
        {rdelim}
        else {ldelim}
            endDateTextBox.val(dateText);
        {rdelim}
	    {rdelim},
	    onSelect: function (selectedDateTime){ldelim}
	        var start = $(this).datetimepicker('getDate');
	        $('#document_expire').datetimepicker('option', 'minDate', new Date(start.getTime()));
	    {rdelim}
	{rdelim});
	
	
	$('#document_expire').datetimepicker({ldelim}
		timeOnlyTitle: 'Выберите время',
		timeText: 'Время',
		hourText: 'Часы',
		minuteText: 'Минуты',
		secondText: 'Секунды',
		currentText: 'Теперь',
		closeText: 'Закрыть',
		
		onClose: function(dateText, inst) {ldelim}
        var startDateTextBox = $('#document_published');
        if (startDateTextBox.val() != '') {ldelim}
            var testStartDate = new Date(startDateTextBox.val());
            var testEndDate = new Date(dateText);
            if (testStartDate > testEndDate)
                startDateTextBox.val(dateText);
        {rdelim}
        else {ldelim}
            startDateTextBox.val(dateText);
        {rdelim}
    {rdelim},
    onSelect: function (selectedDateTime){ldelim}
        var end = $(this).datetimepicker('getDate');
        $('#document_published').datetimepicker('option', 'maxDate', new Date(end.getTime()) );
    {rdelim}
	{rdelim});
{rdelim});
</script>

<div id="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	{if $smarty.request.action=='edit'}
		<div class="HeaderTitle">
			<h2>{#DOC_EDIT_DOCUMENT#}<span style="color:#000"> &gt; {$document->document_title}</span></h2>
		</div>
	{else}
		<div class="HeaderTitle">
			<h2>{#DOC_ADD_DOCUMENT#}</h2>
		</div>
	{/if}
	<div class="HeaderText">
		<strong>Рубрика</strong> &gt; {$document->rubric_title|escape}
	</div>
</div>
<div class="upPage">&nbsp;</div>

<form method="post" name="formDocOption" action="{$document->formaction}" enctype="multipart/form-data">
	<input type="hidden" name="prefix" value="{$document->rubric_url_prefix}" />
	<input name="closeafter" type="hidden" id="closeafter" value="{$smarty.request.closeafter}">
		{if $smarty.request.action=='edit'}
		<input type="submit" class="button" value="{#DOC_BUTTON_EDIT_DOCUMENT#}" />
	{else}
		<input type="submit" class="button" value="{#DOC_BUTTON_ADD_DOCUMENT#}" />
	{/if}<br /><br />
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="200" class="first">
		<col class="second">

		<tr>
			<td colspan="3" class="tableheader">{#DOC_OPTIONS#}</td>
		</tr>

		<tr>
			<td>{#DOC_NAME#}</td>
			<td><input name="doc_title" type="text" id="doc_title" size="40" style="width:90%" value="{$document->document_title|escape}" /></td>
			<td rowspan="11" valign="top" class="first">
				<h4>{#DOC_QUERIES#}</h4>
				<div style="width:99%;overflow:auto;height:365px">
					{foreach from=$conditions item=cond}
						<input type="text" readonly style="width:140px" class="query" value="[tag:request:{$cond->Id}]"> <a onClick="cp_pop('index.php?do=request&action=edit&Id={$cond->Id}&rubric_id={$cond->rubric_id}&pop=1&cp={$sess}','750','600','1','cond')" title="{$cond->request_description|default:'#DOC_REQUEST_NOT_INFO#'|escape|stripslashes}" href="javascript:void(0);">{$cond->request_title|escape}</a><br />
					{/foreach}
				</div>
			</td>
		</tr>

		<tr>
			<td>{#DOC_URL#}</td>
			<td nowrap="nowrap">
				<input name="document_alias" type="text" id="document_alias" size="40" style="width:90%" value="{if $smarty.request.action=='edit'}{$document->document_alias}{else}{$document->rubric_url_prefix}{/if}" />&nbsp;
				<input title="{#DOC_URL_INFO#}" class="button" style="cursor:help" type="button" value="?" /><br />
				<input type="button" class="button" id="translit" value="{#DOC_ALIAS_CREATE#}" />&nbsp;
				<span id="loading" style="display:none">&nbsp;&nbsp;&nbsp;<img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif"  border="0" /></span>
				<span id="checkResult"></span>
			</td>
		</tr>

		<tr>
			<td>{#DOC_META_KEYWORDS#}</td>
			<td>
				<input name="document_meta_keywords" type="text" id="document_meta_keywords" size="40" value="{$document->document_meta_keywords|escape}" style="width:90%" />&nbsp;
				<input title="{#DOC_META_KEYWORDS_INFO#}" class="button" style="cursor:help" type="button" value="?" />
			</td>
		</tr>

		<tr>
			<td>{#DOC_META_DESCRIPTION#}</td>
			<td>
				<input name="document_meta_description" type="text" id="document_meta_description" size="40" style="width:90%" value="{$document->document_meta_description|escape}" maxlength="170" />&nbsp;
				<input title="{#DOC_META_DESCRIPTION_INFO#}" class="button" style="cursor:help" type="button" value="?" />
			</td>
		</tr>

		<tr>
			<td>{#DOC_INDEX_TYPE#}</td>
			<td>
				<select style="width:300px" name="document_meta_robots" id="document_meta_robots">
					<option value="index,follow"{if $document->document_meta_robots=='index,follow'} selected="selected"{/if}>{#DOC_INDEX_FOLLOW#}</option>
					<option value="index,nofollow"{if $document->document_meta_robots=='index,nofollow'} selected="selected"{/if}>{#DOC_INDEX_NOFOLLOW#}</option>
					<option value="noindex,nofollow"{if $document->document_meta_robots=='noindex,nofollow'} selected="selected"{/if}>{#DOC_NOINDEX_NOFOLLOW#}</option>
				</select>
			</td>
		</tr>

		{if ($smarty.request.Id == 1 || $smarty.request.Id == $PAGE_NOT_FOUND_ID) && $smarty.request.action != 'new'}
			{assign var=extra value="disabled"}
		{else}
			{assign var=extra value=""}
		{/if}

		<tr>
			<td>{#DOC_START_PUBLICATION#}</td>
			<td>				
				<input id="document_published" name="document_published" type="text" value="{$document->document_published|date_format:"%d.%m.%Y %H:%M"}" />
			</td>
		</tr>

		<tr>
			<td>{#DOC_END_PUBLICATION#}</td>
			<td>
				<input id="document_expire" name="document_expire" type="text" value="{$document->document_expire|date_format:"%d.%m.%Y %H:%M"}" />
			</td>
		</tr>

		<tr>
			<td>{#DOC_CAN_SEARCH#}</td>
			<td><input name="document_in_search" type="checkbox" id="document_in_search" value="1" {if $document->document_in_search==1 || $smarty.request.action=='new'}checked{/if} /></td>
		</tr>

		<tr>
			<td>{#DOC_STATUS#}</td>
			<td>
				{if $smarty.request.action == 'new'}
					{if  $document->dontChangeStatus==1}
						{assign var=sel_1 value=''}
						{assign var=sel_2 value='selected="selected"'}
					{else}
						{assign var=sel_1 value='selected="selected"'}
						{assign var=sel_2 value=''}
					{/if}
				{else}
					{if $document->document_status==1}
						{assign var=sel_1 value='selected="selected"'}
						{assign var=sel_2 value=''}
					{else}
						{assign var=sel_1 value=''}
						{assign var=sel_2 value='selected="selected"'}
					{/if}
				{/if}
				<select style="width:300px" name="document_status" id="document_status"{if $document->dontChangeStatus==1} disabled="disabled"{/if}>
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
			<td>{#DOC_USE_BREADCRUMB#}</td>
			<td>
				<input name="document_parent" type="text" id="document_parent" value="{$document->document_parent}" size="4" maxlength="10" />&nbsp;
				<span class="button" onClick="openLinkWin('document_parent','document_parent');">выбрать</span>
			</td>
		</tr>

		<tr>
			<td colspan="3" class="tableheader">{#DOC_MAIN_CONTENT#}</td>
		</tr>

		{foreach from=$document->fields item=document_field}
			<tr>
				<td><strong>{$document_field->rubric_field_title|escape}</strong></td>
				<td colspan="2">{$document_field->Feld}</td>
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