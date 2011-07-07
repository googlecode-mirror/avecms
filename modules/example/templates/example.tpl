<strong>{#EXAMPLE_TITLE#}</strong><br />
{foreach from=$example item=primer}
	<a href = "{$primer->document_alias}">{$primer->title}</a><br />
	<br />
{/foreach}