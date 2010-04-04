<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#EditComments#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br />
<form name="kform" method="post" action="index.php?do=modules&action=modedit&mod=download&moduleaction=editcomments&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">

  <tr>
    <td width="1%" align="center" class="tableheader"><input title="{#DlmarkDel#}"  name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
    <td width="200" class="tableheader">{#CCommentInf#}</td>
    <td class="tableheader">{#CComment#}</td>
  </tr>
  {foreach from=$comments item=c}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
    <td align="center"><input title="{#DlmarkDel#}"  name="Del[{$c->Id}]" type="checkbox" value="1"></td>
    <td width="200" valign="top">

	<input style="width:200px; background: rgb(255, 255, 204)" name="Titel[{$c->Id}]" type="text" value="{$c->Titel|escape:html|stripslashes}"> <br />
	{#CCommentFrom#}<br />
	<input style="width:200px" name="Name[{$c->Id}]" type="text" value="{$c->Name|escape:html|stripslashes}"><br />
	{#CCommentEmail#} <br />
	<input style="width:200px" name="Email[{$c->Id}]" type="text" value="{$c->Email|escape:html|stripslashes}">
	</td>
    <td>

	<textarea name="Kommentar[{$c->Id}]" style="width:97%; background: rgb(255, 255, 204)" rows="6">{$c->Kommentar|escape:html|stripslashes}</textarea></td>
  </tr>
  {/foreach}
</table>
<br />
<input type="hidden" name="page" value="{$smarty.request.page|default:1}">
<input class="button" type="submit" value="{#ButtonSave#}">
</form>
<p>
{$page_nav}
</p>