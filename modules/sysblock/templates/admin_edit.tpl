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
    </style>
{/literal}

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
    <div class="HeaderTitle">
    	<h2>{#SYSBLOCK_INSERT_H#}</h2>
    </div>
    <div class="HeaderText">{#SYSBLOCK_INSERT#}</div>
</div><br />

<div class="infobox">
	» <a href="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=1&cp={$sess}">{#SYSBLOCK_LIST_LINK#}</a>
</div><br />

<form id="sysblock" action="index.php?do=modules&action=modedit&mod=sysblock&moduleaction=saveedit&cp={$sess}" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	    <col width="200" class="first">
		<col class="second">
		
		<tr>
			<td colspan="2" class="tableheader">{if $smarty.request.id != ''}{#SYSBLOCK_EDIT_T#}{else}{#SYSBLOCK_INSERT_T#}{/if}</td>
		</tr>

		<tr>
		    <td>{#SYSBLOCK_NAME#}</td>
			<td>
				<input name="sysblock_name" type="text" value="{$sysblock_name|escape}" size="80" />
			</td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#SYSBLOCK_HTML#}</td>
		</tr>		
		
		<tr>
		    <td>{#SYSBLOCK_TAGS#}</td>
			<td>{#SYSBLOCK_HTML#}</td>
		</tr>

		<tr>
		    <td>
			    <a title="{#SYSBLOCK_MEDIAPATH#}" href="javascript:void(0);" onclick="textSelection('[tag:mediapath]','');"><strong>[tag:mediapath]</strong></a>
			</td>
			<td rowspan="6">			
				<div class="coder_in">
					<textarea  id="sysblock_text" name="sysblock_text" style="width: 100%; height: 400px;">{$sysblock_text}</textarea>
				</div>
			</td>
		</tr>

		<tr>
			<td>
				<a title="{#SYSBLOCK_PATH#}" href="javascript:void(0);" onclick="textSelection('[tag:path]','');"><strong>[tag:path]</strong></a>
			</td>
		</tr>
		<tr>
			<td>
				<a title="{#SYSBLOCK_HOME#}" href="javascript:void(0);" onclick="textSelection('[tag:home]','');"><strong>[tag:home]</strong></a>
			</td>
		</tr>
		<tr>
			<td>
				<a title="{#SYSBLOCK_DOCID_INFO#}" href="javascript:void(0);" onclick="textSelection('[tag:docid]','');"><strong>[tag:docid]</strong></a>
			</td>
		</tr>
		<tr>
			<td>
				<a title="{#SYSBLOCK_BREADCRUMB#}" href="javascript:void(0);" onclick="textSelection('[tag:breadcrumb]','');"><strong>[tag:breadcrumb]</strong></a>
			</td>
		</tr>

		<tr>
			<td>

			</td>
		</tr>
		
		<tr>
		    <td>{#SYSBLOCK_TAGS_2#}</td>
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
	</table>
	<br />
	
	{if $smarty.request.id != ''}
		<input type="hidden" name="id" value="{$id}">
		<input name="submit" type="submit" class="button" value="{#SYSBLOCK_SAVEDIT#}" />
	{else}
		<input name="submit" type="submit" class="button" value="{#SYSBLOCK_SAVE#}" />
	{/if}
	{#SYSBLOCK_OR#}
	{if $smarty.request.moduleaction=='edit'}
		<input type="submit" class="button button_lev2" name="next_edit" value="{#SYSBLOCK_SAVEDIT_NEXT#}" />
	{else}
		<input type="submit" class="button button_lev2" name="next_edit" value="{#SYSBLOCK_SAVE_NEXT#}" />
	{/if}
    <span id="loading" style="display:none">&nbsp;&nbsp;&nbsp;<img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif" border="0" /></span>
	<span id="checkResult"></span>
</form>

<script language="javascript">
    var sett_options = {ldelim}
		url: 'index.php?do=modules&action=modedit&mod=sysblock&moduleaction=saveedit&cp={$sess}',
		beforeSubmit: function(){ldelim}
			$("#checkResult").html('');
			{rdelim},
        success: function(){ldelim}
			$("#checkResult").html('{#SYSBLOCK_RESULT_INFO#}');
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
		    $("#sysblock").ajaxSubmit(sett_options);
			return false;
		{rdelim});

	{rdelim});
	
	$("#loading")
		.bind("ajaxSend", function(){ldelim}$(this).show();{rdelim})
		.bind("ajaxComplete", function(){ldelim}$(this).hide();{rdelim});
		
	{literal}
      var editor = CodeMirror.fromTextArea(document.getElementById("sysblock_text"), {
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