{if $smarty.request.moduleaction=='addcategory'}
{assign var="action" value="index.php?do=modules&action=modedit&mod=forums&moduleaction=addcategory&cp=$sess&pop=1&save=1"}
{else}
{assign var="action" value="index.php?do=modules&action=modedit&mod=forums&moduleaction=edit_category&cp=$sess&pop=1&save=1"}
{/if}

<form action="{$action}" method="post">
	<input type="hidden" name="c_id" value="{$category->id}" />
	<input type="hidden" name="f_id" value="{$category->parent_id|default:$smarty.get.id}" />
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableborder">
	
	  <tr>
	    <td colspan="2" class="tableheader">
		{if $smarty.request.moduleaction=="addcategory"}{#CatNew#}
		{else}
		{#EditCateg#}{/if}		</td>
    </tr>
	{if count($errors)}
    <tr>
		<td colspan="2">
			{foreach from=$errors item=error}
				<li>{$error}</li>
			{/foreach}
		</td>
	</tr>
	{/if}
	<tr>
		<td width="10%" class="first">{#Title#}</td>
		<td class="second">
			<input type="text" name="title" value="{$smarty.post.title|default:$category->title|escape:"htmlall":'cp1251'|stripslashes}" size="50" maxlength="200" />
	  </td>
	</tr>
	<tr>
		<td width="10%" class="first">{#Posi#}</td>
		<td class="second">
			<input type="text" name="position" value="{if $smarty.request.moduleaction=="addcategory"}1{else}{$smarty.post.position|default:$category->position}{/if}" size="4" maxlength="3" />
	  </td>
	</tr>
	<tr>
		<td width="10%" class="first">{#GroupPerm#}
		<br />
		<small>
		{#GroupPermInf#}
		</small>
		 </td>
		<td class="second">
			<select name="group_id[]" multiple="multiple">
				{foreach from=$groups item=group}
				<option value="{$group->ugroup}" {if @in_array($group->ugroup, $category->group_id) || @in_array($group->ugroup, $smarty.post.group_id) || $smarty.request.moduleaction=="addcategory"}selected="selected"{/if}>{$group->groupname}</option>
				{/foreach}
			</select>
	  </td>
	</tr>
	<tr>
		<td class="first">{#Descr#}</td>
		<td class="second">
			<textarea name="comment" cols="50" rows="5">{$smarty.post.comment|default:$category->comment|escape:"htmlall":'cp1251'|stripslashes}</textarea>
	  </td>
	</tr>

	<tr>
		<td colspan="2" class="thirdrow">
			<input class="button" type="submit" value="{#Save#}" />
	  </td>
	</tr>
</table>
</form>
