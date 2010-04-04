<script type="text/javascript" language="JavaScript">
 function check_name() {ldelim}
   if (document.getElementById('project_name').value == '') {ldelim}
     alert("{#ROADMAP_ENTER_NAME#}");
     document.getElementById('project_name').focus();
     return false;
   {rdelim}
   return true;
 {rdelim}
</script>
<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
{if $smarty.request.moduleaction != 'new_project'}
    <div class="HeaderTitle"><h2>{#ROADMAP_EDIT_PROJECT#}</h2></div>
    <div class="HeaderText">{#ROADMAP_INFO_1#}</div>
{else}
    <div class="HeaderTitle"><h2>{#ROADMAP_ADD_PROJECT#}</h2></div>
    <div class="HeaderText">{#ROADMAP_INFO_2#}</div>
{/if}
</div>
<br>
<form method="post" action="{$formaction}" enctype="multipart/form-data" onsubmit="return check_name();">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  {if $smarty.request.moduleaction != 'new_project'}
  <tr>
    <td class="first">{#ROADMAP_PROJECT_STATUS#}:</td>
    <td class="second">
	  <input name="project_status" type="radio" id="project_status" value="1" {if $item->project_status==1}checked{/if} />{#ROADMAP_ACTIVE#}
	  <input name="project_status" type="radio" id="project_status" value="0" {if $item->project_status==0}checked{/if} />{#ROADMAP_INACTIVE#}
	</td>
  </tr>
  {else}
    <input name="project_status" value="1" type="hidden">
  {/if}

  <tr>
    <td width="300" class="first">{#ROADMAP_PROJECT_NAME#}:</td>
    <td class="second"><input style="width:300px" name="project_name" id="project_name" type="text"  value="{$item->project_name}" /></td>
  </tr>

  <tr>
    <td width="300" class="first">{#ROADMAP_PROJECT_DESC#}:</td>
    <td class="second"><textarea name="project_desc" cols="90" rows="8" >{$item->project_desc}</textarea></td>
   </tr>

   <tr>
     <td width="300" class="first">{#ROADMAP_POSITION#}:</td>
     <td class="second"><input style="width:95px" name="position" type="text"  value="{$item->position}" /></td>
   </tr>
</table>
<br />
  {if $smarty.request.moduleaction == 'new_project'} 
    <input name="submit" type="submit" class="button" value="{#ROADMAP_BUTTON_ADD#}" />
  {else}
    <input name="submit" type="submit" class="button" value="{#ROADMAP_BUTTON_SAVE#}" />
  {/if}
</form>