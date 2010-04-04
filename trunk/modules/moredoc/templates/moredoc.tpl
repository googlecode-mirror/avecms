{if $moredoc}
<STRONG>{#MOREDOC_NAME#}</STRONG><BR />
{foreach from=$moredoc item=more}
<a href = "{$more->Url}">{$more->Titel}</a><BR />{if $more->MetaDescription !=''}{$more->MetaDescription}<BR />{/if}
{/foreach}
{/if}