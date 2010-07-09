<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#Modulname#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br>
<div class="infobox"><a href="index.php?do=modules&action=modedit&mod=userpage&moduleaction=1&cp={$sess}">{#Config_Fields#}</a> | <strong>{#Template#}</strong></a> | <a href="index.php?do=modules&action=modedit&mod=userpage&moduleaction=update&cp={$sess}">{#Update#}</a></div>
<br>
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
  <form name="tpl" id="tpl" method="post" action="{$formaction}">
    <tr>
      <td class="tableheader">{#HTML_Code#}</td>
    </tr>
    <tr>
      <td class="first"><textarea wrap="off" style="width:98%; height:350px" name="Template" id="Template">{$row->tpl|escape:html}</textarea>
        <div class="infobox"> {assign var=js_textfeld value='Template'}
          {assign var=js_form value='tpl'} <a href="javascript:cp_insert('[tag:name]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Name#} </a> | <a href="javascript:cp_insert('[tag:benutzername]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Benutzername#} </a> | <a href="javascript:cp_insert('[tag:land]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Land#} </a> | <a href="javascript:cp_insert('[tag:registriert]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Registriert#} </a> | <a href="javascript:cp_insert('[tag:kontakt]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Kontakt#} </a> | <a href="javascript:cp_insert('[tag:webseite]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Webseite#} </a> | <a href="javascript:cp_insert('[tag:signatur]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Signatur#} </a> | <a href="javascript:cp_insert('[tag:interessen]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Interessen#} </a> | <a href="javascript:cp_insert('[tag:geburtstag]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Geburtstag#} </a> | <a href="javascript:cp_insert('[tag:geschlecht]','{$js_textfeld}', '{$js_form}');"> {#Tpl_Geschlecht#} </a> </div>
      </td>
    </tr>
    <tr>
      <td style="padding:0px" class="second">
        <table width="100%" border="0" cellspacing="1" cellpadding="4">
          {foreach from=$tags item=tag}
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag_feld:{$tag->Id}]','{$js_textfeld}', '{$js_form}');">[tag_feld:{$tag->Id}]</a> </td>
            <td class="first">{$tag->title}</td>
          </tr>
          {/foreach}
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag_lang:XXX]','{$js_textfeld}', '{$js_form}');">[tag_lang:XXX]</a> </td>
            <td class="first">{#Tpl_Lang#}</td>
          </tr>
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag:avatar]','{$js_textfeld}', '{$js_form}');">[tag:avatar]</a> </td>
            <td class="first">{#Tpl_Avatar#}</td>
          </tr>
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag:onlinestatus]','{$js_textfeld}', '{$js_form}');">[tag:onlinestatus]</a> </td>
            <td class="first">{#Tpl_Online#} <a href="javascript:cp_insert('[tag:onlinestatus-1]','{$js_textfeld}', '{$js_form}');">[tag:onlinestatus-1]</a> )</td>
          </tr>
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag_guestbook:3]','{$js_textfeld}', '{$js_form}');">[tag_guestbook:3]</a> </td>
            <td class="first">{#Tpl_Guestbook#}</td>
          </tr>
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag_forum:5]','{$js_textfeld}', '{$js_form}');">[tag_forum:5]</a></td>
            <td class="first">{#Tpl_Forum#}</td>
          </tr>
          <tr>
            <td width="150" class="first"><a title="{#TagInsertHelp#}" href="javascript:cp_insert('[tag_downloads:3]','{$js_textfeld}', '{$js_form}');">[tag_downloads:3]</a></td>
            <td class="first">{#Tpl_Downloads#}</td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td class="second"><input class="button" type="submit" value="{#ButtonSave#}"></td>
    </tr>
  </form>
</table>