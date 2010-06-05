<script language="javascript">
function OrderPrint(id){ldelim}
	var html=document.getElementById(id).innerHTML;
	html=html.replace(/&lt;/gi, '<');
	html=html.replace(/&gt;/gi, '>');
	html=html.replace(/&amp;/gi, '&');
	var pFenster = window.open('', null, 'height=600,width=780,toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes');
	var HTML = '<body onload="print();">'+html;
	pFenster.document.write(HTML);
	pFenster.document.close();
{rdelim}
</script>

<div id="content">
	<div class="mod_shop_topnav"> <a class="mod_shop_navi" href="{$ShopStartLink}">{#PageName#}</a> {#PageSep#} {#OrderOkNav#} </div>
	{include file="$mod_dir/shop/templates/shop_bar.tpl"}<br />
	<br />
	<h2 id="page-heading">{#OrderPrintM1#}</h2>
	<p>{#OrderPrintM2#}<br />
	<br />
	<div id="{$smarty.session.TransId}" style="display:none">{$innerhtml}</div>
	&gt;&gt; <a href="javascript:OrderPrint('{$smarty.session.TransId}');">{#OrderPrint#}</a></p>

	<!-- FOOTER -->
	{$FooterText}
</div>

{if $smarty.request.print!=1}
	<div class="leftnavi">
		{$ShopNavi}
		<div style="clear:both"></div>
		{$Search}
		{$Basket}
		{$UserPanel}
		{$MyOrders}
		{$Topseller}
		{$InfoBox}
	</div>
{/if}
<div style="clear:both"></div>