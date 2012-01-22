<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_query">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#REQUEST_CONDITIONS#}<span style="color: #000;">&nbsp;&gt;&nbsp;{$request_title|escape|stripslashes}</span></h2></div>
	<div class="HeaderText">{#REQUEST_CONDITION_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form action="index.php?do=request&action=konditionen&sub=save&rubric_id={$smarty.request.rubric_id|escape}&Id={$smarty.request.Id|escape}&pop=1&cp={$sess}" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		{if $afkonditionen}
			<tr class="tableheader">
				<td width="1"><img src="{$tpl_dir}/images/icon_delete.gif" alt="" border="0" /></td>
				<td>{#REQUEST_FROM_FILED#}</td>
				<td>{#REQUEST_OPERATOR#}</td>
				<td>{#REQUEST_VALUE#}</td>
			</tr>
		{/if}

		{foreach name=cond from=$afkonditionen item=condition}
			<tr class="{cycle name='k' values='first,second'}">
				<td width="1"><input title="{#REQUEST_MARK_DELETE#}" name="del[{$condition->Id}]" type="checkbox" id="del_{$condition->Id}" value="1"></td>

				<td width="200">
					<select name="condition_field_id[{$condition->Id}]" id="Feld_{$condition->Id}" style="width:200px">
						{foreach from=$fields item=field}
							<option value="{$field->Id}" {if $condition->condition_field_id==$field->Id}selected{/if}>{$field->rubric_field_title|escape}</option>
						{/foreach}
					</select>
				</td>

				<td width="150">
					<select style="width:150px" name="condition_compare[{$condition->Id}]" id="Operator_{$condition->Id}">
						<option value="==" {if $condition->condition_compare=='=='}selected="selected"{/if}>{#REQUEST_COND_SELF#}</option>
						<option value="!=" {if $condition->condition_compare=='!='}selected="selected"{/if}>{#REQUEST_COND_NOSELF#}</option>
						<option value="%%" {if $condition->condition_compare=='%%'}selected="selected"{/if}>{#REQUEST_COND_USE#}</option>
						<option value="--" {if $condition->condition_compare=='--'}selected="selected"{/if}>{#REQUEST_COND_NOTUSE#}</option>
						<option value="%" {if $condition->condition_compare=='%'}selected="selected"{/if}>{#REQUEST_COND_START#}</option>
						<option value="<=" {if $condition->condition_compare=='<='}selected="selected"{/if}>{#REQUEST_SMALL1#}</option>
						<option value=">=" {if $condition->condition_compare=='>='}selected="selected"{/if}>{#REQUEST_BIG1#}</option>
						<option value="<" {if $condition->condition_compare=='<'}selected="selected"{/if}>{#REQUEST_SMALL2#}</option>
						<option value=">" {if $condition->condition_compare=='>'}selected="selected"{/if}>{#REQUEST_BIG2#}</option>

						<option value="N==" {if $condition->condition_compare=='N=='}selected="selected"{/if}>{#REQUEST_N_COND_SELF#}</option>
						<option value="N<=" {if $condition->condition_compare=='N<='}selected="selected"{/if}>{#REQUEST_N_SMALL1#}</option>
						<option value="N>=" {if $condition->condition_compare=='N>='}selected="selected"{/if}>{#REQUEST_N_BIG1#}</option>
						<option value="N<" {if $condition->condition_compare=='N<'}selected="selected"{/if}>{#REQUEST_N_SMALL2#}</option>
						<option value="N>" {if $condition->condition_compare=='N>'}selected="selected"{/if}>{#REQUEST_N_BIG2#}</option>
						<option value="IN=" {if $condition->condition_compare=='IN='}selected="selected"{/if}>{#REQUEST_IN_NUM#}</option>
					<option value="ANY" {if $condition->condition_compare=='ANY'}selected="selected"{/if}>{#REQUEST_ANY_NUM#}</option>
					</select>
				</td>

				<td><input style="width:200px" name="condition_value[{$condition->Id}]" type="text" id="Wert_{$condition->Id}" value="{$condition->condition_value|escape}" /> {if !$smarty.foreach.cond.last}{if $condition->condition_join=='AND'}{#REQUEST_CONR_AND#}{else}{#REQUEST_CONR_OR#}{/if}{/if}</td>
			</tr>
		{/foreach}
	</table>

	<h4>{#REQUEST_NEW_CONDITION#}</h4>

	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td colspan="2">{#REQUEST_FROM_FILED#}</td>
			<td>{#REQUEST_OPERATOR#}</td>
			<td>{#REQUEST_VALUE#}</td>
		</tr>

		<tr>
			<td width="1" class="first">&nbsp;</td>
			<td width="200" class="first">
				<select name="Feld_Neu" id="Feld_Neu" style="width:200px">
					{foreach from=$fields item=field}
						<option value="{$field->Id}">{$field->rubric_field_title|escape}</option>
					{/foreach}
				</select>
			</td>

			<td width="150" class="first">
				<select style="width:150px" name="Operator_Neu" id="Operator_Neu">
					<option value="==" {if $condition->condition_compare=='=='}selected="selected"{/if}>{#REQUEST_COND_SELF#}</option>
					<option value="!=" {if $condition->condition_compare=='!='}selected="selected"{/if}>{#REQUEST_COND_NOSELF#}</option>
					<option value="%%" {if $condition->condition_compare=='%%'}selected="selected"{/if}>{#REQUEST_COND_USE#}</option>
					<option value="--" {if $condition->condition_compare=='--'}selected="selected"{/if}>{#REQUEST_COND_NOTUSE#}</option>
					<option value="%" {if $condition->condition_compare=='%'}selected="selected"{/if}>{#REQUEST_COND_START#}</option>
					<option value="<=" {if $condition->condition_compare=='<='}selected="selected"{/if}>{#REQUEST_SMALL1#}</option>
					<option value=">=" {if $condition->condition_compare=='>='}selected="selected"{/if}>{#REQUEST_BIG1#}</option>
					<option value="<" {if $condition->condition_compare=='<'}selected="selected"{/if}>{#REQUEST_SMALL2#}</option>
					<option value=">" {if $condition->condition_compare=='>'}selected="selected"{/if}>{#REQUEST_BIG2#}</option>

					<option value="N==" {if $condition->condition_compare=='N=='}selected="selected"{/if}>{#REQUEST_N_COND_SELF#}</option>
					<option value="N<=" {if $condition->condition_compare=='N<='}selected="selected"{/if}>{#REQUEST_N_SMALL1#}</option>
					<option value="N>=" {if $condition->condition_compare=='N>='}selected="selected"{/if}>{#REQUEST_N_BIG1#}</option>
					<option value="N<" {if $condition->condition_compare=='N<'}selected="selected"{/if}>{#REQUEST_N_SMALL2#}</option>
					<option value="N>" {if $condition->condition_compare=='N>'}selected="selected"{/if}>{#REQUEST_N_BIG2#}</option>
					<option value="IN=" {if $condition->condition_compare=='IN='}selected="selected"{/if}>{#REQUEST_IN_NUM#}</option>
					<option value="ANY" {if $condition->condition_compare=='ANY'}selected="selected"{/if}>{#REQUEST_ANY_NUM#}</option>
				</select>
			</td>

			<td class="first">
				<input style="width:200px" name="Wert_Neu" type="text" id="Wert_Neu" value="" />
				<select style="width:60px" name="Oper_Neu" id="Oper_Neu">
					<option value="OR" {if $condition->condition_join=='OR'}selected{/if}>{#REQUEST_CONR_OR#}</option>
					<option value="AND" {if $condition->condition_join=='AND'}selected{/if}>{#REQUEST_CONR_AND#}</option>
				</select>
			</td>
		</tr>

		<tr>
			<td colspan="4" class="third">
				<input type="submit" value="{#BUTTON_SAVE#}" class="button" />
				<input onclick="self.close();" type="button" class="button" value="{#REQUEST_BUTTON_CLOSE#}" />
			</td>
		</tr>
	</table><br />
</form>