{if check_permission('docs')}
	{include file='documents/nav.tpl'}
{/if}

{if check_permission('rubriken') || check_permission('rubrics')}
	{include file='rubs/nav.tpl'}
{/if}

{if check_permission('request')}
	{include file='request/nav.tpl'}
{/if}

{if check_permission('navigation')}
	{include file='navigation/nav.tpl'}
{/if}

{if check_permission('template') || check_permission('template_multi') || check_permission('template_del') || check_permission('template_edit') || check_permission('template_new')}
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