{if $moredoc}
	<strong>{#MOREDOC_NAME#}</strong><br />
	{foreach from=$moredoc item=document}
		<a href = "{$document->document_alias}">{$document->title|escape}</a><br />
		{if $document->document_meta_description !=''}{$document->document_meta_description|escape}<br />{/if}
	{/foreach}
{/if}