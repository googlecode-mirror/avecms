{if $moredoc}
	<strong>{#MOREDOC_NAME#}</strong><br />
	{foreach from=$moredoc item=document}
		<a href = "{$document->Url}">{$document->Titel|escape}</a><br />
		{if $document->MetaDescription !=''}{$document->MetaDescription|escape}<br />{/if}
	{/foreach}
{/if}