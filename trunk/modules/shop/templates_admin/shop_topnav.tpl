<table border="0" cellpadding="2" cellspacing="1" width="100%" id="ModuleMenu">
	<tr>
		<td width="10%"{if $smarty.request.moduleaction=='1'}class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#ShopStart#}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='products'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=products&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='products'}{#Products#}{else}{#Products#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='product_categs'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=product_categs&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='product_categs'}{#ProductCategs#}{else}{#ProductCategs#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='manufacturer'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=manufacturer&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='manufacturer'}{#ProductManufacturers#}{else}{#ProductManufacturers#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='paymentmethods'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=paymentmethods&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='paymentmethods'}{#PaymentMethods#}{else}{#PaymentMethods#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='dataexport'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=dataexport&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='dataexport'}{#DataExport#}{else}{#DataExport#}{/if}</a></td>
	</tr>
	<tr>
		<td width="10%"{if $smarty.request.moduleaction=='settings'}class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=settings&cp={$sess}">&raquo;&nbsp;{#ShopSettings#}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='product_new'} class="over"{/if}><a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=product_new&cp={$sess}&pop=1','980','740','1','new_product');">&raquo;&nbsp;{if $smarty.request.moduleaction=='product_new'}{#ProductPNew#}{else}{#ProductPNew#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='new_categ'} class="over"{/if}><a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=new_categ&cp={$sess}&pop=1&Id=false','980','740','1','new_categ');">&raquo;&nbsp;{if $smarty.request.moduleaction=='new_categ'}{#ProductCategNewLink#}{else}{#ProductCategNewLink#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='customerdiscounts'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=customerdiscounts&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='customerdiscounts'}{#CustomerDiscounts#}{else}{#CustomerDiscounts#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='shipping'}class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=shipping&cp={$sess}">&raquo;&nbsp;{#SShipper#}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='shopimport'} class="over"{/if}><a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=shopimport&cp={$sess}&pop=1','980','780','1','shopimport');">&raquo;&nbsp;{#ImportNavi#}</a></td>
	</tr>
	<tr>
		<td width="10%"{if $smarty.request.moduleaction=='email_settings'}class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=email_settings&cp={$sess}">&raquo;&nbsp;{#EmailSettings#}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='showmoney'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=showmoney&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='showmoney'}{#ProductOrdersSShowMoney#}{else}{#ProductOrdersSShowMoney#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='variants_categories'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=variants_categories&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='variants_categories'}{#VariantsCats#}{else}{#VariantsCats#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='couponcodes'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=couponcodes&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='couponcodes'}{#CouponCodes#}{else}{#CouponCodes#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='timeshipping'}class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=timeshipping&cp={$sess}">&raquo;&nbsp;{#TimeShipping#}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='userimport'} class="over"{/if}><a href="javascript:void(0);" onclick="cp_pop('index.php?do=modules&action=modedit&mod=shop&moduleaction=userimport&cp={$sess}&pop=1','980','780','1','shopimport');">&raquo;&nbsp;{#ImportNaviUser#}</a></td>
	</tr>
	<tr>
		<td width="10%"{if $smarty.request.moduleaction=='helppages'}class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=helppages&cp={$sess}">&raquo;&nbsp;{#EditHelpPages#}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='showorders'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=showorders&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='showorders'}{#ProductOrdersShow#}{else}{#ProductOrdersShow#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='vatzones'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=vatzones&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='vatzones'}{#VatZones#}{else}{#VatZones#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='units'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=units&cp={$sess}">&raquo;&nbsp;{if $smarty.request.moduleaction=='units'}{#ProductUnits#}{else}{#ProductUnits#}{/if}</a></td>
		<td width="10%"{if $smarty.request.moduleaction=='settingsyml'} class="over"{/if}><a href="index.php?do=modules&action=modedit&mod=shop&moduleaction=settingsyml&cp={$sess}">&raquo;&nbsp;{#YML_ShopSettings#}</a></td>
		<td width="10%">&nbsp;</td>
	</tr>
</table>