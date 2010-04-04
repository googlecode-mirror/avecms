<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#faq_INSERT_H#}</h2></div>
    <div class="HeaderText">{#faq_INSERT#}</div>
</div><br>

<form action="index.php?do=modules&action=modedit&mod=faq&moduleaction=saveedit&cp={$sess}" method="post">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr class="tableheader">
      <td>{#faq_INNAME#}</td>
    </tr>
    
    <tr>
      <td class="second">
<div><input type="hidden" id="quest" name="quest" value="{$quest}" style="display:none" /><input type="hidden" id="quest___Config" value="" style="display:none" /><div id="quest_data"><iframe id="quest___Frame" src="editor/editor/fckeditor.html?InstanceName=quest&amp;Toolbar=cpengine" width="100%" height="400px" frameborder="0" scrolling="no"></iframe></div></div>        
      </td>
    </tr>
<tr class="tableheader">
      <td>{#faq_INDESC#}</td>
    </tr>
    
    <tr>
      <td class="second">
    <div><input type="hidden" id="answer" name="answer" value="{$answer}" style="display:none" /><input type="hidden" id="answer___Config" value="" style="display:none" /><div id="answer_data"><iframe id="answer___Frame" src="editor/editor/fckeditor.html?InstanceName=answer&amp;Toolbar=cpengine" width="100%" height="400px" frameborder="0" scrolling="no"></iframe></div></div>   
      </td>
    </tr>
    <tr>
      <td class="first">
        <input type="hidden" name="id" value="{$id}">
        <input type="hidden" name="parent" value="{$parent}">
        <input name="submit" type="submit" class="button" value="{#faq_SAVE#}" />
      </td>
    </tr>
  </table>
</form>
