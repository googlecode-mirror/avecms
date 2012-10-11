<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
{include file="$source/forum_topnav.tpl"}

{literal}
<script language="javascript">
var ie  = document.all  ? 1 : 0;
 function selall(kselect) {
   	var fmobj = document.kform;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
   			e.checked = fmobj.allbox.checked;   			
   		}
   	}
   }
   function CheckCheckAll(kselect) {
   	var fmobj = document.kform;
   	var TotalBoxes = 0;
   	var TotalOn = 0;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if ((e.name != 'allbox') && (e.type=='checkbox')) {
   			TotalBoxes++;
   			if (e.checked) {
   				TotalOn++;
   			}
   		}
   	}
   	if (TotalBoxes==TotalOn) {fmobj.allbox.checked=true;}
   	else {fmobj.allbox.checked=false;}
   }
   function select_read() {
   	var fmobj = document.kform;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if ((e.type=='hidden') && (e.value == 1) && (! isNaN(e.name) ))
   		{
   			eval("fmobj.msgid_" + e.name + ".checked=true;");   			
   		}
   	}
   }
   function desel() {
   	var fmobj = document.uactions;
   	for (var i=0;i<fmobj.elements.length;i++) {
   		var e = fmobj.elements[i];
   		if (e.type=='checkbox') {
   			e.checked=false;   			
   		}
   	}
   }
   </script>
 {/literal}
 <h4>{#FORUMS_SEARCH_FILES#}</h4>
<form name="attsearch" id="attseacrh" method="post" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=show_attachments&cp={$sess}">
  <table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
      <td class="first">
	  <input name="q" type="text" id="q" size="30" value="{$smarty.request.q|escape:'html'}" />
        <select name="ext" id="ext">
          <option value="" {if $smarty.request.ext==''}selected="selected"{/if}>{$langadmin.all}</option>
          <option value=".zip" {if $smarty.request.ext=='.zip'}selected="selected"{/if}>*.zip</option>
          <option value=".rar" {if $smarty.request.ext=='.rar'}selected="selected"{/if}>*.rar</option>
          <option value=".gz" {if $smarty.request.ext=='.gz'}selected="selected"{/if}>*.gz</option>
          <option value="bzip" {if $smarty.request.ext=='bzip'}selected="selected"{/if}>*.bzip</option>
          <option value="bzip2" {if $smarty.request.ext=='bzip2'}selected="selected"{/if}>*.bzip2</option>
          <option value="gzip" {if $smarty.request.ext=='gzip'}selected="selected"{/if}>*.gzip</option>
          <option value="bzip" {if $smarty.request.ext=='bzip'}selected="selected"{/if}>*.tgz</option>
          <option value=".jpg" {if $smarty.request.ext=='.jpg'}selected="selected"{/if}>*.jpg</option>
          <option value=".gif" {if $smarty.request.ext=='.gif'}selected="selected"{/if}>*.gif</option>
          <option value=".png" {if $smarty.request.ext=='.png'}selected="selected"{/if}>*.png</option>
          <option value=".txt" {if $smarty.request.ext=='.txt'}selected="selected"{/if}>*.txt</option>
          <option value=".sql" {if $smarty.request.ext=='.sql'}selected="selected"{/if}>*.sql</option>
          <option value=".pdf" {if $smarty.request.ext=='.pdf'}selected="selected"{/if}>*.pdf</option>
          <option value="html" {if $smarty.request.ext=='.html'}selected="selected"{/if}>*.html</option>
          <option value=".htm" {if $smarty.request.ext=='.htm'}selected="selected"{/if}>*.htm</option>
        </select>
        <select name="pp" id="pp">
{section name=pp loop=95 step=5}
          <option value="{$smarty.section.pp.index+10}" {if $smarty.request.pp == $smarty.section.pp.index+10}selected{/if}>{$smarty.section.pp.index+10}  {#FORUMS_EACH_PAGE_FILES#}</option>
{/section}
        </select>
        <input type="submit" class="button" value="{#FORUMS_SEARCH_FILES#}" /></td>
    </tr>
  </table>
</form>
<h4>{#FORUMS_SHOW_ATTACHMENTS#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=show_attachments&cp={$sess}&save=1" method="post" enctype="multipart/form-data" name="kform" id="kform">
  <table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td><a class="header" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=show_attachments&cp={$sess}&amp;ext={$smarty.request.ext}&amp;pp={$smarty.request.pp|default:10}&sort=name">{#FORUMS_HEADER_NAME_FILES#}</a></td>
      <td width="5%" align="center"><a class="header" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=show_attachments&cp={$sess}&amp;ext={$smarty.request.ext}&amp;pp={$smarty.request.pp|default:10}&sort=hits">{#FORUMS_HEADER_HITS_FILES#}</a></td>
      <td width="10%">&nbsp;</td>
      <td><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
    </tr>
    {foreach from=$attachments item="sm"}
  <tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
      <td width="20%" nowrap="nowrap"><a  href="index.php?do=modules&action=modedit&mod=forums&moduleaction=show_attachments&cp={$sess}&dl=1&amp;id={$sm->id}"><strong>{$sm->orig_name}</strong></a> </td>
      <td align="center" nowrap="nowrap"> {$sm->hits} </td>
      <td align="right">{$sm->sizes}</td>
      <td><input name="del[{$sm->filename}]" type="checkbox" id="d" value="1" /> {#FORUMS_DEL#}</td>
    </tr>
    {/foreach}
    <tr >
      <td colspan="4" class="second"><input type="submit" class="button" value="{#FORUMS_BUTTON_SAVE#}" /></td>
	</tr>
  </table>
</form>
{if $nav}
<table width="100%"  border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <tr>
    <td class="c1">{$nav}</td>
  </tr>
</table>
<br />
{/if} 