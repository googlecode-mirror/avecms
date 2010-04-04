<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<h4>{#NavSettings#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=settings&cp={$sess}&save=1" method="post">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
      <td width="220" class="first">{#S_SenderEmail#}</td>
      <td class="second"><label>
        <input name="AbsenderName" type="text" id="AbsenderName" value="{$r.AbsenderName}" size="40">
      </label></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_EmailEmail#} </td>
      <td class="second"><input name="AbsenderMail" type="text" id="AbsenderMail" value="{$r.AbsenderMail}" size="40"></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_Badwords#}</td>
      <td class="second"><input name="badwords" type="text" id="badwords" value="{$r.badwords}" size="40" style="width:98%"></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_BadwordsReplace#} </td>
      <td class="second"><input name="badwords_replace" type="text" id="badwords_replace" value="{$r.badwords_replace}" size="40"></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_PopUpHeader#}
	  <br />
	  <small>{#HeaderInf#}</small>
	  </td>
      <td class="second">        <textarea name="pageheader" cols="40" rows="8" id="pageheader" style="width:98%">{$r.pageheader|escape:html}</textarea>      </td>
    </tr>
    <tr>


      <td width="220" class="first">{#S_ContWidth#}</td>
      <td class="second"><input name="boxwidthcomm" type="text" id="boxwidthcomm" value="{$r.boxwidthcomm}" size="10" maxlength="3" /></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_ContHeight#}</td>
      <td class="second"><input name="maxlines" type="text" id="maxlines" value="{$r.maxlines}" size="10" maxlength="3" /></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_WordLength#}
	  <br />
	  <small>{#WordWrapInf#} </small>
	  </td>
      <td class="second"><input name="maxlengthword" type="text" id="maxlengthword" value="{$r.maxlengthword}" size="10" maxlength="3" /></td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_SysAvatars#}
	  <br />
	  <small>{#AvatarInf#} </small></td>
      <td class="second">
	  <input type="radio" name="SystemAvatars" value="1" {if $r.SystemAvatars==1}checked{/if} />{#Yes#}
      <input type="radio" name="SystemAvatars" value="0" {if $r.SystemAvatars==0}checked{/if} />{#No#}
	  </td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_BBCode#} </td>
      <td class="second">
	 <input type="radio" name="BBCode" value="1" {if $r.BBCode==1}checked{/if} />{#Yes#}
     <input type="radio" name="BBCode" value="0" {if $r.BBCode==0}checked{/if} />{#No#}
	 </td>
    </tr>
    <tr>
      <td width="220" class="first">{#S_Smilies#}</td>
      <td class="second">
<input type="radio" name="Smilies" value="1" {if $r.Smilies==1}checked{/if} />{#Yes#}
<input type="radio" name="Smilies" value="0" {if $r.Smilies==0}checked{/if} />{#No#}
</td>
    </tr>
    <tr>
      <td class="first">{#S_Posticons#}</td>
      <td class="second">
<input type="radio" name="Posticons" value="1" {if $r.Posticons==1}checked{/if} />{#Yes#}
<input type="radio" name="Posticons" value="0" {if $r.Posticons==0}checked{/if} />{#No#}
</td>
    </tr>
    <tr>
      <td class="second" colspan="2"><input type="submit" class="button" value="{#Save#}" /></td>
    </tr>
  </table>
  <br />

</form>