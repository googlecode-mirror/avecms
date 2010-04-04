
<!-- result.tpl -->
{strip}

<h2 id="page-heading">{$poll->title}</h2>
<div class="tablebox">
<table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#CCCCCC">
	<col width="50%">
	<col width="5%">
	<col width="40%">
	<col width="5%">
        <thead>
        <tr>
          <th>{#POLL_QUESTION_LIST#}</th>
          <th  colspan="3">{#POLL_RESULT_INFO#}</th>
        </tr>
        </thead>
	{foreach from=$items item=item}
		<tr class="{cycle name="1" values=",odd"}">
      <td>{$item->title}</td>
      <td width="5%"><div align="center"> {$item->hits} </div></td>
      <td >
        <div style="width: 100% height:12px; padding:0px;">
          <div style="width: {if $item->sum!=""}{$item->sum}%{else}1%{/if}; height: 12px; background-color: {$item->color};"><img height="1" width="1" src="{$img_folder}/pixel.gif" alt="" /></div>
        </div>
      </td>
      <td  class="{cycle name="pollerg4" values="mod_poll_first,mod_poll_second"}" width="5%" nowrap="nowrap"><div align="center"> {$item->sum} %</div></td>
    </tr>
	{/foreach}
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
	<col width="170">
      <thead>
	<tr>
          <th colspan="2">{#POLL_INFOS#}</th>
	</tr>
</thead>
	<tr class="odd">
		<td>{#POLL_ALL_HITS#}</td>
		<td>{$poll->votes}</td>
	</tr>

	<tr >
		<td>{#POLL_PUB_STATUS#}</td>
		<td>{if $poll->ende > $smarty.now}{#POLL_ACTIVE_INFO#}{else}{#POLL_INACTIVE_INFO#}{/if}</td>
	</tr>

	<tr class="odd">
		<td>{#POLL_STARTED#}</td>
		<td>{$poll->start|date_format:#POLL_DATE_FORMAT1#}</td>
	</tr>

	<tr >
		<td>{#POLL_ENDED#}</td>
		<td>{$poll->ende|date_format:#POLL_DATE_FORMAT1#}</td>
	</tr>

	<tr class="odd">
		<td>{#POLL_GROUPS_PERM#}</td>
		<td>{$poll->groups}</td>
	</tr>
</table><br />

{if $poll->can_vote == '1'}
	<div style="padding:5px"><strong>{$poll->title}</strong></div>
	<form method="post" action="{$formaction}">
		{foreach from=$items item=item}
			<div style="margin-left:5px"><input type="radio" name="p_item" value="{$item->id}" /> {$item->title}</div>
		{/foreach}
		<div style="padding:5px"><input type="submit" class="button" value="{#POLL_BUTTON_VOTE#}" /></div><br />
	</form>
{/if}

{if $poll->can_comment == '1'}
<h6>{#POLL_PUB_COMMENTS#}</h6>
<a href="javascript:void(0);" onclick="popup('{$formaction_comment}','comment','600','500','1');">{#POLL_PUB_ADD_COMMENT#}</a> | {#POLL_ALL_COMMENTS#} {$count_comments}<br />
</div>
{foreach from=$comments item=item}
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="mod_comment_box">
		<tr>
			<td class="mod_comment_header">
				<div class="mod_comment_author">
					<a name="{$c.Id}"></a>{#POLL_ADDED#}  <a href="#">{$item->lastname} {$item->firstname}</a> {$item->ctime|date_format:$config_vars.POLL_DATE_FORMAT3}
				</div>
			</td>
		</tr>
		<tr>
			<td class="mod_comment_text">
<strong>{$item->title}</strong><br />{$item->comment}			
			</td>
		</tr>
	</table>
{/foreach}
{/if}
{/strip}
<!-- /result.tpl -->
