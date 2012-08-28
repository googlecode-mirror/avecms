<link rel="stylesheet" href="{$ABS_PATH}admin/codemirror/lib/codemirror.css">

<script src="{$ABS_PATH}admin/codemirror/lib/codemirror.js" type="text/javascript"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/xml/xml.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/javascript/javascript.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/css/css.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/clike/clike.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/php/php.js"></script>

{literal}
    <style type="text/css">
      .activeline {background: #e8f2ff !important;}
      .CodeMirror-scroll {height: 450px;}
    </style>
{/literal}

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

<form name="f_tpl" id="f_tpl" method="post" action="{$formaction}">
	<input name="pop" type="hidden" id="pop" value="{$smarty.request.pop|escape}" /><br />
	{assign var=js_form value='f_tpl'}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="238">
		<tr>
			<td colspan="2" class="tableheader">{#REQUEST_SETTINGS#}</td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_NAME2#}</td>
			<td class="second"><input {$dis} style="width:250px" name="request_title" type="text" id="l_Titel" value="{$smarty.request.request_title_new|stripslashes|default:$row->request_title|escape}"></td>
		</tr>
		<tr>
			<td class="first">{#REQUEST_CACHE#}</td>
			<td class="second"><input {$dis} style="width:250px" name="request_cache_lifetime" type="text" id="l_Titel" value="{$smarty.request.request_cache_lifetime|stripslashes|default:$row->request_cache_lifetime|escape}"></td>
		</tr>

		<tr>
			<td class="first">{#REQUEST_SELECT_RUBRIK#}</td>
			<td class="second">
				<select onChange="changeRub(this)" style="width:250px" name="rubric_id" id="rubric_id">
					{if $smarty.request.action=='new' && $smarty.request.rubric_id==''}
						<option value="">{#REQUEST_PLEASE_SELECT#}</option>
					{/if}
					{foreach from=$rubrics item=rubric}
						<option id="RubrikId_{$rubric->Id}" value="{$rubric->Id}"{if $smarty.request.rubric_id==$rubric->Id} selected="selected"{/if}>{$rubric->rubric_title|escape}</option>
						
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
					<option value="RAND()"{if $row->request_order_by=='RAND()'} selected="selected"{/if}>{#REQUEST_BY_RAND#}</option>
				</select>
			</td>
		</tr>
		
		<tr>
			<td class="first">{#REQUEST_SORT_BY_NAT#}</td>
			<td class="second">
				<select {$dis} style="width:250px" name="request_order_by_nat" id="request_order_by_nat">
					<option></option>
					{foreach from=$tags item=tag}
					  <option value="{$tag->Id}" {if $tag->Id == $row->request_order_by_nat}selected="selected"{/if}>{$tag->rubric_field_title}</option>
					{/foreach}
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
					<option value="0" {if $row->request_items_per_page==all} selected="selected"{/if}>{#REQUEST_DOC_PER_PAGE_ALL#}</option>
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
		    <td scope="row" class="first">
			    <strong><a title="{#REQUEST_MAIN_CONTENT#}" href="javascript:void(0);" onclick="textSelection('[tag:content]', '');">[tag:content]</a></strong>
			</td>
			<td rowspan="14" class="second">             
				<div class="coder_in"><textarea {$dis} name="request_template_main" id="request_template_main" wrap="off" style="width:100%; height:400px">{$row->request_template_main|escape|default:''}</textarea></div>
            </td>
        </tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_MAIN_NAVI#}" href="javascript:void(0);" onclick="textSelection('[tag:pages]', '');">[tag:pages]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_CDOCID_TITLE#}" href="javascript:void(0);" onclick="textSelection('[tag:pagetitle]', '');">[tag:pagetitle]</a></strong>
			</td>
		</tr>
		
		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_DOC_COUNT#}" href="javascript:void(0);" onclick="textSelection('[tag:doctotal]', '');">[tag:doctotal]</a></strong>
			</td>
		</tr>
		
		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_CDOCID_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docid]', '');">[tag:docid]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_CDOCDATE_INFO#}" class="rightDir" href="javascript:void(0);" onclick="textSelection('[tag:docdate]', '');">[tag:docdate]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_CDOCTIME_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:doctime]', '');">[tag:doctime]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_CDOCAUTHOR_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docauthor]', '');">[tag:docauthor]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_PATH#}" href="javascript:void(0);" onclick="textSelection('[tag:path]', '');">[tag:path]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_MEDIAPATH#}" href="javascript:void(0);" onclick="textSelection('[tag:mediapath]', '');">[tag:mediapath]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_IF_EMPTY#}" href="javascript:void(0);" onclick="textSelection('[tag:if_empty]\n', '\n[/tag:if_empty]');">[tag:if_empty][/tag:if_empty]</a></strong>
			</td>
		</tr>

		<tr>
			<td scope="row" class="first">
				<strong><a title="{#REQUEST_NOT_EMPTY#}" href="javascript:void(0);" onclick="textSelection('[tag:if_notempty]\n', '\n[/tag:if_notempty]');">[tag:if_notempty][/tag:if_notempty]</a></strong>
			</td>
		</tr>

		<tr>
			{if $ddid != ''}
				<td scope="row" class="first">
					<strong><a title="{#REQUEST_CONTROL_FIELD#}" href="javascript:void(0);" onclick="textSelection('[tag:dropdown:', '{$ddid}]');">[tag:dropdown:{$ddid}]</a></strong>
				</td>
			{else}
				<td scope="row" class="first">
					<strong><a title="{#REQUEST_CONTROL_FIELD#}" href="javascript:void(0);" onclick="alert('{#REQUEST_NO_DROPDOWN#}','');">[tag:dropdown:XX,XX...]</a></strong>
				</td>
			{/if}
		</tr>
        
        <tr>
            <td class="first"><td>			
		</tr> 		
		
        <tr>
            <td class="first">{#REQUEST_HTML_TAGS#}</td>
			<td class="second">	 			
				<div class="infobox">
					|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;					
					<a href="javascript:void(0);" onclick="textSelection('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<div class=&quot;&quot; id=&quot;&quot;>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader"><strong>{#REQUEST_TEMPLATE_ITEMS#}</strong></td>
		</tr>

		<tr>
			<td colspan="2" class="second">{#REQUEST_TEMPLATE_INFO#}</td>
		</tr>

		<tr>
		    <td class="first">
			    <strong><a title="{#REQUEST_RUB_INFO#}" href="javascript:void(0);" onclick="alert('{#REQUEST_SELECT_IN_LIST#}','');">[tag:rfld:ID][XXX]</a></strong>
			</td>
			<td rowspan="11" class="second">
				<div class="coder_in">
				<textarea {$dis} name="request_template_item" id="request_template_item" wrap="off" style="width:100%; height:200px">{$row->request_template_item|escape|default:''}</textarea>
				</div>
			</td>
		</tr>

		<tr>
			<td class="first">
			    <strong><a title="{#REQUEST_LINK_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:link]', '');">[tag:link]</a></strong>
			</td>
		</tr>
		
		<tr>
			<td class="first">
			    <strong><a title="{#REQUEST_DOCID_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:docid]', '');">[tag:docid]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
			    <strong><a title="{#REQUEST_DOCDATE_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:docdate]', '');">[tag:docdate]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
				<strong><a title="{#REQUEST_DOCTIME_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:doctime]', '');">[tag:doctime]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
				<strong><a title="{#REQUEST_DOCAUTHOR_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:docauthor]', '');">[tag:docauthor]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
				<strong><a title="{#REQUEST_VIEWS_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:docviews]', '');">[tag:docviews]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
				<strong><a title="{#REQUEST_COMMENTS_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:doccomments]', '');">[tag:doccomments]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
				<strong><a title="{#REQUEST_PATH#}" href="javascript:void(0);" onclick="textSelection2('[tag:path]', '');">[tag:path]</a></strong>
			</td>
		</tr>

		<tr>
			<td class="first">
				<strong><a title="{#REQUEST_MEDIAPATH#}" class="rightDir" href="javascript:void(0);" onclick="textSelection2('[tag:mediapath]', '');">[tag:mediapath]</a></strong>
			</td>
		</tr>		
		
		<tr class="first">
	        <td></td>
        </tr>
		
        <tr>		
		    <td class="first">{#REQUEST_HTML_TAGS#}</td>
			<td class="second">			
				<div class="infobox">
					|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<ol>', '</ol>');"><strong>OL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<ul>', '</ul>');"><strong>UL</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<li>', '</li>');"><strong>LI</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<p class=&quot;&quot;>', '</p>');"><strong>P</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<strong>', '</strong>');"><strong>B</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<em>', '</em>');"><strong>I</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h1>', '</h1>');"><strong>H1</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h2>', '</h2>');"><strong>H2</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h3>', '</h3>');"><strong>H3</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h4>', '</h4>');"><strong>H4</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h5>', '</h5>');"><strong>H5</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<h6>', '</h6>');"><strong>H6</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<div class=&quot;&quot; id=&quot;&quot;>', '</div>');"><strong>DIV</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<a href=&quot;&quot; title=&quot;&quot;>', '</a>');"><strong>A</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<img src=&quot;&quot; alt=&quot;&quot; />', '');"><strong>IMG</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<span>', '</span>');"><strong>SPAN</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<pre>', '</pre>');"><strong>PRE</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('<br />', '');"><strong>BR</strong></a>&nbsp;|&nbsp;
					<a href="javascript:void(0);" onclick="textSelection2('\t', '');"><strong>TAB</strong></a>&nbsp;|
				</div>
		    </td>
        </tr> 		
		<tr>
			<td colspan="2" class="second">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<col width="230">
					<tr class="tableheader">
						<td>{#REQUEST_RUBRIK_FIELD#}</td>
						<td>{#REQUEST_FIELD_NAME#}</td>
						<td>{#REQUEST_FIELD_TYPE#}</td>
					</tr>

					{foreach from=$tags item=tag}
						<tr>
							<td class="first"><a title="{#REQUEST_INSERT_INFO#}" href="javascript:void(0);" onclick="textSelection2('[tag:rfld:{$tag->Id}][', '150]');">[tag:rfld:{$tag->Id}][150]</a></td>
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
	</table>
	<br />
		{if $smarty.request.action=='edit'}
			<input {$dis} type="submit" class="button" value="{#REQUEST_BUTTON_SAVE#}" />
		{else}
			<input {$dis} type="submit" class="button" value="{#REQUEST_BUTTON_ADD#}" />
		{/if}
		{#REQUEST_OR#}
		{if $smarty.request.action=='edit'}
			<input {$dis} type="submit" class="button button_lev2" name="next_edit" value="{#REQUEST_BUTTON_SAVE_NEXT#}" />
		{else}
			<input {$dis} type="submit" class="button" name="next_edit" value="{#REQUEST_BUTTON_ADD_NEXT#}" />
		{/if}
		<span id="loading" style="display:none">&nbsp;&nbsp;&nbsp;<img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif" border="0" /></span>
		<span id="checkResult"></span>		
</form>

    <script language="Javascript" type="text/javascript">
	var sett_options = {ldelim}
		url: '{$formaction}',
		beforeSubmit: function(){ldelim}
			$("#checkResult").html('');
			{rdelim},
        success: function(){ldelim}
			$("#checkResult").html('{#REQUEST_RESULT_INFO#}');
			{rdelim}	
	{rdelim}

	$(document).ready(function(){ldelim}

	    $(".button_lev2").click(function(e){ldelim}
		    if (e.preventDefault) {ldelim}
		        e.preventDefault();
		    {rdelim} else {ldelim}
		        // internet explorer
		        e.returnValue = false;
		    {rdelim}
		    $("#f_tpl").ajaxSubmit(sett_options);
			return false;
		{rdelim});

	{rdelim});	
	
	$("#loading")
		.bind("ajaxSend", function(){ldelim}$(this).show();{rdelim})
		.bind("ajaxComplete", function(){ldelim}$(this).hide();{rdelim});	

{literal}
      var editor = CodeMirror.fromTextArea(document.getElementById("request_template_main"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor.save();},
		onCursorActivity: function() {
		  editor.setLineClass(hlLine, null, null);
		  hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange() {
        return { from: editor.getCursor(true), to: editor.getCursor(false) };
      }

      function textSelection(startTag,endTag) {
        var range = getSelectedRange();
        editor.replaceRange(startTag + editor.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor.setCursor(range.from.line, range.from.ch + startTag.length);
      }

	  var hlLine = editor.setLineClass(0, "activeline");

      var editor2 = CodeMirror.fromTextArea(document.getElementById("request_template_item"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor2.save();},
		onCursorActivity: function() {
		  editor2.setLineClass(hlLine, null, null);
		  hlLine = editor2.setLineClass(editor2.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange2() {
        return { from: editor2.getCursor(true), to: editor2.getCursor(false) };
      }

      function textSelection2(startTag,endTag) {
        var range = getSelectedRange2();
        editor2.replaceRange(startTag + editor2.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor2.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor2.setLineClass(0, "activeline");
{/literal}
    </script>