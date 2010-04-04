<STRONG>{#EXAMPLE_TITLE#}</STRONG><BR />
{foreach from=$example item=primer}
<a href = "{$primer->Url}">{$primer->Titel}</a><BR /><BR />
{/foreach}