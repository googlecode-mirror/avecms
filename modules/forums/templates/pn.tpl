
{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}
<br />
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
<table width="100%"  border="0" cellpadding="3" cellspacing="1" class="box_inner">
  <tr>
    <td class="box_inner_body"><div align="center">
	<a href="index.php?module=forums&amp;show=pn&amp;goto=inbox"><strong>{#PN_In#}</strong></a> |
	<a href="index.php?module=forums&amp;show=pn&amp;goto=outbox"><strong>{#PN_Out#}</strong></a> |
	<a href="index.php?module=forums&amp;show=pn&amp;action=new"><strong>{#PN_New#} </strong></a></div></td>
  </tr>
</table>
<!-- // INBOX / OUTBOX -->
<!-- // NO MESSAGES -->
{if $nomessages == 1}
<h1>{#PN_NoMessages#}</h1>
{/if}
<!-- NO MESSAGES // -->
{if $outin == 1}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>

      {if $smarty.request.goto=='outbox'}
	  <h2>{#PN_Out#}</h2>
	  {else}
	  <h2>{#PN_In#}</h2>
	  {/if}
      <br />
      <br />
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50%"><table width="100%" border="0" cellpadding="2" cellspacing="1" class="forum_tableborder">
            <tr>
              <td width="1%" class="forum_info_main"><table width="15%" border="0"  cellpadding="2" cellspacing="0" class="">
                  <tr>
                    <td nowrap="nowrap"><div align="center">0 % </div></td>
                  </tr>
              </table></td>
              <td width="70%"  align="left" class="forum_info_meta"><table width="{$inoutwidth}%"  border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td style="width:{$inoutwidth}%;background:url({$forum_images}pn/pn_bar.gif)"><img src="{$forum_images}pn/pn_bar.gif" alt="" /></td>
                  </tr>
              </table></td>
              <td width="1%" class="forum_info_main"><table width="15%" border="0"  cellpadding="2" cellspacing="0" class="">
                  <tr>
                    <td nowrap="nowrap"><div align="center">100 % </div></td>
                  </tr>
              </table></td>
            </tr>
          </table></td>
          <td align="right">{$pnioutnall}
      ({$inoutpercent}
      %)
      {$pnmax} <span class="errorfont"> {$warningpnfull} </span></td>
        </tr>
      </table>
    <br /></td>
  </tr>
</table>
<br />
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><table width="100%" border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
        <tr class="box_innerhead">
          <td height="30" colspan="4" align="center" class="forum_header">
            <!-- ANZAHLWAHL -->
            <form  method="post" action="index.php?module=forums&amp;show=pn&amp;goto={$goto}" name="psel" id="psel">
              <select name="pp" id="pp">
                  {$pp_l}
                </select>
              <select name="porder" id="porder">
                  {$sel_topic_read_unread}
                </select>
              <select name="sort" id="sort">
                <option value="DESC" {$sel1}>
                {#Desc#}                </option>
                <option value="ASC" {$sel2}>
                {#Asc#}                </option>
              </select>
              <input type="submit" class="button" value="{#PN_ButtonShow#}" />
              <input name="page" type="hidden" id="page" value="{$page}" />
            </form>            <!-- ANZAHLWAHL -->          </td>
        </tr>
        <form  method="post" action="index.php?module=forums&amp;show=pn&amp;del=yes" name="kform" id="kform" onsubmit="return confirm('{#PN_DelMarkedC#}');">
          <tr class="row_second">
            <td height="30" colspan="2" nowrap="nowrap" class="forum_header_bolder">
              <input name="allbox" type="checkbox" id="d" onclick="selall();" value="" />
            </td>
            <td colspan="2" align="right"  nowrap="nowrap" class="forum_header_bolder"> <a href="{$normmodus_link}" class="forum_links_cat">
              {#PN_ViewN#} </a> | <a href="{$katmodus_link}" class="forum_links_cat">
              {#PN_ViewC#}</a> </td>
          </tr>
          {foreach from=$table_data item=data}
          {$data.tbody_start}
          <tr>
            <td class="{cycle name='pnl' values='forum_post_first,forum_post_second'}" width="1%" nowrap="nowrap"><div align="center">
                <input name="pn_{$data.pnid}" type="checkbox" id="d" value="1" />
              </div></td>
            <td class="{cycle name='pnl2' values='forum_post_first,forum_post_second'}" nowrap="nowrap"><div align="center">
                {$data.icon}
            </div></td>
            <td class="{cycle name='pnl4' values='forum_post_first,forum_post_second'}" width="100%" nowrap="nowrap"><a href="{$data.mlink}" class="title">
			<strong>{$data.title}</strong></a>
			<br />
			<small>
			{$data.message|truncate:50}
			<br />

		    {if $smarty.request.goto=='inbox'}
			{#PN_sender#}:
			{else}
			{#PN_reciever#}:
			{/if}
			<a href="{$data.toid}">{$data.von}</a>
			</small>
			</td>
            <td class="{cycle name='pnl5' values='forum_post_first,forum_post_second'}" width="10%" valign="top" nowrap="nowrap">
              {$data.pntime|date_format:$config_vars.DateFormatLastPost}
		    </td>
          </tr>
          {$data.tbody_end}
          {/foreach}
          <tr>
            <td colspan="4" nowrap="nowrap" class="forum_info_meta">              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td align="left">{$nav}</td>
                  <td align="right">
                    <a href="{$pndl_text}">{#PN_DownloadText#}</a> | <a href="{$pndl_html}">{#PN_DownloadHTML#}</a></td>
                </tr>
              </table></td></tr>
          <tr>
            <td colspan="4" align="center" nowrap="nowrap" class="forum_info_meta" >
              <input name="goto" type="hidden" id="goto" value="{$goto}" />
			  <input type="submit" class="button" value="{#PN_ButtonDelMarked#}" />
		    </td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
{/if}
<!-- INBOX / OUTBOX // -->
<!-- // NEW MESSAGE -->
{if $neu == 1}
<br>
<script language="JavaScript" type="text/javascript">
<!--
function chkf() {ldelim}
	errors = "";

	if (document.f.tofromname.value == "") {ldelim}
		alert("{#PN_NoR#}");
		document.f.tofromname.focus();
		errors = "1";
		return false;
	{rdelim}

	if (document.f.title.value == "") {ldelim}
		alert("{#PN_NoS#}");
		document.f.title.focus();
		errors = "1";
		return false;
	{rdelim}

	if (document.f.text.value.length <=  1 ) {ldelim}
		alert("{#PN_NoT#}");
		document.f.text.focus();
		errors = "1";
		return false;
	{rdelim}

	if (document.f.text.value.length > "{$max_post_length}" ) {ldelim}
		alert("{#PN_TextToLong#} "+f.text.value.length+"  {$max_post_length_t} {$max_post_length}  ");
		document.f.text.focus();
		errors = "1";
		return false;
	{rdelim}

	if (errors == "") {ldelim}
		document.f.sendmessage.disabled = true;
		return true;
	{rdelim}
}

var postmaxchars = "{$max_post_length}";

function beitrag(theform) {ldelim}
	if (postmaxchars != 0) message = " {#PN_MaxLength#} "+postmaxchars+"";
	else message = "";
	alert("{#PN_MaxLength#} "+theform.text.value.length+" "+message);
{rdelim}

var formfeld = "";
var maxlang = "{$max_post_length}";

function zaehle() {ldelim}
	if (window.document.f.text.value.length>"5000") {ldelim}
		window.document.newc.f.value=formfeld;
		return;
	{rdelim} else {ldelim}
		formfeld=window.document.f.text.value;
		window.document.f.zeichen.value=maxlang-window.document.f.text.value.length;
	{rdelim}
{rdelim}
//-->
</script>
{if $preview == 1}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><table width="100%"  border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
        <tr>
          <td class="forum_header"><strong>{#Preview#}</strong></td>
        </tr>
        <tr>
          <td class="forum_info_meta">{$preview_text|stripslashes}</td>
        </tr>
      </table></td>
  </tr>
</table>
<br />
{/if}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>
	<table width="100%" border="0" cellpadding="7" cellspacing="1" class="forum_tableborder">
        <form action="index.php?module=forums&amp;show=pn&amp;action=new" method="post" name="f"  onsubmit="return chkf();">
          <tr>
            <td colspan="2" class="box_innerhead">
			{if $smarty.request.forward == 2}
              {$lang.replytopn}
              {else}
              <strong>{#PN_New#} </strong>{/if}			</td>
          </tr>
          <tr>
            <td colspan="2" class="forum_info_meta">{$newpn_t}
              <br />
              {if $iserror == 1}
              <br>
              <h2>{#PN_Error#}</h2>
              <ul>
                {foreach from=$error item=e}
				<li>{$e}</li>
				{/foreach}
              </ul>
              {/if}
            </td>
          </tr>
          <tr>
            <td width="150" nowrap="nowrap" class="forum_post_first">{#PN_UserOrId#} </td>
            <td valign="top" class="forum_post_second"><input name="tofromname"  type="text" class="inputfield" id="tofromname" value="{$tofromname}" size="40" />
              <input onclick="window.open('index.php?module=forums&show=userpop&pop=1&theme_folder={$theme_folder}','us','left=0,top=0,height=700,width=400');" type="button" class="button" value="{#PN_SearchUser#}" />
            </td>
          </tr>
          <tr>
            <td width="150" nowrap="nowrap" class="forum_post_first"><span class="forum_post_first" style="width: 20%">{#Subject#}</span></td>
            <td valign="top" class="forum_post_second"><input name="title"  type="text" class="inputfield" id="title" value="{$title}" size="40" />
            </td>
          </tr>
          <tr>
            <td width="150" nowrap="nowrap" class="forum_post_first">{#Format#}<span class="td1"></span></td>
            <td valign="top" class="forum_post_second">{include file="$inc_path/format.tpl"}        </td>
          </tr>
          <tr>
            <td width="150" valign="top" nowrap="nowrap" class="forum_post_first">{#PN_FMessage#}<br />
              <br />

              {if $smilie == 1}{#EMotiocns#}<br />
              {$listemos}

            {/if}            </td>
            <td valign="top" class="forum_post_second"><textarea id="msgform" onkeyup="javascript:zaehle()" style="width:99%" class="inputfield" name="text" rows="15" onfocus="getActiveText(this)" onclick="getActiveText(this)"  onchange="getActiveText(this)">{$text|stripslashes}</textarea>
            </td>
          </tr>
          <tr>
            <td width="150" valign="top" nowrap="nowrap" class="forum_post_first">{#PostOptions#}</td>
            <td valign="top" class="forum_post_second"><input name="use_smilies" type="checkbox" id="use_smilies" value="yes" checked="checked" />
              {#PN_FUseSmilies#}<br />
              <input name="parseurl" type="checkbox" id="parseurl" value="yes" checked="checked" />
              {#PN_FParse#}<br />
              <input name="savecopy" type="checkbox" id="savecopy" value="yes" checked="checked" />
              {#PN_FSaveCopy#}</td>
          </tr>

          <tr>
            <td width="150" nowrap="nowrap" class="forum_post_first">&nbsp;</td>
            <td valign="top" class="forum_post_second">
			<input type="hidden" name="send" id="hsend" value="" />
			<button class="button" name="x" type="submit" onclick="document.getElementById('hsend').value='1';" />{#Preview#}</button>
			&nbsp;
			<button class="button" name="x" type="submit" onclick="document.getElementById('hsend').value='2';" />{#AddNew#}</button>

            <input type="button" class="button" onclick="beitrag(document.f);"  value="{#PN_FCheck#}" />
            </td>
          </tr>
        </form>
      </table></td>
  </tr>
</table>
{/if}
<!-- NEW MESSAGE // -->
<br />
{if $showmessage == 1}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td ><table width="100%"  border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
        <tr>
          <td colspan="2" class="forum_header"><strong>{$pntitle}</strong></td>
        </tr>

        <tr valign="top">
          <td width="150" height="120" class="forum_post_first"><strong>{#PN_sender#}</strong><br />
            <a class="light"  href="{$tofromname_link}">{$tofromname} </a><br />
              <strong>{#PN_Date#}</strong><br />
          <span class="row_second"> <span class="time"> {$pntime|date_format:$config_vars.DateFormatLastPost} </span></span></td>
          <td class="forum_post_second">{$message}</td>
        </tr>

      </table>
	  <br />
	  {if $answerok == 1}
	  <input type="button" class="button" onclick="location.href='{$relink}';" value="{#PnReply#}" />
     {/if}
	 <input type="button" class="button" onclick="location.href='{$forwardlink}';" value="{#PnForward#}" />
	 <input type="button" class="button" onclick="if(confirm('{#PN_DelMarkedC#}')) location.href='{$delpn}';" value="{#PnDel#}" />

    </td>
  </tr>
</table>
{/if}