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
      .CodeMirror-scroll {height: 500px;}
    </style>
{/literal}

<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_tpl">&nbsp;</div>
	{if $smarty.request.action=='new'}
		<div class="HeaderTitle"><h2>{#TEMPLATES_TITLE_NEW#}</h2></div>
		<div class="HeaderText">{#TEMPLATES_WARNING2#}</div>
	{else}
		<div class="HeaderTitle"><h2>{#TEMPLATES_TITLE_EDIT#}<span style="color:#000;">&nbsp;&gt;&nbsp;{$row->template_title|escape}{$smarty.request.TempName|escape}</span></h2></div>
		<div class="HeaderText">{#TEMPLATES_WARNING1#}</div>
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <col width="230">
	{if $smarty.request.action=='new'}
	<tr>
		<td colspan="2" class="tableheader">{#TEMPLATES_LOAD_INFO#}</td>
	</tr>

	<tr>
		<td class="first">{#TEMPLATES_LOAD_INFO#}</td>
		<td class="second">
		  <form action="index.php?do=templates&action=new" method="post">
			<select name="theme_pref">
			  <option></option>
			  {$sel_theme}
			</select>
			<input type="hidden" name="TempName" value="{$smarty.request.TempName|escape:html}">
			<input type="submit" class="button" value="{#TEMPLATES_BUTTON_LOAD#}">
		  </form>
		</td>
	 </tr>
	 {/if}

<form name="f_tpl" id="f_tpl" method="post" action="{$formaction}">
    <tr>
        <td colspan="2" class="tableheader">{if $smarty.request.action=='new'}{#TEMPLATES_TITLE_NEW#}{else}{#TEMPLATES_TITLE_EDIT#}{/if}</td>
    </tr>

    <tr>
		<td class="first">{#TEMPLATES_NAME#}</td>
		<td class="second">
		  {foreach from=$errors item=e}
			{assign var=message value=$e}
			<ul>
			  <li>{$message}</li>
			</ul>
		  {/foreach}
		  <input name="template_title" type="text" value="{$row->template_title|escape:html}{$smarty.request.TempName|escape:html}" size="50" maxlength="50" >
		</td>
    </tr>

    <tr>
        <td colspan="2" class="tableheader">{#TEMPLATES_HTML#}</td>
    </tr>

    <tr>
		<td class="first">{#TEMPLATES_TAGS#}</td>
		<td class="second">{#TEMPLATES_HTML#}</td>
    </tr>	
  
    <tr>
		<td class="first">
			<a title="{#TEMPLATES_THEME_FOLDER#}" href="javascript:void(0);" onclick="textSelection('[tag:theme:',']');">[tag:theme:folder]</a>
		</td>
		<td rowspan="18" class="second">
		  {if $php_forbidden==1}
			<div class="infobox_error">{#TEMPLATES_USE_PHP#} </div>
		  {/if}      
				<div class="coder_in"><textarea {$read_only} class="{if $php_forbidden==1}tpl_code_readonly{else}{/if}" wrap="off" style="width:100%; height:500px" name="template_text" id="template_text">{$row->template_text|default:$prefab|escape}</textarea></div>
		</td>
    </tr>
 
	<tr>
		<td class="first">
			<a title="{#TEMPLATES_PAGENAME#}" href="javascript:void(0);" onclick="textSelection('[tag:sitename]','');">[tag:sitename]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_TITLE#}" href="javascript:void(0);" onclick="textSelection('[tag:title]','');">[tag:title]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_KEYWORDS#}" href="javascript:void(0);" onclick="textSelection('[tag:keywords]','');">[tag:keywords]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_DESCRIPTION#}" href="javascript:void(0);" onclick="textSelection('[tag:description]','');">[tag:description]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_INDEXFOLLOW#}" href="javascript:void(0);" onclick="textSelection('[tag:robots]','');">[tag:robots]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_PATH#}" href="javascript:void(0);" onclick="textSelection('[tag:path]','');">[tag:path]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_MEDIAPATH#}" href="javascript:void(0);" onclick="textSelection('[tag:mediapath]','');">[tag:mediapath]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_MAINCONTENT#}" href="javascript:void(0);" onclick="textSelection('[tag:maincontent]','');">[tag:maincontent]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_DOCUMENT#}" href="javascript:void(0);" onclick="textSelection('[tag:document]','');">[tag:document]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_PRINTLINK#}" href="javascript:void(0);" onclick="textSelection('[tag:printlink]','');">[tag:printlink]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_HOME#}" href="javascript:void(0);" onclick="textSelection('[tag:home]','');">[tag:home]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_VERSION#}" href="javascript:void(0);" onclick="textSelection('[tag:version]','');">[tag:version]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_IF_PRINT#}" href="javascript:void(0);" onclick="textSelection('[tag:if_print]\n','\n[/tag:if_print]');">[tag:if_print][/tag:if_print]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_DONOT_PRINT#}" href="javascript:void(0);" onclick="textSelection('[tag:if_notprint]\n','\n[/tag:if_notprint]');">[tag:if_notprint][/tag:if_notprint]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_NAVIGATION#}" href="javascript:void(0);" onclick="textSelection('[mod_navigation:]','');">[mod_navigation:XXX]</a>
		</td>
	</tr>

	<tr>
		<td class="first">
			<a title="{#TEMPLATES_QUICKFINDER#}" href="javascript:void(0);" onclick="textSelection('[mod_quickfinder:]','');">[mod_quickfinder:XXX]</a>
		</td>
	</tr>
 
    <tr class="first">
        <td></td>
    </tr>
   
    <tr>
        <td class="first">{#TEMPLATES_TAGS_2#}</td>
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
		<td colspan="2">
		  <input type="hidden" name="Id" value="{$smarty.request.Id}">
		  {if $smarty.request.action=='new'}
			<input class="button" type="submit" value="{#TEMPLATES_BUTTON_ADD#}" />
		  {else}
			<input class="button" type="submit" value="{#TEMPLATES_BUTTON_SAVE#}" />
		  {/if}
		    {#TEMPLATES_OR#}
		  {if $smarty.request.action=='edit'}
				<input type="submit" class="button button_lev2" name="next_edit" value="{#TEMPLATES_BUTTON_SAVE_NEXT#}" />
			{else}
				<input type="submit" class="button" name="next_edit" value="{#TEMPLATES_BUTTON_ADD_NEXT#}" />
			{/if}
			<span id="loading" style="display:none">&nbsp;&nbsp;&nbsp;<img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif" border="0" /></span>
			<span id="checkResult"></span>			
		</td>
	</tr>
 </form>
</table>

    <script language="Javascript" type="text/javascript">
	var sett_options = {ldelim}
		url: '{$formaction}',
		beforeSubmit: function(){ldelim}
			$("#checkResult").html('');
			{rdelim},
        success: function(){ldelim}
			$("#checkResult").html('{#TEMPLATES_RESULT_INFO#}');
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
      var editor = CodeMirror.fromTextArea(document.getElementById("template_text"), {
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