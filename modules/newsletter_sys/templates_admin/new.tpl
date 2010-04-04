<script language="javascript">
function check_nl()
{ldelim}
	if(document.getElementById('ugs').value=='')
	{ldelim}
		alert('{#SNL_SELECT_GROUPS#}');
		document.getElementById('ugs').focus();
		return false;
	{rdelim}
	
	if(document.getElementById('from').value=='')
	{ldelim}
		alert('{#SNL_NO_SENDER#}');
		document.getElementById('from').focus();
		return false;
	{rdelim}
	
	if(document.getElementById('frommail').value=='')
	{ldelim}
		alert('{#SNL_NO_SENDER_EMAIL#}');
		document.getElementById('frommail').focus();
		return false;
	{rdelim}

	if(document.getElementById('title').value=='')
	{ldelim}
		alert('{#SNL_ENTER_TITLE#}');
		document.getElementById('title').focus();
		return false;
	{rdelim}
	
	if(document.getElementById('radio_text').checked == true && document.getElementById('text_norm').value=='')
	{ldelim}
		alert('{#SNL_ENTER_TEXTt#}');
		document.getElementById('text_norm').focus();
		return false;
	{rdelim}
	
	if(confirm('{#SNL_CONFIRM_SEND#}'))
	{ldelim}
		document.getElementById('butt_send').disabled=true;
		return true;
	{rdelim}
	else
	{ldelim}
		return false;
	{rdelim}
{rdelim}
</script>
<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#SNL_NEW_TITLE#}</h2></div>
    <div class="HeaderText">{#SNL_NEW_INFO#}</div>
</div><br>

<form onsubmit="return check_nl();" action="index.php?do=modules&action=modedit&mod=newsletter_sys&moduleaction=new&cp={$sess}&sub=send&pop=1" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr>
    <td width="200" valign="top" class="first">{#SNL_NEW_GROUPS#}<br /><small>{#SNL_NEW_GROUPS_INFO#}</small></td>
    <td class="second">
	<select id="ugs" name="usergroups[]" size="5" multiple="multiple" style="width:200px" >
	  {foreach from=$usergroups item=ug}
        <option value="{$ug->Benutzergruppe}" selected="selected">{$ug->Name|stripslashes}</option>
	  {/foreach}
    </select>
    </td>
  </tr>
  <tr>
    <td class="first">{#SNL_NEW_SENDER#}</td>
    <td class="second"><input name="from" type="text" id="from" value="{$from}" style="width:200px" /></td>
  </tr>
  <tr>
    <td class="first">{#SNL_NEW_EMAIL#}</td>
    <td class="second"><input name="frommail" type="text" id="frommail" value="{$frommail}" style="width:200px" /></td>
  </tr>
  <tr>
    <td class="first">{#SNL_NEW_TITLE#}</td>
    <td class="second"><input name="title" type="text" id="title" style="width:200px" /></td>
  </tr>
  <tr>
    <td class="first">{#SNL_NEW_FORMAT#}</td>
    <td class="second">
	<label>
       <input id="radio_text" type="radio" name="type" value="text" checked="checked" onclick="document.getElementById('ed2').style.height='0px'; document.getElementById('ed1').style.display=''" />{#SNL_NEW_TEXT#}
    </label>
	<label>
      <input type="radio" name="type" value="html" onclick="document.getElementById('ed2').style.height='300px'; document.getElementById('ed1').style.display='none'" />{#SNL_NEW_HTML#}
    </label>
    </td>
  </tr>
  <tr>
    <td colspan="2" class="first">
	<div id="ed1" style="">
      <textarea name="text_norm" cols="50" rows="15" id="text_norm" style="width:98%; height:300px">{#SNL_NEW_TEMPLATE#}</textarea>
	</div>    
	<div id="ed2" style="height:0px;overflow:hidden">{$Editor}</div>
    </td>
    </tr>
  {section name=attach loop=3}
  <tr>
    <td class="first">{#SNL_NEW_ATTACH#} {$smarty.section.attach.index+1} </td>
    <td class="second"><input name="upfile[]" type="file" id="upfile[]" size="40" /></td>
  </tr>
  {/section}
  <tr>
    <td class="first">{#SNL_DEL_ATTACH#}</td>
    <td class="second">
        <input type="radio" name="delattach" value="1" />{#SNL_NEW_YES#}
        <input name="delattach" type="radio" value="2" checked="checked" />{#SNL_NEW_NO#} <strong>{#SNL_DEL_ATTACH_INFO#}</strong>
    </td>
  </tr>
  <tr>
    <td class="first">{#SNL_NEW_COUNT#}</td>
    <td class="second">
	<select name="steps" id="steps">
      {section name=st loop=100 start=0 step=5}
	  <option value="{$smarty.section.st.index+5}" {if $smarty.section.st.index+5=='25'}selected="selected" {/if}>{$smarty.section.st.index+5}{#SNL_NEW_COUNT_M#}{if $smarty.section.st.index+5=='25'}{/if}</option>
	  {/section}
    </select>    </td>
  </tr>
</table>
<br />
<input id="butt_send" class="button" type="submit" value="{#SNL_BUTTON_SEND#}" />
</form>
