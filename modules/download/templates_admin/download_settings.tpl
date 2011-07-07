<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#Settings#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=download&moduleaction=gosettings&cp={$sess}&pop=1&sub=save">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableborder">
  <tr>
  <td width="180" class="first">{#RecommendA#}</td>
  <td class="second">
   <label><input type="radio" name="Empfehlen" value="1" {if $row->Empfehlen=='1'}checked="checked"{/if}>{#Yes#}</label>
  <label><input type="radio" name="Empfehlen" value="0" {if $row->Empfehlen=='0'}checked="checked"{/if}>{#No#}</label>  </td>
  </tr>

  <tr>
    <td width="180" class="first">{#CommentsA#}</td>
    <td class="second">
	<label><input type="radio" name="Kommentare" value="1" {if $row->Kommentare=='1'}checked="checked"{/if}>{#Yes#}</label>
  <label><input type="radio" name="Kommentare" value="0" {if $row->Kommentare=='0'}checked="checked"{/if}>{#No#}</label>	
  </td>
    </tr>
  <tr>
    <td width="180" class="first">{#VoteA#}</td>
    <td class="second">
	<label><input type="radio" name="Bewerten" value="1" {if $row->Bewerten=='1'}checked="checked"{/if}>{#Yes#}</label>
  <label><input type="radio" name="Bewerten" value="0" {if $row->Bewerten=='0'}checked="checked"{/if}>{#No#}</label>	
  </td>
  </tr>
  <tr>
    <td width="180" class="first">{#SpamW#}
	<br />
	<small>
	{#SpamInf#}
	</small></td>
    <td class="second"><textarea name="Spamwoerter" cols="50" rows="20" id="Spamwoerter">{$row->Spamwoerter}</textarea></td>
  </tr>
  <tr>
  <td class="second" colspan="2"><input class="button" type="submit" value="{#ButtonSave#}"></td>
  </tr>
</table>
<br />


</form>
<p align="center">
<input class="button" type="button" onClick="window.close();" value="{#WinClose#}" />
</p>