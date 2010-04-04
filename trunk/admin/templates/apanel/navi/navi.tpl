{strip}

{if checkPermission('docs')}
	{include file='documents/nav.tpl'}
{/if}

{if checkPermission('rubriken') || checkPermission('rubs')}
	{include file='rubs/nav.tpl'}
{/if}

{if checkPermission('abfragen')}
	{include file='queries/nav.tpl'}
{/if}

{if checkPermission('navigation')}
	{include file='navigation/nav.tpl'}
{/if}

{if checkPermission('vorlagen') || checkPermission('vorlagen_multi') || checkPermission('vorlagen_loesch') || checkPermission('vorlagen_edit') || checkPermission('vorlagen_neu')}
	{include file='templates/nav.tpl'}
{/if}

{if checkPermission('modules')}
	{include file='modules/nav.tpl'}
{/if}

{if checkPermission('user')}
	{include file='user/nav.tpl'}
{/if}

{if checkPermission('group')}
	{include file='groups/nav.tpl'}
{/if}

{if checkPermission('gen_settings')}
	{include file='settings/nav.tpl'}
{/if}

{if checkPermission('dbactions')}
	{include file='dbactions/nav.tpl'}
{/if}

{if checkPermission('logs')}
	{include file='logs/nav.tpl'}
{/if}

{/strip}