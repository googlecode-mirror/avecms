<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ProductCategEEdit#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br />
<form action="index.php?do=modules&action=modedit&mod=download&moduleaction=edit_categ&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
  <tr>
  <td width="200" class="first">{#CatName#}</td>
  <td class="second">
    <input style="width:200px" type="text" name="KatName" value="{$row->KatName|stripslashes}">  </td>
  </tr>
  <tr>
    <td class="first">{#CatParent#}</td>
    <td class="second">
<select style="width:250px" name="Elter">
<option value="0">{#ProductCategsNoParent#}</option>
{foreach from=$Categs item=pc}
<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$smarty.request.Id}selected="selected"{/if}>{$pc->visible_title}</option>
{/foreach}
</select>	</td>
  </tr>
  <tr>
    <td class="first">{#CatDescr#}</td>
    <td class="second">
      <textarea style="width:90%; height:120px" name="KatBeschreibung">{$row->KatBeschreibung|escape:html|stripslashes}</textarea>    </td>
  </tr>
  <tr>
    <td width="200" class="first">
	{#Groups#}
	<br />
     <small>{#GroupInf#}</small>	 </td>
    <td class="second">
	<select name="Gruppen[]" size="8" multiple="multiple">
	{foreach from=$Groups item=g}
      <option value="{$g->Benutzergruppe}" {if $GruppenErlaubt}{if in_array($g->Benutzergruppe,$GruppenErlaubt)} selected="selected"{/if}{/if}>{$g->Name|stripslashes}</option>
	 {/foreach}
      </select>	  </td>
  </tr>
  
  <tr>
    <td class="first">{#CatPosi#}</td>
    <td class="second">
	<select name="Rang" id="Rang">
      {section name=r loop=100}
	  <option value="{$smarty.section.r.index+1}" {if $row->Rang==$smarty.section.r.index+1}selected="selected"{/if}>{$smarty.section.r.index+1}</option>
	  {/section}
    </select>
    </td>
  </tr>
  <tr>
    <td class="first">{#CatImg#}</td>
    <td class="second">
	{if $row->Bild}
	<img src="../modules/download/icons/{$row->Bild}" alt="" /><br />
	<input type="hidden" name="Old" value="{$row->Bild}" />
	{/if}
      <input name="Bild" type="file" id="Bild" />    </td>
  </tr>
</table>
<br />
<input class="button" type="submit" value="{#ButtonSave#}" />
</form>