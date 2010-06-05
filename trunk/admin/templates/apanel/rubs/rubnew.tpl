<div id="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_rubs">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#RUBRIK_NEW#}</h2></div>
	<div class="HeaderText">{#RUBRIK_NEW_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

{if $errors}
	<ul>{foreach from=$errors item=error}<li>{$error}</li>{/foreach}</ul>
{/if}

<form name="form1" method="post" action="index.php?do=rubs&amp;action=new&amp;sub=save&amp;cp={$sess}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="250" />
		<tr>
			<td class="first"><strong>{#RUBRIK_NAME2#}</strong></td>
			<td class="second"><input style="width:250px" type="text" name="RubrikName" value="{$smarty.request.RubrikName|escape|stripslashes}"></td>
		</tr>

		<tr>
			<td class="first"><strong>{#RUBRIK_URL_PREFIX2#}</strong></td>
			<td class="second"><input style="width:250px" type="text" name="UrlPrefix" value="{$smarty.request.UrlPrefix|escape|stripslashes}"></td>
		</tr>

		<tr>
			<td class="first"><strong>{#RUBRIK_TEMPLATE_OUT2#}</strong></td>
			<td class="second">
				<select style="width:250px" name="Vorlage">
					{foreach from=$AlleVorlagen item=av}
						<option value="{$av->Id}" {if $av->Id==$tpl->Vorlage}selected {/if}/>{$av->TplName}</option>
					{/foreach}
				</select>
			</td>
		</tr>
	</table><br />

	<input type="submit" class="button" value="{#RUBRIK_BUTTON_NEW#}">
</form>