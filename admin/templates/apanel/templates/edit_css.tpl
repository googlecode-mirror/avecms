<script src="{$ABS_PATH}admin/codemirror/js/codemirror.js" type="text/javascript"></script>

	<div class="h_tpl">&nbsp;</div>
	<h2>�������� ������</h2>
	<p>����������, ������ ��������� ����������� ��� �������������� ������ � �������, ��� ������� ��������� ��� ����� ��������� ������� ���������� �����</p>
	
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
			<td class="tableheader" colspan="2">���</td>
		</tr>

		<tr>
			<td class="second">
				<div class="coder_in">
					<textarea id="coder_sours" wrap="off" id="code_text" name="code_text" cols="120" rows="30"><style>{$code_text}</style></textarea>
				</div>
				<script src="{$ABS_PATH}admin/codemirror/config.js" type="text/javascript"></script>
			</td>
		</tr>
		
		<tr>
			<td class="second">			
				<button class="button">{if $smarty.request.action=='new'}{#TEMPLATES_BUTTON_ADD#}{else}{#TEMPLATES_BUTTON_SAVE#}{/if}</button>
			</td>
		</tr>
	</table>
</form>
