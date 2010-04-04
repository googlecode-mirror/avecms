<table border="0" cellpadding="2" cellspacing="1" id="ModuleMenu">
  <tr>
    <td width="10%"{if $smarty.request.moduleaction=='1'} class="over"{/if}><a class="" href="index.php?do=modules&amp;action=modedit&amp;mod=download&amp;moduleaction=1&amp;cp={$sess}">&raquo; {#ModStart#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='gosettings'} class="over"{/if}><a class="" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=gosettings&cp={$sess}&pop=1','980','740','1','settings');">&raquo; {#Settings#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='languages'} class="over"{/if}><a class="" href="#" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=languages&cp={$sess}&pop=1&Id=false','980','740','1','languages');">&raquo; {#Languages#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='payhist'} class="over"{/if}><a class="" href="index.php?do=modules&amp;action=modedit&amp;mod=download&amp;moduleaction=payhist&amp;cp={$sess}">&raquo; {#Pays#}</a></td>
  </tr>
  <tr>
    <td width="10%"{if $smarty.request.moduleaction=='categs'} class="over"{/if}><a class=""  href="index.php?do=modules&amp;action=modedit&amp;mod=download&amp;moduleaction=categs&amp;cp={$sess}">&raquo; {#NavCategs#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='overview'} class="over"{/if}><a class="" href="index.php?do=modules&amp;action=modedit&amp;mod=download&amp;moduleaction=overview&amp;cp={$sess}">&raquo; {#DownloadOverview#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='licenses'} class="over"{/if}><a class="" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=licenses&cp={$sess}&pop=1&Id=false','980','740','1','licenses');">&raquo; {#Licenses#}</a></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
    <td width="10%"{if $smarty.request.moduleaction=='new_categ'} class="over"{/if}><a class="" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=new_categ&cp={$sess}&pop=1&Id=false','980','740','1','new_categ');">&raquo; {#CategNew#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='new'} class="over"{/if}><a class="" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=new&cp={$sess}&pop=1','980','740','1','new_download');">&raquo; {#DownloadNew#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='systems'} class="over"{/if}><a class="" href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=download&moduleaction=systems&cp={$sess}&pop=1&Id=false','980','740','1','systems');">&raquo; {#Systems#}</a></td>
    <td width="10%">&nbsp;</td>
  </tr>
</table>