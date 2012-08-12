<link rel="stylesheet" href="{$ABS_PATH}admin/codemirror/lib/codemirror.css">

<script src="{$ABS_PATH}admin/codemirror/lib/codemirror.js" type="text/javascript"></script>
<script src="{$ABS_PATH}admin/codemirror/mode/css/css.js"></script>

{literal}
    <style type="text/css">
      .activeline {background: #e8f2ff !important;}
    </style>
{/literal}

	<div class="h_tpl">&nbsp;</div>
	<h2>Редактор файлов</h2>
	<p>Пожалуйста, будьте предельно внимательны при редактировании файлов и помните, что неверно указанный код может испортить внешнее оформление сайта</p>
	
<form name="f_tpl" id="f_tpl" method="post" action="{$formaction}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td width="10">{#TEMPLATES_CSS_NAME#}</td>
	</tr>
	
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';">
			<td>
				<input name="template_title" type="text" value="{$smarty.request.name_file|escape}" size="50" maxlength="50" >
			</td>
		</tr>

		<tr>
			<td class="tableheader" colspan="2">Код</td>
		</tr>

		<tr>
			<td class="second">
				<div class="coder_in">
					<textarea id="code_text" name="code_text" style="width: 100%; height: 400px;"><style>{$code_text}</style></textarea>
				</div>
			</td>
		</tr>
		
		<tr>
			<td class="second">			
				<button class="button">{if $smarty.request.action=='new'}{#TEMPLATES_BUTTON_ADD#}{else}{#TEMPLATES_BUTTON_SAVE#}{/if}</button> или <input type="submit" class="button button_lev2" name="next_edit" value="{#TEMPLATES_BUTTON_SAVE_NEXT#}" />
			</td>
		</tr>
	</table>
</form>

    <script language="Javascript" type="text/javascript">
{literal}
      var editor = CodeMirror.fromTextArea(document.getElementById("code_text"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "text/css",
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