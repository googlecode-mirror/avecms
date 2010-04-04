<script language="JavaScript" type="text/javascript" src="modules/guestbook/js/func.js"></script>

<table width="100%" border="0" cellpadding="3" cellspacing="0" class="box_inner">
  <tr>
    <td class="box_innerhead" width="1%" nowrap="nowrap">{#guest_pub_name#} | {#guest_all_comments#} {$allcomments}</td>
    <td class="box_innerhead" align="right">
      <form action="index.php?module=guestbook" method="post" name="pp">
        <select name="sort">
          <option value="desc" {if $descsel!=''}selected{/if}>{#guest_sortbydesc#}</option>
          <option value="asc" {if $ascsel!=''}selected{/if}>{#guest_sortbyasc#}</option>
        </select>

        <select name="pp">
          {foreach from=$pps_array item=pps}
            <option value="{$pps.ps}" {$pps.pps_sel}>{#guest_on#} {$pps.ps} {#guest_onpage#}</option>
          {/foreach}
        </select>

        <input type="submit" class="button" value="{#guest_b_sort#}" />
      </form>
    </td>
  </tr>

  <tr>
    <td align="left" colspan="2">{$pages}</td>
  </tr>
</table>
<br />

{foreach from=$comments_array item=comments}
<table border="0" width="98%" cellspacing="0" cellpadding="2" class="commBodyTable">
  <tr>
    <td class="commNumTd" width="1%" nowrap="nowrap"><STRONG>{$comments->author}</STRONG> <span class="mini">{if $comments->authfrom!=''}({$comments->authfrom}){/if}</span></td>
    <td class="commNameTd" width="79%">&nbsp;
      {if $comments->email!=''}<a href="mailto:{$comments->email}"><img src="modules/guestbook/images/email.gif" border="0"></a> | {/if}
      {if $comments->web!=''}<a href="{$comments->web}" target="_blank"><img src="modules/guestbook/images/web.gif" border="0"></a>{/if}
    </td>
    <td class="commDateTd" width="20%" align="right" nowrap>разместил: {$comments->ctime} г.</td>
  </tr>
  <tr>
    <td style="padding:10px" width="100%" colspan="3" >{$comments->comment}</td>
  </tr>
</table>
<br />
{/foreach}
<br />

<a name="new"></a>

<script language="JavaScript" type="text/javascript">
<!--
function chkf() {ldelim}
  errors = "";
  if (document.f.author.value == "") {ldelim}
    alert("{#guest_sorry_noautor#}");
    document.f.author.focus();
    errors = "1";
    return false;
  {rdelim}

  if (document.f.text.value.length <= 5) {ldelim}
    alert("{#guest_small_text#}");
    document.f.text.focus();
    errors = "1";
    return false;
  {rdelim}

  if (document.f.scode.value == "") {ldelim}
    alert("{#guest_no_scode_input#}");
    document.f.scode.focus();
    errors = "1";
    return false;
  {rdelim}

  if (document.f.text.value.length > {$maxpostlength}) {ldelim}
    alert('{$lang.error_once} {$lang.error_tomuchtext} {literal}' + f.text.value.length + '{/literal} {$lang.max_post_length_t} {$maxpostlength}');
    document.f.text.focus();
    errors = "1";
    return false;
  {rdelim}

  if (errors == "") {ldelim}
    document.f.sendmessage.disabled = true;
    return true;
  {rdelim}
{rdelim}

var postmaxchars = "{$maxpostlength}";

function beitrag(theform) {ldelim}
  if (postmaxchars != 0) message = " {#guest_post_lehght#} "+postmaxchars+"";
  else message = "";
  alert("{#guest_your_lenght#} "+theform.text.value.length+" "+message);
{rdelim}

var formfeld = "";
var maxlang = "{$maxpostlength}";

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

<form action="index.php?module=guestbook&action=new" method="post" name="f" onsubmit="return chkf();">
<table width="100%" border="0" cellspacing="1" cellpadding="4" class="box_inner">
  <tr>
    <td colspan="4" class="box_innerhead"><strong>{#guest_add#}</strong></td>
  </tr>

  <tr>
    <td width="3%" class="row_first" nowrap="nowrap">{#guest_your_name#}</td>
    <td class="row_second"><input name="author" type="text" class="inputfield" size="40" value="{$smarty.request.author|escape:'html'}" /></td>
    <td width="3%" class="row_first" nowrap="nowrap">{#guest_your_email#}</td>
    <td class="row_second"><input name="email" type="text" class="inputfield" size="40" value="{$smarty.request.email|escape:'html'}" /></td>
  </tr>

  <tr>
    <td width="1%" class="row_first" nowrap="nowrap">{#guest_your_site#}</td>
    <td class="row_second"><input name="http" type="text" class="inputfield" size="40" value="{$smarty.request.web|default:'http://'|escape:'html'}" /></td>
    <td width="1%" class="row_first" nowrap="nowrap">{#guest_your_city#}</td>
    <td class="row_second"><input name="from" type="text" class="inputfield" size="40" value="{$smarty.request.from|escape:'html'}" /></td>
  </tr>

{if $use_code==1}
  <tr>
    <td width="3%" nowrap="nowrap" class="row_first">{#guest_secure_code#}</td>
    <td nowrap="nowrap" class="row_second"><img src="inc/antispam.php?cp_secureimage={$pim}" alt="" border="0" vspace="2" /></td>
    <td width="3%" nowrap="nowrap" class="row_first">{#guest_secure_entercode#}</td>
    <td><input name="scode" id="scode" type="text" class="{if $codeerror==1}inputfielderror{else}inputfield{/if}" value="{$postcode|escape:html}" size="20" maxlength="7" /></td>
  </tr>
{/if}
</table>

<table width="100%" border="0" cellspacing="1" cellpadding="4" class="box_inner">
  <tr>
    <td colspan="2" class="box_innerhead"><strong>{#guest_head_newpost#}</strong></td>
  </tr>

  <tr>
    <td width="20%" valign="top" class="row_first">{#guest_text_newpost#}<br/>{if $smilie == 1}{$listemos}{/if}</td>
    <td class="row_second" valign="top">

{if $bbcodes == '1'}
<script language="JavaScript" type="text/javascript">
<!--
  var text_enter_url      = "{#guest_text_enter_url#}";
  var text_enter_url_name = "{#guest_text_enter_url_name#}";
  var text_enter_image    = "{$lang.text_enter_image}";
  var text_enter_email    = "{#guest_text_enter_email#}";
  var error_no_url        = "{#guest_error_no_url#}";
  var error_no_title      = "{#guest_error_no_title#}";
  var error_no_email      = "{#guest_error_no_email#}";
  var prompt_start        = "{#guest_prompt_start#}";
  var text_enter_image    = "{#guest_text_enter_image#}";
  var error_no_img        = "{#guest_error_no_img#}";
-->
</script>

{strip}
  <input class="button" accesskey="b" style="width:30px" onclick='easytag("B")' type="button" value="B" name="B" />&nbsp;
  <input class="button" accesskey="i" style="width:30px" onclick='easytag("I")' type="button" value="I" name="I" />&nbsp;
  <input class="button" accesskey="u" style="width:30px" onclick='easytag("U")' type="button" value="U" name="U" />&nbsp;
  <input class="button" accesskey="t" style="width:30px" onclick="tag_image()" type="button" value="IMG" name="img" />&nbsp;
  <input class="button" accesskey="h" style="width:30px" onclick="tag_url()" type="button" value="URL" name="url" />&nbsp;
  <input class="button" accesskey="e" style="width:30px" onclick="tag_email()" type="button" value="@" name="email" />&nbsp;
  <input class="button" onclick="closeall();" type="button" value="{#guest_b_closetags#}"/>
  <input name="kmode" type="hidden" />
  <input name="kmode" type="hidden" value="normal" />
{/strip}
{/if}

      <textarea name="text" cols="80" rows="7" class="inputfield" onfocus="getActiveText(this)" onchange="getActiveText(this)" onclick="getActiveText(this)" onkeyup="javascript:zaehle()">{$smarty.request.gbcomment|escape:'html'}</textarea>
      <input name="pim" type="hidden" value="{$pim}" />
      <input name="send" type="hidden" value="1" />
      <input name="submit" type="submit" class="button" onclick="closeall();" value="{#guest_b_addpost#}" />
      <input name="button" type="button" class="button" onclick="closeall();beitrag(document.f);" value="{#guest_b_check#}" />
    </td>
  </tr>
</table>
</form>