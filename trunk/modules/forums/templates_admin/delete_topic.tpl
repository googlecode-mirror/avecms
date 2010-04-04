<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<br />
<form name="f" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=delete_topics&cp={$sess}&del=1" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#DelTopics#}</td>
		</tr>
		{if $preview==1}
		<tr class="second">
		<td colspan="2">
		<div class="infobox" style="height:200px; overflow:auto">
<table border="0" cellpadding="5" cellspacing="1" class="tableborder" width="100%">
		{foreach from=$Topics item=t}
<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
	<td width="1%"><input name="del_id[{$t->id}]" type="checkbox" value="1" checked /></td>
	<td><a href="javascript:;" onclick="window.open('../index.php?module=forums&show=showtopic&toid={$t->id}&fid={$t->forum_id}','pv','left=0,top=0,width=950,height=650,scrollbars=yes')">{$t->title|stripslashes}</a></td>
</tr>
		{/foreach}
		</table>
		</div>		</td>
		</tr>
		{/if}
		<tr>
			<td width="20%" class="first">{#DelT_olderThan#}</td>
			<td class="second">
				<select name="date">
					<option value="0"></option>
					<option value="1" {if $smarty.post.date == 1}selected{/if}>{#forum_one_day#}</option>
					<option value="7" {if $smarty.post.date == 7}selected{/if}>{#forum_one_week#}</option>
					<option value="14" {if $smarty.post.date == 14}selected{/if}>{#forum_two_weeks#}</option>
					<option value="30" {if $smarty.post.date == 30}selected{/if}>{#forum_one_month#}</option>
					<option value="90" {if $smarty.post.date == 90}selected{/if}>{#forum_three_months#}</option>
					<option value="180" {if $smarty.post.date == 180}selected{/if}>{#forum_six_months#}</option>
					<option value="365" {if $smarty.post.date == 365}selected{/if}>{#forum_one_year#}</option>
					<option value="730" {if $smarty.post.date == 730}selected{/if}>{#forum_two_years#}</option>
				</select>			</td>
		</tr>
		<tr>
			<td width="20%" class="first">{#DelT_repliesLess#}</td>
			<td class="second"><input type="text" name="reply_count" size="5" maxlength="6" value="{$smarty.request.reply_count}" /></td>
		</tr>
		<tr>
			<td width="20%" class="first">{#DelT_topicClosed#}</td>
			<td class="second">
				<input type="checkbox" name="topic_closed" value="1" {if $smarty.post.topic_closed=='1'}checked{/if} />
				</td>
		</tr>
		<tr>
			<td width="20%" class="first">{#Delt_hitsLess#}</td>
			<td class="second">
				<input type="text" name="hits_count" size="5" maxlength="6" value="{$smarty.request.hits_count}" />			</td>
		</tr>
		<tr>
		  <td class="first">{#Forums#}</td>
		  <td class="second">
		    <select name="forums[]" size="5" multiple="multiple" id="forums">

		     {foreach from=$forums item=f}
			 <option value="{$f->id}" {if $smarty.request.forums}{if in_array($f->id,$smarty.request.forums)}selected{/if}{/if}{if $smarty.request.del!=1}selected{/if}>{$f->title|stripslashes}</option>
			{/foreach}

		    </select>		  </td>
	  </tr>
		<tr>
			<td width="20%" class="first">{#TypAndOr#}</td>
			<td class="second">
			  <input name="andor" type="radio" value="and" {if ($smarty.request.del==1 && $smarty.request.andor=='and') || $smarty.request.del!=1}checked{/if} />
		    {#And#}
		    <input type="radio" name="andor" value="or" {if $smarty.request.andor=='or'}checked{/if} />
		    {#Or#}</td>
		</tr>
		<tr>

		  <td colspan="2" class="second">
		  <input type="hidden" name="preview" id="pv" value="" />
		  <input type="hidden" name="del_final" id="df" value="" />
		  <input class="button" type="submit" onclick="document.getElementById('pv').value='1';" value="{#Preview#}" />
		  {if $Topics}
		  <input onclick="if(confirm('{#ConfimDelTopics#}')) {ldelim} document.getElementById('df').value='1';document.getElementById('pv').value='1'; this.form.submit();{rdelim}" class="button" type="button" value="{#DelMarked#}" />
		  {/if}		  </td></tr>
  </table>
</form>
