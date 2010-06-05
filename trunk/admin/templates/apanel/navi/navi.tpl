{if check_permission('docs')}
	{include file='documents/nav.tpl'}
{/if}

{if check_permission('rubriken') || check_permission('rubs')}
	{include file='rubs/nav.tpl'}
{/if}

{if check_permission('abfragen')}
	{include file='request/nav.tpl'}
{/if}

{if check_permission('navigation')}
	{include file='navigation/nav.tpl'}
{/if}

{if check_permission('vorlagen') || check_permission('vorlagen_multi') || check_permission('vorlagen_loesch') || check_permission('vorlagen_edit') || check_permission('vorlagen_neu')}
	{include file='templates/nav.tpl'}
{/if}

{if check_permission('modules')}
	{include file='modules/nav.tpl'}
{/if}

{if check_permission('user')}
	{include file='user/nav.tpl'}
{/if}

{if check_permission('group')}
	{include file='groups/nav.tpl'}
{/if}

{if check_permission('gen_settings')}
	{include file='settings/nav.tpl'}
{/if}

{if check_permission('dbactions')}
	{include file='dbactions/nav.tpl'}
{/if}

{if check_permission('logs')}
	{include file='logs/nav.tpl'}
{/if}