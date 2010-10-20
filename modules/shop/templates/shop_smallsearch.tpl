
<form method="post" action="{$ShopStartLink}">
	<input  value="{#ProductSArtTitle#}" onclick="this.value=''" onmouseout="if(this.value=='') this.value=''" class="inputbox" name="product_query" id="pq" type="text" value="{$smarty.post.product_query|default:''|stripslashes|escape:html}" />
	<select  class="inputbox"  name="manufacturer" id="mf">
		<option value="">{#ManufacturerA#}</option>
		{foreach from=$Manufacturer item=m}
			<option value="{$m->Id}" {if $smarty.post.manufacturer==$m->Id}selected="selected"{/if}>{$m->Name|stripslashes}</option>
		{/foreach}
	</select>
	<select class="inputbox" name="product_categ" id="pc">
		<option>{#ProductCategsAll#}</option>
		{foreach from=$ProductCategs item=pc}
			<option  class="inputbox" value="{$pc->Id}" {if $pc->parent_id == 0}style="font-weight:bold"{/if} {if $pc->Id==$smarty.post.product_categ||$pc->Id==$smarty.request.categx}selected="selected"{/if}>{$pc->visible_title}</option>
		{/foreach}
	</select><br />

	<input class="inputbox priceinput"   type="text" name="price_start" id="pfpt" value="{$smarty.post.price_start|stripslashes|escape:html|default:'1.00'}" /> -
	<input class="inputbox priceinput"  type="text" name="price_end" value="{$smarty.post.price_end|stripslashes|escape:html|default:'100000.00'}" /> {$Currency}
	<select class="inputbox" name="sort">
		<option value="time_desc"{if 'time_desc'==$smarty.post.sort}selected="selected"{/if}>{#SearchNewsestFirst#}</option>
		<option value="time_asc"{if 'time_asc'==$smarty.post.sort}selected="selected"{/if}>{#SeacrhOldestFirst#}</option>
		<option value="price_asc"{if 'price_asc'==$smarty.post.sort}selected="selected"{/if}>{#SearchPriceAsc#}</option>
		<option value="price_desc"{if 'price_desc'==$smarty.post.sort}selected="selected"{/if}>{#SearchPriceDesc#}</option>
	</select>
	<select  class="inputbox"  name="recordset" id="rs">
		{section name=recordset loop=25 step=5}
			{assign var=sel value=''}
			{if $smarty.request.recordset == ''}
				{if $smarty.section.recordset.index+5==10}
					{assign var=sel value='selected'}
				{/if}
			{else}
				{if $smarty.section.recordset.index+5==$smarty.request.recordset}
					{assign var=sel value='selected'}
				{/if}
			{/if}
			<option value="{$smarty.section.recordset.index+5}" {$sel}>{$smarty.section.recordset.index+5} {#Recordets#}</option>
		{/section}
	</select>
	<input type="submit" class="button" value="{#ButtonSearch#}" />
</form>
