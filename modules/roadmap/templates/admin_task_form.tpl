<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
{if $smarty.request.moduleaction != 'new_task'}
    <div class="HeaderTitle"><h2>{#ROADMAP_TASK_EDIT_2#}</h2></div>
{else}
	<div class="HeaderTitle"><h2>{#ROADMAP_NEW_TASK_2#}</h2></div>
{/if}
    <div class="HeaderText">{#ROADMAP_TASK_INFO#}</div>
</div>
<br>

<form method="post" action="{$formaction}" enctype="multipart/form-data">

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
<tr>
  <td class="first">{#ROADMAP_TASK_STATUS#}:</td>
  <td class="second">
    <input name="task_status" type="radio" id="task_status" value="0" {if $item->task_status==0}checked{/if} />{#ROADMAP_ACTIVE_TASK#}
	<input name="task_status" type="radio" id="task_status" value="1" {if $item->task_status==1}checked{/if} />{#ROADMAP_INACTIVE_TASK#}
  </td>
</tr>
<tr>
<td width="300" class="first">{#ROADMAP_TASK_DESC#}:</td>
<td class="second">
  <textarea name="task_desc" cols="90" rows="8" >{$item->task_desc}</textarea>
</td>
</tr>
<tr>
  <td width="300" class="first">{#ROADMAP_PRIORITY#}:</td>
  <td class="second">
    <select name="priority">
      <option value="1" {if $item->priority == "1"}selected{/if}>{#ROADMAP_TASK_HIGHEST#}</option>
      <option value="2" {if $item->priority == "2"}selected{/if}>{#ROADMAP_TASK_HIGH#}</option>
      <option value="3" {if $item->priority == "3"}selected{/if}>{#ROADMAP_TASK_NORMAL#}</option>
      <option value="4" {if $item->priority == "4"}selected{/if}>{#ROADMAP_TASK_LOW#}</option>
      <option value="5" {if $item->priority == "5"}selected{/if}>{#ROADMAP_TASK_LOWEST#}</option>
    </select>
  </td>
</tr>
{if $smarty.request.moduleaction != 'new_task'}
<tr>
  <td width="300" class="first">{#ROADMAP_TASK_USER#}</td>
  <td class="second">
    <input style="width:200px" type="text" readonly="" value="{$item->lastname} {$item->firstname}" />
	<input style="width:95px" name="uid" type="text"  value="{$item->uid}" />
  </td>
</tr>
<tr>
  <td width="300" class="first">{#ROADMAP_LAST_CHANGE#}:</td>
  <td class="second">{$item->date_create|date_format:$TIME_FORMAT|pretty_date:$DEF_LANGUAGE}</td>
</tr>
{/if}
</table>
<br />
{if $smarty.request.moduleaction == 'new_task'}
  <input name="submit" type="submit" class="button" value="{#ROADMAP_BUTTON_ADD_T#}" />
{else}
  <input name="submit" type="submit" class="button" value="{#ROADMAP_BUTTON_SAVE#}" />
{/if}
</form>