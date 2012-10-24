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
		<td class="box_inner_body">
			<div align="center">
				<a href="index.php?module=forums&amp;show=pn&amp;goto=inbox"><strong>{#FORUMS_PN_IN#}</strong></a> |
				<a href="index.php?module=forums&amp;show=pn&amp;goto=outbox"><strong>{#FORUMS_PN_OUT#}</strong></a> |
				<a href="index.php?module=forums&amp;show=pn&amp;action=new"><strong>{#FORUMS_PN_NEW#}</strong></a>
			</div>
		</td>
	</tr>
</table>
<!-- // INBOX / OUTBOX -->
<!-- // NO MESSAGES -->
{if $nomessages == 1}
<h1>{#FORUMS_PN_NO_MESSAGES#}</h1>
{/if}
<!-- NO MESSAGES // -->
{if $outin == 1}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
		{if $smarty.request.goto=='outbox'}
			<h2>{#FORUMS_PN_OUT#}</h2>
		{else}
			<h2>{#FORUMS_PN_IN#}</h2>
		{/if}
			<br /><br />
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="50%">
						<table width="100%" border="0" cellpadding="2" cellspacing="1" class="forum_tableborder">
							<tr>
								<td width="1%" class="forum_info_main">
									<table width="15%" border="0"  cellpadding="2" cellspacing="0" class="">
										<tr>
											<td nowrap="nowrap">
												<div align="center">0 % </div>
											</td>
										</tr>
									</table>
								</td>
								<td width="70%"  align="left" class="forum_info_meta">
									<table width="{$inoutwidth}%"  border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td style="width:{$inoutwidth}%;background:url({$forum_images}pn/pn_bar.gif)">
												<img src="{$forum_images}pn/pn_bar.gif" alt="" />
											</td>
										</tr>
									</table>
								</td>
								<td width="1%" class="forum_info_main">
									<table width="15%" border="0"  cellpadding="2" cellspacing="0" class="">
										<tr>
											<td nowrap="nowrap">
												<div align="center">100 % </div>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<td align="right">
						{$pnioutnall} ({$inoutpercent} %) {$pnmax} <span class="errorfont"> {$warningpnfull} </span>
					</td>
				</tr>
			</table>
			<br />
		</td>
	</tr>
</table>
<br />
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td >
			<table width="100%" border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
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
								<option value="DESC" {$sel1}>{#FORUMS_DESC#}</option>
								<option value="ASC" {$sel2}>{#FORUMS_ASC#}</option>
							</select>
								<input type="submit" class="button" value="{#FORUMS_PN_BUTTON_SHOW#}" />
								<input name="page" type="hidden" id="page" value="{$page}" />
						</form>
						<!-- ANZAHLWAHL -->          
					</td>
				</tr>
					<form  method="post" action="index.php?module=forums&amp;show=pn&amp;del=yes" name="kform" id="kform" onsubmit="return confirm('{#FORUMS_PN_DEL_MARKED_CONFIRM#}');">
				<tr class="row_second">
					<td height="30" colspan="2" nowrap="nowrap" class="forum_header_bolder">
						<input name="allbox" type="checkbox" id="d" onclick="selall();" value="" />
					</td>
					<td colspan="2" align="right"  nowrap="nowrap" class="forum_header_bolder">
						<a href="{$normmodus_link}" class="forum_links_cat">{#FORUMS_PN_VIEW_NORMAL#} </a> | <a href="{$katmodus_link}" class="forum_links_cat">{#FORUMS_PN_VIEW_CAT#}</a> 
					</td>
				</tr>
			{foreach from=$table_data item=data}
				{$data.tbody_start}
				<tr>
					<td class="{cycle name='pnl' values='forum_post_first,forum_post_second'}" width="1%" nowrap="nowrap">
						<div align="center">
							<input name="pn_{$data.pnid}" type="checkbox" id="d" value="1" />
						</div>
					</td>
					<td class="{cycle name='pnl2' values='forum_post_first,forum_post_second'}" nowrap="nowrap">
						<div align="center">
							{$data.icon}
						</div>
					</td>
					<td class="{cycle name='pnl4' values='forum_post_first,forum_post_second'}" width="100%" nowrap="nowrap">
						<a href="{$data.mlink}" class="title"><strong>{$data.title}</strong></a><br />
							<small>
							{$data.message|truncate:50}<br />
						{if $smarty.request.goto=='inbox'}
							{#FORUMS_PN_SENDER#}:
						{else}
							{#FORUMS_PN_RECIEVER#}:
						{/if}
							<a href="{$data.toid}">{$data.von}</a>
							</small>
					</td>
                    <td class="{cycle name='pnl5' values='forum_post_first,forum_post_second'}" width="10%" valign="top" nowrap="nowrap">
						{$data.pntime|date_format:$smarty.config.FORUMS_DATE_FORMAT_LAST_POST}
					</td>
				</tr>
				{$data.tbody_end}
			{/foreach}
				<tr>
					<td colspan="4" nowrap="nowrap" class="forum_info_meta">
						<table width="100%"  border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td align="left">{$nav}</td>
								<td align="right">
									<a href="{$pndl_text}">{#FORUMS_PN_DOWNLOAD_TEXT#}</a> | <a href="{$pndl_html}">{#FORUMS_PN_DOWNLOAD_HTML#}</a>
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="4" align="center" nowrap="nowrap" class="forum_info_meta" >
						<input name="goto" type="hidden" id="goto" value="{$goto}" />
						<input type="submit" class="button" value="{#FORUMS_PN_BUTTON_DEL_MARKED#}" />
					</td>
				</tr>
			</form>
			</table>
		</td>
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
		alert("{#FORUMS_PN_PLS_ENTER_ID_USER#}");
		document.f.tofromname.focus();
		errors = "1";
		return false;
	{rdelim}

	if (document.f.title.value == "") {ldelim}
		alert("{#FORUMS_PN_PLS_ENTER_HEADING#}");
		document.f.title.focus();
		errors = "1";
		return false;
	{rdelim}

	if (document.f.text.value.length <=  1 ) {ldelim}
		alert("{#FORUMS_PN_PLS_ENTER_MESSAGE#}");
		document.f.text.focus();
		errors = "1";
		return false;
	{rdelim}

	if (document.f.text.value.length > "{$max_post_length}" ) {ldelim}
		alert("{#FORUMS_PN_TEXT_TO_LONG#} "+f.text.value.length+"  {$max_post_length_t} {$max_post_length}  ");
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
	if (postmaxchars != 0) message = " {#FORUMS_PN_MAX_LENGTH#} "+postmaxchars+"";
	else message = "";
	alert("{#FORUMS_PN_MAX_LENGTH#} "+theform.text.value.length+" "+message);
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
		<td >
			<table width="100%"  border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
				<tr>
					<td class="forum_header"><strong>{#FORUMS_PREVIEW#}</strong></td>
				</tr>
				<tr>
					<td class="forum_info_meta">{$preview_text|stripslashes}</td>
				</tr>
			</table>
		</td>
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
					<strong>{#FORUMS_PN_NEW#}</strong>
				{/if}
					</td>
				</tr>
				<tr>
					<td colspan="2" class="forum_info_meta">{$newpn_t}
						<br />
				{if $iserror == 1}
					<br>
              <h2>{#FORUMS_PN_ERROR#}</h2>
              <ul>
                {foreach from=$error item=e}
				<li>{$e}</li>
				{/foreach}
              </ul>
              {/if}
					</td>
				</tr>
				<tr>
					<td width="150" nowrap="nowrap" class="forum_post_first">{#FORUMS_PN_USER_OR_ID#}</td>
					<td valign="top" class="forum_post_second">
						<input name="tofromname"  type="text" class="inputfield" id="tofromname" value="{$tofromname}" size="40" />
						<input onclick="window.open('index.php?module=forums&show=userpop&pop=1&theme_folder={$theme_folder}','us','left=0,top=0,height=700,width=400');" type="button" class="button" value="{#FORUMS_PN_SEARCH_USER#}" />
					</td>
				</tr>
				<tr>
					<td width="150" nowrap="nowrap" class="forum_post_first">
						<span class="forum_post_first" style="width: 20%">{#FORUMS_SUBJECT#}</span>
					</td>
					<td valign="top" class="forum_post_second">
						<input name="title"  type="text" class="inputfield" id="title" value="{$title}" size="40" />
					</td>
				</tr>
				<tr>
					<td width="150" nowrap="nowrap" class="forum_post_first">{#FORUMS_FORMAT#}<span class="td1"></span></td>
					<td valign="top" class="forum_post_second">{include file="$inc_path/format.tpl"}        </td>
				</tr>
				<tr>
					<td width="150" valign="top" nowrap="nowrap" class="forum_post_first">{#FORUMS_PN_FMESSAGE#}<br />
					<br />
              {if $smilie == 1}
			    {#FORUMS_EMOTIONS#}<br />
                {$listemos}
			  {/if}
					</td>
					<td valign="top" class="forum_post_second">
						<textarea id="msgform" onkeyup="javascript:zaehle()" style="width:99%" class="inputfield" name="text" rows="15" onfocus="getActiveText(this)" onclick="getActiveText(this)"  onchange="getActiveText(this)">{$text|stripslashes}</textarea>
					</td>
				</tr>
				<tr>
					<td width="150" valign="top" nowrap="nowrap" class="forum_post_first">{#FORUMS_POST_OPTIONS#}</td>
					<td valign="top" class="forum_post_second">
						<input name="use_smilies" type="checkbox" id="use_smilies" value="yes" checked="checked" />{#FORUMS_PN_FUSE_SMILIES#}<br />
						<input name="parseurl" type="checkbox" id="parseurl" value="yes" checked="checked" />{#FORUMS_PN_FPARSE#}<br />
						<input name="savecopy" type="checkbox" id="savecopy" value="yes" checked="checked" />{#FORUMS_PN_FSAVE_COPY#}
					</td>
				</tr>
				<tr>
					<td width="150" nowrap="nowrap" class="forum_post_first">&nbsp;</td>
					<td valign="top" class="forum_post_second">
						<input type="hidden" name="send" id="hsend" value="" />
						<button class="button" name="x" type="submit" onclick="document.getElementById('hsend').value='1';" />{#FORUMS_PREVIEW#}</button>
						&nbsp;
						<button class="button" name="x" type="submit" onclick="document.getElementById('hsend').value='2';" />{#FORUMS_BUTTON_ADD_NEW#}</button>
						<input type="button" class="button" onclick="beitrag(document.f);"  value="{#FORUMS_PN_FCHECK#}" />
					</td>
				</tr>
				</form>
			</table>
		</td>
	</tr>
</table>
{/if}
<!-- NEW MESSAGE // -->
<br />
{if $showmessage == 1}
<table width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
		<td >
			<table width="100%"  border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
				<tr>
					<td colspan="2" class="forum_header"><strong>{$pntitle}</strong></td>
				</tr>
				<tr valign="top">
					<td width="150" height="120" class="forum_post_first">
						<strong>{#FORUMS_PN_SENDER#}</strong><br />
						<a class="light"  href="{$tofromname_link}">{$tofromname} </a><br />
						<strong>{#FORUMS_PN_DATE#}</strong><br />
						<span class="row_second"> <span class="time"> {$pntime|date_format:$smarty.config.FORUMS_DATE_FORMAT_LAST_POST} </span></span>
					</td>
					<td class="forum_post_second">
						{$message}
					</td>
				</tr>
			</table>
			<br />
		{if $answerok == 1}
			<input type="button" class="button" onclick="location.href='{$relink}';" value="{#FORUMS_PN_REPLY#}" />
		{/if}
			<input type="button" class="button" onclick="location.href='{$forwardlink}';" value="{#FORUMS_PN_FORWARD#}" />
			<input type="button" class="button" onclick="if(confirm('{#FORUMS_PN_DEL_MARKED_CONFIRM#}')) location.href='{$delpn}';" value="{#FORUMS_PN_DEL#}" />
		</td>
	</tr>
</table>
{/if}