{strip}
<!-- shop_myorders.tpl -->
{if $smarty.session.user_id}
<ul>
<li><a href="index.php?module=shop&amp;action=myorders">{#OrderOverviewShowLink#}</a></li>
<li><a href="index.php?module=shop&amp;action=mydownloads">{#DownloadsOverviewShowLink#}</a></li>
{if $WishListActive==1}
<li><a href="{$WishListLink}" target="_blank">{#Wishlist#}</a> � <a class="tooltip"  title="{$config_vars.WishlistInf}" href="#">{#WhatsThat#}</a></li>
{/if}
</ul>
{/if}
<!-- /shop_myorders.tpl -->
{/strip}