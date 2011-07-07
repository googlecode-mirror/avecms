{if $moredoc}
	<h3>{#MOREDOC_NAME#}</h3>
	<ul>
	{foreach from=$moredoc item=document}
		<li><a href = "{$document->document_link}">{$document->document_title|escape}</a><br />
		{if $document->document_meta_description !=''}{$document->document_meta_description|escape}<br />{/if}</li>
	{/foreach}
	</ul>
{/if}