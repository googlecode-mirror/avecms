{strip}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{$titel}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<link href="templates/{$theme_folder}/css/style.css" rel="stylesheet" type="text/css" media="screen" />
<script src="templates/{$theme_folder}/js/common.js" type="text/javascript"></script>
</head>

<body id="body_popup">
  <div id="module_header">
    <h2>{$titel}</h2>
  </div>
  <div id="module_content">
  {if $email == 1}
    <form method="post" action="index.php?module=userpage&action=contact&uid={$smarty.request.uid}&amp;pop=1&amp;method=email">
      {if isset($errors)}
        <h3>{#Error#}</h3>
        {foreach from=$errors item=item}
  		    <ul>
            <li>{$item}</li>
  		    </ul>
  	    {/foreach}
  	  {/if}
      <!-- BETREFF -->
      <fieldset>
        <legend>
          <label for="l_Titel">{#Betreff#}</label>
        </legend>
        <input name="Titel" type="text" style="width:250px" value="" />
      </fieldset>
      <br />
      <!-- BETREFF -->
      <!-- NACHRICHT -->
      <fieldset>
        <legend>
          <label for="l_Text">{#Nachricht#}</label>
        </legend>
        <textarea style="width:98%; height:165px" name="Text"></textarea>
      </fieldset>
      <!-- NACHRICHT -->
      <p>
    	  <input name="send" value="1" type="hidden" />
    	  <input name="theme_folder" value="{$theme_folder}" type="hidden" />
        <input type="submit" class="button" value="{#Send#}" />&nbsp;
        <input onclick="window.close();" type="button" class="button" value="{#Close#}" />
      </p>
    </form>
  {else}
    <div align="center">
      <p><h3>{$wert}</h3></p>
      <p><input onclick="window.close();" type="button" class="button" value="{#Close#}" /></p>
    </div>
  {/if}
</div>
</body>
</html>
{/strip}