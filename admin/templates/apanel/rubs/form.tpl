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
      .CodeMirror-scroll {height: 400px;}
    </style>
{/literal}

<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	{if $smarty.request.action=='new'}
		<div class="HeaderTitle"><h2>{#RUBRIK_TEMPLATE_NEW#}<span style="color: #000;"> &gt; {$row->rubric_title|escape}</span></h2></div>
	{else}
		<div class="HeaderTitle"><h2>{#RUBRIK_TEMPLATE_EDIT#}<span style="color: #000;"> &gt; {$row->rubric_title|escape}</span></h2></div>
	{/if}
	<div class="HeaderText">{#RUBRIK_TEMPLATE_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form name="f_tpl" id="f_tpl" method="post" action="{$formaction}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	    <col width="200" class="first">
		<col class="second">	
	
		{if $errors}
			<tr>
				<td class="tableheader">{#RUBRIK_HTML#}</td>
			</tr>

			<tr class="{cycle name='ta' values='first,second'}">
				<td>
				{foreach from=$errors item=e}
					{assign var=message value=$e}
					<ul>
						<li>{$message}</li>
					</ul>
				{/foreach}
				</td>
			</tr>
		{/if}

		<tr>
			<td colspan="2" class="tableheader">{#RUBRIK_HTML#}</td>
		</tr>

		<tr>
			<td>
			    <a class="rightDir" title="{#RUBRIK_DOCID_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docid]', '');"><strong>[tag:docid]</strong></a>
			</td>
			<td rowspan="11">
				{if $php_forbidden==1}
					<div class="infobox_error">{#RUBRIK_PHP_DENIDED#} </div>
				{/if}
                <div class="coder_in">
				<textarea {$read_only} class="{if $php_forbidden==1}tpl_code_readonly{else}{/if}" wrap="off" style="width:100%; height:350px" name="rubric_template" id="rubric_template">{$row->rubric_template|default:$prefab|escape:html}</textarea>
                </div> 
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_DOCDATE_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docdate]', '');"><strong>[tag:docdate]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_DOCTIME_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:doctime]', '');"><strong>[tag:doctime]</strong></a>
			</td>
		</tr>
			
		<tr>
			<td>
		<a title="{#RUBRIK_DOCAUTHOR_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docauthor]', '');"><strong>[tag:docauthor]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_VIEWS_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docviews]', '');"><strong>[tag:docviews]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_TITLE_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:title]', '');"><strong>[tag:title]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_PATH_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:path]', '');"><strong>[tag:path]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_MEDIAPATH_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:mediapath]', '');"><strong>[tag:mediapath]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_HIDE_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:hide::', ']\n\n[/tag:hide]');"><strong>[tag:hide:X,X:text][/tag:hide]</strong></a>
			</td>
		</tr>
		
		<tr>
			<td>
		<a title="{#RUBRIK_BREADCRUMB#}" href="javascript:void(0);" onclick="textSelection('[tag:breadcrumb]', '');"><strong>[tag:breadcrumb]</strong></a>
			</td>
		</tr>

        <tr>
            <td></td>
        </tr>
		
        <tr>
            <td>HTML Tags</td>
			<td>
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
			<td colspan="2" class="second">
				<table width="100%" border="0" cellspacing="1" cellpadding="4">
					<tr class="tableheader">
						<td width="10%">{#RUBRIK_ID#}</td>
						<td width="20%">{#RUBRIK_FIELD_NAME#}</td>
						<td width="30%">{#RUBRIK_FIELD_TYPE#}</td>
					</tr>

					{foreach from=$tags item=tag}
						<tr>
							<td width="10%" class="first"><a title="{#RUBRIK_INSERT_HELP#}" href="javascript:void(0);" onclick="textSelection('[tag:fld:{$tag->Id}]', '');">[tag:fld:{$tag->Id}]</a></td>
							<td width="10%" class="first"><strong>{$tag->rubric_field_title}</strong></td>
							<td width="10%" class="first">
								{section name=feld loop=$feld_array}
									{if $tag->rubric_field_type == $feld_array[feld].id}{$feld_array[feld].name}{/if}
								{/section}
							</td>
						</tr>
					{/foreach}
				</table>
			</td>
		</tr>
	</table>
	<br />
	
	<input type="hidden" name="Id" value="{$smarty.request.Id|escape}">
	<input class="button" type="submit" value="{#RUBRIK_BUTTON_TPL#}" />{#RUBRIK_OR#}<input type="submit" class="button button_lev2" name="next_edit" value="{#RUBRIK_BUTTON_TPL_NEXT#}" />
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
			$("#checkResult").html('{#RUBRIK_RESULT_INFO#}');
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
      var editor = CodeMirror.fromTextArea(document.getElementById("rubric_template"), {
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
{/literal}
    </script>