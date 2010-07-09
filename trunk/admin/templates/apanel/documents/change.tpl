{if check_permission('docs')}

<script type="text/javascript" language="JavaScript">
function ChangeRazd() {ldelim}
	window.location.href='index.php?do=docs&action=change&Id={$smarty.request.Id|escape}&rubric_id={$smarty.request.rubric_id|escape}&NewRubr='+document.form1.NewRubr.value+'&pop=1&cp={$sess}';
{rdelim}
</script>

<div id="pageHeaderTitle" style="padding-top:7px">
	<div class="h_docs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#DOC_CHANGE_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#DOC_CHANGE_INFO#}</div>
</div><br />

<form name="form1" action="{$formaction}" method="post">
	<table cellpadding="8" cellspacing="1" class="tableborder" width="100%">
		<tr>
			<td colspan="2" class="second">
				<select style="width:372px" name="NewRubr" size="1" onchange="ChangeRazd();">
					<option value=""></option>
					{foreach from=$rubrics item=rubric}
						{if $rubric->Show==1}
							<option value="{$rubric->Id}" {if ($smarty.request.NewRubr=='' && $smarty.request.rubric_id==$rubric->Id) || ($smarty.request.NewRubr!='' && $smarty.request.NewRubr==$rubric->Id)}selected{/if}>{$rubric->rubric_title|escape}</option>
						{/if}
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td class="tableheader">{#DOC_CHANGE_OLD_FIELD#}</td>
			<td class="tableheader">{#DOC_CHANGE_NEW_FIELD#}</td>
		</tr>

		{foreach from=$fields item=field key=Id}
			<tr>
				<td class="{cycle values='first,second' advance=false}">{$field.title}</td>
				<td class="{cycle values='first,second'}">
					{html_options name=$Id options=$field.Options selected=$field.Selected style="width:200px"}
				</td>
			</tr>
		{/foreach}

		<tr>
			<td colspan="2" class="{cycle values='first,second'}">
				<input type="submit" name="submit" class="button" value="{#DOC_CHANGE_BUTTON#}" />
			</td>
		</tr>
	</table>
</form>

{/if}