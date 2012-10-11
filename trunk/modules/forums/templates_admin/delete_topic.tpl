<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/forum_topnav.tpl"}<br />

<form name="f" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=delete_topics&cp={$sess}&del=1" method="post">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#FORUMS_HEADER_VIEW_DEL_TOPICS#}</td>
		</tr>
		{if $preview==1}
		<tr class="second">
			<td colspan="2">
				<div class="infobox" style="height:200px; overflow:auto">
					<table border="0" cellpadding="5" cellspacing="1" class="tableborder" width="100%">
				{foreach from=$Topics item=t}
						<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
							<td width="1%">
								<input name="del_id[{$t->id}]" type="checkbox" value="1" checked />
							</td>
							<td>
								<a href="javascript:;" onclick="window.open('../index.php?module=forums&show=showtopic&toid={$t->id}&fid={$t->forum_id}','pv','left=0,top=0,width=950,height=650,scrollbars=yes')">{$t->title|stripslashes}</a>
							</td>
						</tr>
				{/foreach}
					</table>
				</div>
			</td>
		</tr>
		{/if}
		<tr>
			<td width="20%" class="first">{#FORUMS_DEL_TOPIC_OLDER_THAN#}</td>
			<td class="second">
				<select name="date">
					<option value="0"></option>
					<option value="1" {if $smarty.post.date == 1}selected{/if}>{#FORUMS_FORUM_ONE_DAY#}</option>
					<option value="7" {if $smarty.post.date == 7}selected{/if}>{#FORUMS_FORUM_ONE_WEEK#}</option>
					<option value="14" {if $smarty.post.date == 14}selected{/if}>{#FORUMS_FORUM_TWO_WEEKS#}</option>
					<option value="30" {if $smarty.post.date == 30}selected{/if}>{#FORUMS_FORUM_ONE_MONTH#}</option>
					<option value="90" {if $smarty.post.date == 90}selected{/if}>{#FORUMS_FORUM_THREE_MONTHS#}</option>
					<option value="180" {if $smarty.post.date == 180}selected{/if}>{#FORUMS_FORUM_SIX_MONTHS#}</option>
					<option value="365" {if $smarty.post.date == 365}selected{/if}>{#FORUMS_FORUM_ONE_YEAR#}</option>
					<option value="730" {if $smarty.post.date == 730}selected{/if}>{#FORUMS_FORUM_TWO_YEARS#}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="20%" class="first">{#FORUMS_DEL_TOPIC_REPLIES_LESS#}</td>
			<td class="second">
				<input type="text" name="reply_count" size="5" maxlength="6" value="{$smarty.request.reply_count}" />
			</td>
		</tr>
		<tr>
			<td width="20%" class="first">{#FORUMS_DEL_TOPIC_CLOSED#}</td>
			<td class="second">
				<input type="checkbox" name="topic_closed" value="1" {if $smarty.post.topic_closed=='1'}checked{/if} />
			</td>
		</tr>
		<tr>
			<td width="20%" class="first">{#FORUMS_DEL_TOPIC_HITS_LESS#}</td>
			<td class="second">
				<input type="text" name="hits_count" size="5" maxlength="6" value="{$smarty.request.hits_count}" />
			</td>
		</tr>
		<tr>
			<td class="first">{#FORUMS_FORUM#}</td>
			<td class="second">
				<select name="forums[]" size="5" multiple="multiple" id="forums">
				{foreach from=$forums item=f}
					<option value="{$f->id}" {if $smarty.request.forums}{if in_array($f->id,$smarty.request.forums)}selected{/if}{/if}{if $smarty.request.del!=1}selected{/if}>{$f->title|stripslashes}</option>
				{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td width="20%" class="first">{#FORUMS_TYP_AND_OR#}</td>
			<td class="second">
				<input name="andor" type="radio" value="and" {if ($smarty.request.del==1 && $smarty.request.andor=='and') || $smarty.request.del!=1}checked{/if} />{#FORUMS_AND#}
				<input type="radio" name="andor" value="or" {if $smarty.request.andor=='or'}checked{/if} />{#FORUMS_OR#}
			</td>
		</tr>
		<tr>
			<td colspan="2" class="second">
				<input type="hidden" name="preview" id="pv" value="" />
				<input type="hidden" name="del_final" id="df" value="" />
				<input class="button" type="submit" onclick="document.getElementById('pv').value='1';" value="{#FORUMS_BUTTON_PREVIEW#}" />
			{if $Topics}
				<input onclick="if(confirm('{#FORUMS_CONFIRM_DEL_TOPICS#}')) {ldelim} document.getElementById('df').value='1';document.getElementById('pv').value='1'; this.form.submit();{rdelim}" class="button" type="button" value="{#FORUMS_DEL_MARKED#}" />
			{/if}		  
			</td>
		</tr>
  </table>
</form>