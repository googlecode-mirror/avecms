<div class="pageHeaderTitle">
	<div class="h_docs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#DOC_AFTER_CREATE_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#DOC_AFTER_CREATE_INFO#}</div>
</div>

<ul id="doclinks" style="padding-left:70px">
	<li class="edit"><a href="index.php?do=docs&action=edit&Id={$Id}&rubric_id={$rubric_id}&cp={$sess}">{#DOC_EDIT_THIS_DOCUMENT#}</a></li>

	<li class="show"><a href="../index.php?id={$Id}" target="_blank">{#DOC_DISPLAY_NEW_WINDOW#}</a></li><br />

	{if $innavi==1}
		<li class="navig"><a href="javascript:void(0);" onclick="document.getElementById('Nav').style.display='block'">{#DOC_INCLUDE_NAVIGATION#}</a></li><br />
	{/if}

	<li class="add"><a href="index.php?do=docs&action=new&rubric_id={$rubric_id}&cp={$sess}">{#DOC_ADD_NEW_DOCUMENT#}</a></li><br />

	<li class="back"><a href="index.php?do=docs&rubric_id={$rubric_id}&cp={$sess}">{#DOC_CLOSE_WINDOW_RUBRIC#}</a></li>

	<li class="back"><a href="index.php?do=docs&cp={$sess}">{#DOC_CLOSE_WINDOW#}</a></li>
</ul>

{if $innavi==1}
	<div id="Nav" style="display:none">
		<br /><br /><br />
		<form method="post" action="index.php?do=docs&action=new&sub=savenavi&Id={$Id}&rubric_id={$rubric_id}&cp={$sess}">
			<table width="100%" border="0" cellpadding="4" cellspacing="1" class="tableborder">
				<tr>
					<td colspan="2" class="tableheader"><a name="nav"></a>{#DOC_TO_NAVI_TITLE#}</td>
				</tr>

				<tr>
					<td width="200" class="first">{#DOC_ADD_IN_NAVIGATION#} </td>
					<td class="second">
						{include file='navigation/tree_docform.tpl'} {#DOC_IN_MENU#}&nbsp;
						<select name="NaviRubric" id="NaviRubric">
							{foreach from=$rubs item=rubric}
								<option value="{$r->id}">{$rubric->rubric_title|escape}</option>
							{/foreach}
						</select>
					</td>
				</tr>

				<tr>
					<td class="first">{#DOC_NAVIGATION_POSITION#} </td>
					<td class="second"><input style="width:45px" name="navi_item_position" type="text" id="navi_item_position" value="1" maxlength="4"></td>
				</tr>

				<tr>
					<td class="first">{#DOC_NAVIGATION_TITLE#} </td>
					<td class="second"><input style="width:400px" name="document_title" type="text" id="document_title" value="{$smarty.request.document_title|escape}"></td>
				</tr>

				<tr>
					<td class="first">{#DOC_TARGET#}</td>
					<td class="second">
						<select  style="width:150px" name="navi_item_target" id="navi_item_target">
							<option value="_self">{#DOC_TARGET_SELF#}</option>
							<option value="_blank">{#DOC_TARGET_BLANK#}</option>
						</select>
					</td>
				</tr>

				<tr>
					<td class="first">
						<input name="action" type="hidden" id="action" value="updateNavi">
						<input name="Id" type="hidden" id="Id" value="{$Id}">
						<input name="document_alias" type="hidden" id="document_alias" value="{$smarty.request.document_alias|escape}">
						<input name="rubric_id" type="hidden" id="rubric_id" value="{$rubric_id}">
					</td>
					<td class="second"><input type="submit" class="button" value="{#DOC_BUTTON_ADD_MENU#}"></td>
				</tr>
			</table>
		</form>
	</div>
{/if}