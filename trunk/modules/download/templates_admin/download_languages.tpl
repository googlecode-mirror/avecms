<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#Languages#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br />
<form  name="kform" method="post" action="index.php?do=modules&action=modedit&mod=download&moduleaction=languages&cp={$sess}&pop=1&sub=save">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr class="tableheader">
  <td><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
    <td>{#LanguagesName#}</td>
  </tr>
  {foreach from=$lang item=l}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
    <td width="1%" align="center"><input title="{#DlmarkDel#}" type="checkbox" name="Del[{$l->Id}]" value="1">   </td>
    <td><input name="Name[{$l->Id}]" type="text" value="{$l->Name|stripslashes}" size="50"></td>
  </tr>
  {/foreach}
  <tr>
  <td colspan="2" class="second"><input class="button" type="submit" value="{#ButtonSave#}"></td>
  </tr>
</table>
</form>
<br />
<form method="post" action="index.php?do=modules&action=modedit&mod=download&moduleaction=languages&cp={$sess}&pop=1&sub=new">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr>
  <td class="tableheader">{#LanguagesNew#}</td>
  </tr>
  {*section name=langnew loop=3*}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
    <td><input name="Name[]" type="text" size="50"></td>
  </tr>
  {*/section*}
  <tr>
  <td colspan="2" class="second"><input class="button" type="submit" value="{#ButtonSave#}"></td>
  </tr>
</table>
<br />
</form>
<p align="center">
<input class="button" type="button" onclick="window.close();" value="{#WinClose#}" />
</p>