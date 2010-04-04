<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#DlEdit#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div>
<br />

<form action="index.php?do=modules&action=modedit&mod=download&moduleaction=edit&cp={$sess}&pop=1&Id={$smarty.request.Id}&sub=save" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
  <tr>
  <td width="150" class="first">{#DlName#}</td>
  <td class="second">
    <input style="width:300px" type="text" name="Name" value="{$row->Name|stripslashes}">  </td>
  </tr>
  <tr>
    <td width="150" class="first">{#DlCategory#}</td>
    <td class="second">
<select style="width:300px" name="KatId">
<option value="0">{#ProductCategsNoParent#}</option>
{foreach from=$Categs item=pc}
<option value="{$pc->Id}" {if $pc->Elter == 0}style="font-weight:bold"{/if} {if $pc->Id==$row->KatId}selected="selected"{/if}>{$pc->visible_title}</option>
{/foreach}
</select>	</td>
  </tr>
  <tr>
  <td width="150" class="first">{#ActiveInactive#}</td>
  <td class="second">
  <label><input name="Aktiv" type="radio" value="1" {if $row->Aktiv==1}checked="checked"{/if} />{#Yes#}</label>

 <label><input name="Aktiv" type="radio" value="0" {if $row->Aktiv==0}checked="checked"{/if} />{#No#}	</label>  </td>
  </tr>
  <tr>
    <td colspan="2" class="tableheader">{#FirstM#}</td>
    </tr>
  <tr>
    <td colspan="2" class="first"><em>{#FirstMInf#}</em></td>
    </tr>
  <tr>
    <td class="first">{#FileLocal#}</td>
    <td class="second"><input style="width:300px" name="Pfad" type="text" id="Pfad" value="{if $row->Methode!='http'}{$row->Pfad}{/if}" />
      <select onchange="if(this.value != '')document.getElementById('Pfad').value=this.value" name="file_choicer" id="file_choicer">
        <option></option>
		{$LocalFiles}
      </select>      </td>
  </tr>
  <tr>
    <td class="first">{#FileLocalNew#}</td>
    <td class="second"><input name="file_local" type="file" id="file_local" /></td>
  </tr>
  <tr>
    <td colspan="2" class="tableheader">{#SecondM#}</td>
    </tr>
  <tr>
    <td colspan="2" class="first"><em>{#SecondMInf#}</em></td>
    </tr>
  <tr>
    <td class="first">{#FileExt#}</td>
    <td class="second">
	<div style="display: none;" id="span_feld__Pfad2">&nbsp;</div>
	<input style="width:300px" name="Pfad2" type="text" id="Pfad2" value="{if $row->Methode=='http'}{$row->Pfad}{/if}" />
      <input onClick="window.open('browser.php?typ=bild&mode=fck&target=Pfad2&fillout=dl','','height=700,widh=400')"  type="button" class="button" value="{#Mediapool#}" />	  </td>
  </tr>

   <tr>
    <td class="first">{#FileExtSize#}</td>
    <td class="second"><input name="FileSize" type="text" id="FileSize" value="{if $row->Methode=='http'}{$row->Groesse}{/if}" />kb</td>
  </tr>
     <tr>
    <td colspan="2" class="tableheader">{#FileMirrors#}</td>
    </tr>

  <tr>
    <td class="first">{#FileMirrorsInf#}</td>
    <td class="second"><textarea style="width:300px" name="Mirrors" rows="5">{$row->Mirrors}</textarea></td>
  </tr>
  <tr>
    <td colspan="2" class="tableheader">{#DlDescr#}</td>
    </tr>
  <tr>
    <td colspan="2" class="second"> {$row->FCK_Beschreibung} </td>
    </tr>
   <tr>
    <td colspan="2" class="tableheader">{#Limits#}</td>
    </tr>
  <tr>
    <td colspan="2" class="second">{$row->FCK_Limits}</td>
    </tr>

  <tr>
    <td width="150" class="first">{#DlLang#} / {#Systems#}</td>
    <td class="second">
	<select style="width:200px" name="Sprache[]" size="8" multiple>
      {foreach from=$Languages item=l}
	  <option value="{$l->Id}" {if in_array($l->Id,$DlLanguages)}selected="selected"{/if}>{$l->Name}</option>
	  {/foreach}
    </select>
	<select style="width:200px" name="Os[]" size="8" multiple>
      {foreach from=$Systeme item=o}
	  <option value="{$o->Id}" {if in_array($o->Id,$DlOs)}selected="selected"{/if}>{$o->Name}</option>
	  {/foreach}
    </select>	</td>
  </tr>



  <tr>
    <td class="first">{#Version#}</td>
    <td class="second"><input style="width:300px" type="text" name="Version" value="{$row->Version|stripslashes}"></td>
  </tr>
  <tr>
    <td class="first">{#License#}</td>
    <td class="second"><select style="width:200px" name="Lizenz" id="Lizenz">
	{foreach from=$Licenses item=l}
      <option value="{$l->Id}" {if $row->Lizenz==$l->Id}selected="selected" {/if}>{$l->Name|stripslashes}</option>
	  {/foreach}
    </select>    </td>
  </tr>
  <tr>
    <td class="first">{#LicenseC#}</td>
    <td class="second"><input style="width:300px" type="text" name="RegGebuehr" value="{$row->RegGebuehr|stripslashes}"></td>
  </tr>
  <tr>
    <td class="first">{#Manufacturer#}</td>
    <td class="second"><input style="width:300px" type="text" name="Autor" value="{$row->Autor|stripslashes}"></td>
  </tr>
   <tr>
     <td class="first">{#Screenshot#}</td>
     <td class="second">{if $row->Screenshot != ''}<img id="_img_feld__1" src="../{$row->Screenshot}" /><br /><br />
      {/if}
<div id="feld_1"><img id="_img_feld__1" src="templates/apanel/images/blanc.gif" alt="" border="0" /></div>
<div style="display:none" id="span_feld__1">&nbsp;</div>
<input type="text" style="width:400px" name="Screenshot" value="{$row->Screenshot}" id="img_feld__1" />
<input value="{#Mediapool#}" class="button" type="button" onclick="cp_imagepop('img_feld__1','','','0');" /> </td>
   </tr>
   <tr>
    <td class="first">{#ManufacturerURL#}</td>
    <td class="second"><input style="width:300px" type="text" name="AutorUrl" id="web" value="{$row->AutorUrl|stripslashes}">
	<input type="button" class="button" onclick="window.open(document.getElementById('web').value)" value="{#URICheck#}" />	</td>
  </tr>

  <tr>
    <td class="first">{#Downloads#}</td>
    <td class="second"><input name="Downloads" type="text" id="FileSize" value="{$row->Downloads}" /></td>
  </tr>
    <tr>
    <td class="first">{#DownloadsMaxDay#}</td>
    <td class="second"><input name="Downloads_Max" type="text" id="Downloads_Max" value="{$row->Downloads_Max|default:0}" />{#DownloadsE#} </td>
  </tr>

  <tr>
    <td class="first">{#VoteAllowed#}</td>
    <td class="second">
	<input name="Wertungen_ja" type="radio" id="Wertungen_ja" value="1" {if $row->Wertungen_ja==1}checked="checked"{/if} />{#Yes#}
	<input name="Wertungen_ja" type="radio" id="Wertungen_ja" value="0" {if $row->Wertungen_ja==0}checked="checked"{/if} />{#No#}	</td>
  </tr>

    <tr>
    <td class="first">{#CommentsAlowed#}</td>
    <td class="second">
	<input name="Kommentar_ja" type="radio" value="1" {if $row->Kommentar_ja==1}checked="checked"{/if} />{#Yes#}
	<input name="Kommentar_ja" type="radio" value="0" {if $row->Kommentar_ja==0}checked="checked"{/if} />{#No#}	</td>
  </tr>


  <tr>
    <td class="first">{#ResetVotes#}</td>
    <td class="second">
	<input name="ResetVote" type="checkbox" id="ResetVote" value="1" />{#Yes#}	</td>
  </tr>
  <tr>
    <td class="first">{#DelComments#}</td>
    <td class="second"><input name="DelComments" type="checkbox" id="DelComments" value="1" />
      {#Yes#} </td>
  </tr>

  <tr>
    <td width="150" class="first">{#RedVote#}</td>
    <td class="second"><select name="Wertung" id="Wertung">
	<option value="">{#NoVote#}</option>
	{section name=w loop=5}
      <option value="{$smarty.section.w.index+1}" {if $row->Wertung==$smarty.section.w.index+1}selected="selected" {/if}>{$smarty.section.w.index+1} </option>
	 {/section}
    </select> {#RedVoteInf#}    </td>
  </tr>
  <tr>
    <td class="first">{#DlPrice#}</td>
    <td class="second"><input name="Pay" type="text" id="pay_count" value="{$row->Pay}" /></td>
  </tr>
    <tr>
    <td class="first">{#DlMoney#}</td>
    <td class="second">
	<input name="valuta" type="radio" value="0" {if $row->Pay_val==0}checked="checked"{/if}/>$
	<input name="valuta" type="radio" value="1" {if $row->Pay_val==1}checked="checked"{/if}/>{#DlRub#}	</td>
  </tr>
  <tr>
    <td class="first">{#DlMorePay#}</td>
    <td class="second">
		<input name="Pay_Type" type="radio" value="0" {if $row->Pay_Type==0}checked="checked"{/if}/>{#DlUp#}
		<input name="Pay_Type" type="radio" value="1" {if $row->Pay_Type==1}checked="checked"{/if}/>{#DlOnePay#}</td>
  </tr>
  <tr>
    <td class="first">{#DlOnlyPayOk#}</td>
    <td class="second">
		<input name="Only_Pay" type="radio" value="1" {if $row->Only_Pay==1}checked="checked"{/if}/>{#Yes#}
		<input name="Only_Pay" type="radio" value="0" {if $row->Only_Pay==0}checked="checked"{/if}/>{#No#}</td>
  </tr>
  <tr>
    <td class="first">{#DlVipPayFull#}</td>
    <td class="second">
		<input name="Excl_Pay" type="radio" value="1" {if $row->Excl_Pay==1}checked="checked"{/if}/>{#Yes#}
		<input name="Excl_Pay" type="radio" value="0" {if $row->Excl_Pay==0}checked="checked"{/if}/>{#No#}
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{#DlSales#} <input name="Excl_Chk" type="checkbox" {if $row->Excl_Chk==1}checked="checked"{/if}>
		</td>
  </tr>
  <tr>
    <td class="second" colspan="2"><input class="button" type="submit" value="{#ButtonSave#}" /></td>
  </tr>
</table>
<br />
</form>