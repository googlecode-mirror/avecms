<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>{#Guestbook#}</title>
<link href="templates/{$theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$theme_folder}/js/common.js" type="text/javascript"></script>
</head>

<body id="body_popup">
  <div id="module_header">
    <h2>{#Guestbook#}</h2>
  </div>
  <div id="module_content">
    {if $cancomment != 1}
      <p id="module_intro">{#GuestbookError#}</p>
      <p>&nbsp;</p>
      <p><input onclick="window.close();" type="button" class="button" value="{#Close#}" /></p>
    {else}
      <form method="post" action="index.php?module=userpage&action=form&uid={$uid}&amp;pop=1">
        {if isset($errors)}
          <h3>{#Error#}</h3>
          {foreach from=$errors item=item}
          	<ul>
          		<li>{$item}</li>
          	</ul>
          {/foreach}
        {/if}
        <!-- TITEL -->
        <fieldset>
          <legend>
            <label for="l_Titel">{#Title#}</label>
          </legend>
          <input name="title" type="text" id="l_ACity" style="width:250px" value="{$titel}" />
        </fieldset>
        <br />
        <!-- TITEL -->
        <!-- KOMMENTAR -->
        <fieldset>
          <legend>
            <label for="l_Text">{#Message#}</label>
          </legend>
          <textarea onkeyup="javascript:textCounter(this.form.Text,this.form.charleft,{$MaxZeichen});" onkeydown="javascript:textCounter(this.form.Text,this.form.charleft,{$MaxZeichen});" style="width:98%; height:165px" name="Text" id="l_Text">{$text}</textarea>
          <input type="text" size="6" name="charleft" value="{$MaxZeichen}" /> {#CharsLeft#}
        </fieldset>
        <!-- KOMMENTAR -->
        {if $anti_spam == 1}
          <!-- CODE ABFRAGE -->
          <fieldset>
            <legend>
              <label for="l_Text">{#SecureCode#}</label>
            </legend>
            <img src="inc/antispam.php?cp_secureimage={$im}" alt="" width="121" height="41" border="0" /><br /><br />
            <small><span id="S_secure_{$im}"></span></small>
            <input name="cpSecurecode" type="text" id="secure_{$im}" style="width:100px" maxlength="7" />
          </fieldset>
          <!-- CODE ABFRAGE -->
        {/if}
        <p>
          <input name="send" value="1" type="hidden" />
          <input name="theme_folder" value="{$theme_folder}" type="hidden" />
          <input type="submit" class="button" value="{#GuestButton#}" />&nbsp;
          <input type="reset" class="button" />
        </p>
      </form>
    {/if}
  </div>
</body>
</html>