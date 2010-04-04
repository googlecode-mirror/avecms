<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#guest_config#}</h2></div>
    <div class="HeaderText">{#guest_info#}</div>
</div><br />

<form name="form2" method="post" action="index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&sub=save&cp={$sess}">
  <table width="100%"  border="0" align="center" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
      <td width="220" class="first">{#guest_maxlenght#}</td>
      <td class="second"><input name="maxpostlength" type="text"  value="{$settings->maxpostlength}"></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_spam#}</td>
      <td class="second"><input name="spamprotect" type="checkbox" value="1" {if $settings->spamprotect==1}checked="checked"{/if}></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_spam_time#}</td>
      <td class="second"><input name="spamprotect_time" type="text"  value="{$settings->spamprotect_time}"></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_message_email#}</td>
      <td class="second"><input name="mailbycomment" type="checkbox" value="1" {if $settings->mailbycomment==1}checked="checked"{/if}></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_mailsend#}</td>
      <td class="second"><input name="mailsend" type="text" {if $settings->mailsend!=''}value="{$settings->mailsend}"{/if}></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_must_censored#}</td>
      <td class="second"><input name="entry_censore" type="checkbox" value="1" {if $settings->entry_censore==1}checked="checked"{/if}></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_enable_smiles#}</td>
      <td class="second"><input name="ensmiles" type="checkbox" value="1" {if $settings->smiles==1}checked="checked"{/if}></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_enable_bbcode#}</td>
      <td class="second"><input name="enbbcodes" type="checkbox" value="1" {if $settings->bbcodes==1}checked="checked"{/if}></td>
    </tr>
    <tr>
      <td width="220" class="first">{#guest_smile_onstring#}</td>
      <td class="second"><input name="sbr" type="text" value="{$settings->smiliebr}" maxlength="2"></td>
    </tr>
</table>
  <br />
  <input name="Submit" type="submit" class="button" value="{#guest_b_save#}">
</form>

<h4>{#guest_new_post#}</h4>

<div class="second" style="padding:3px">
<form action="index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp={$sess}"  method="post" name="pp" style="display:inline">
{if $pnav}{$pnav}{/if}
<select name="sort" id="sort">
<option value="desc" {if $smarty.request.sort == desc} selected="selected" {/if}>{#guest_sortbydesc#}</option>
<option value="asc" {if $smarty.request.sort == asc} selected="selected" {/if}>{#guest_sortbyasc#}</option>
</select>
<select name="pp" id="pp">
{section name=pp loop=95 step=5}
<option value="{$smarty.section.pp.index+10}" {if $smarty.request.pp == $smarty.section.pp.index+10}selected{/if}>{#guest_on#} {$smarty.section.pp.index+10} {#guest_onpage#}</option>
{/section}
 </select>
<input type="submit" class="button" value="{#guest_b_sort#}" />
</form>
</div>
<br/>
<br />
<form name="form1" method="post" action="index.php?do=modules&action=modedit&mod=guestbook&moduleaction=medit&cp={$sess}">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
{foreach from=$comments_array item=item}
<tr class="tableheader">
      <td>{#guest_autor_name#}</td>
      <td>{#guest_autor_email#}</td>
      <td width="20%">{#guest_autor_site#}</td>
      <td>{#guest_autor_from#}</td>
    </tr>
    <tr class="second" {if $item->is_active != 1}style="background-color:#ffcccc"{/if} id="table_rows">
      <td><input name="author[{$item->id}]" type="text" value="{$item->author }" size="30" /></td>
      <td><input name="email[{$item->id}]" type="text" value="{$item->email }" size="30" /></td>
      <td><input name="web[{$item->id}]" type="text" value="{$item->web }" size="30" /></td>
      <td><input name="authfrom[{$item->id}]" type="text" value="{$item->authfrom }" size="30" /></td>
    </tr>
    <tr class="second" {if $item->is_active != 1}style="background-color:#ffcccc"{/if} id="table_rows">
      <td valign="middle">{#guest_text#}</td>
      <td colspan="3"><textarea name="comment[{$item->id}]" cols="50" rows="3" id="comment[{$item->id}]" style="width:80%">{$item->comment|escape:'html' }</textarea></td>
      </tr>
    <tr class="second" {if $item->is_active != 1}style="background-color:#ffcccc"{/if} id="table_rows">
      <td>{#guest_actions#}</td>
      <td colspan="3">
<input name="del[{$item->id}]" type="checkbox" id="d" value="1" />{#guest_delete#}
{if $item->is_active != 1}
<br />
<input name="is_active[{$item->id}]" type="checkbox" value="1" />{#guest_active_message#}
{else}
<br />
<input name="is_active[{$item->id}]" type="checkbox" value="0" />{#guest_inactive_message#}
{/if}
</td>
</tr>
{/foreach}
</table>

<br />
<input name="Submit" type="submit" class="button" value="{#guest_b_change#}">
</form>
{if $navi}{$pnav}{/if}
