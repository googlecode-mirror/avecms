<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<h4>{#Ranks#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=user_ranks&cp={$sess}&save=1" method="post">
<table width="100%"  border="0" cellspacing="1" cellpadding="8" class="tableborder">
<tr class="tableheader">
	  <td width="20%">{#Title#}</td>
	  <td width="5%">{#Postings#}</td>
	  <td>&nbsp;</td>
    </tr>
{foreach from=$ranks item=rank}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
	  <td width="20%">
			<input type="text" name="title[{$rank->id}]" value="{$rank->title|escape:'html'|stripslashes}" size="50" maxlength="100" />
	  </td>
		<td width="5%">
			<input type="text" name="count[{$rank->id}]" value="{$rank->count}" size="6" maxlength="7" />
	  </td>
		<td align="right"><a href="index.php?do=modules&action=modedit&mod=forums&moduleaction=user_ranks&cp={$sess}&del_rank=1&id={$rank->id}"><img src="{$tpl_dir}/images/icon_18.gif" alt="" border="0" /></a></td>
	</tr>
{/foreach}
	<tr>
		<td class="second" colspan="3">
			<input type="submit" class="button" value="{#Save#}">
	  </td></tr>
</table>
</form>
<h4>{#NewRank#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=user_ranks&cp={$sess}&add_rank=1" method="post">
<table width="100%"  border="0" cellspacing="1" cellpadding="8" class="tableborder">
	<tr class="tableheader">
	  <td>{#Title#}</td>
	  <td>{#Postings#}</td>
	  <td>&nbsp;</td>
    </tr>
	<tr>
		<td width="20%" class="first">
			<input type="text" name="title" value="{$smarty.post.title}" size="50" maxlength="100" />
		</td>
		<td class="first" width="1%">
			<input type="text" name="count" value="{$smarty.post.count}" size="6" maxlength="7" />
		</td>
<td class="second" align="left">
<input type="submit" class="button" value="{#Add#}">
		</td>
	</tr>
</table>
</form>
