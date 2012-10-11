<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
    <div class="HeaderText"><strong>{#ImportWelcome#}</strong><br>{#ImportWelcomeInfo#}</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<br />
<form method="post" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=import&cp={$sess}&what=user">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr>
    <td colspan="2" class="tableheader">{#ImportUser#} ({#ImportUser2# $usercount}) </td>
    </tr>
  <tr>
    <td colspan="2" class="first">{#ImportUserInfo#} </td>
    </tr>
  <tr>
    <td width="200" class="first">{#ImportPrefix#} </td>
    <td class="second"><input name="prefix" type="text" id="prefix" value="kpro"></td>
    </tr>
  <tr>
    <td width="200" class="first">{#ImportAndClear#} </td>
    <td class="second"><input name="truncate" type="checkbox" id="truncate" value="1" checked="checked"></td>
  </tr>
  <tr>
    <td width="200" class="first">&nbsp;</td>
    <td class="second"><input type="submit" class="button" value="{#ImportStart#}"></td>
  </tr>
</table>
</form>

<br />

<form method="post" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=import&cp={$sess}&what=forums">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr>
    <td colspan="2" class="tableheader">{#ImportForums#}</td>
    </tr>
  <tr>
    <td colspan="2" class="first">{#ImportForumsInfo#} </td>
    </tr>
  <tr>
    <td width="200" class="first">{#ImportForumPrefix#} </td>
    <td class="second"><input name="prefix" type="text" id="prefix" value="kpro"></td>
    </tr>
  
  <tr>
    <td width="200" class="first">{#ImportAndClearForum#} </td>
    <td class="second"><input name="truncate" type="checkbox" id="truncate" value="1" checked="checked"></td>
  </tr>
  <tr>
    <td width="200" class="first">&nbsp;</td>
    <td class="second"><input type="submit" class="button" value="{#ImportForumStart#}"></td>
  </tr>
</table>
</form>