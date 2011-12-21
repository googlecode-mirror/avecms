<script type="text/javascript" language="javascript">
$(document).ready(function(){ldelim}

	$('#cc').click(function(){ldelim}
		$('#ccc').html('');
		
		var param = $(".seesettings form").formSerialize();
		
		$.post(ave_path+'admin/index.php?do=settings&sub=clearcache&ajax=run', param, function(){ldelim}
			$('#cachesize').html('0 Kb');
			$('#ccc').html('Кэш очищен');
		{rdelim});
	{rdelim});

	$("#loading")
		.bind("ajaxSend", function(){ldelim}$(this).show();{rdelim})
		.bind("ajaxComplete", function(){ldelim}$(this).hide();{rdelim});
{rdelim});
</script>

	{if $log_svn}
		<div class='update-nag'>Вышела новая версия <a href="http://www.overdoze.ru/index.php?module=forums" target="_blank">{$smarty.const.APP_VERSION}</a>! <a href="http://websvn.avecms.ru" target="_blank">Рекомендуется обновиться</a>.<br>
			{foreach from=$log_svn item=log_svn}
				№<a href="http://websvn.avecms.ru/revision.php?repname=AVE.cms+2.09&path=/trunk/&rev={$log_svn.version}&isdir=1" target="_blank">{$log_svn.version}</a> ({$log_svn.author}): {$log_svn.comment} <br>
			{/foreach}
		</div>
	{/if}
	
<div class="pageHeaderTitle">
	<div class="h_start">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#MAIN_WELCOME#}</h2>
	</div>
	<div class="HeaderText">{#MAIN_WELCOME_INFO#}</div>
</div>
<div class="upPage">&nbsp;</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td valign="top">
			<table width="100%" border="0" cellpadding="5" cellspacing="5">
				<col width="50%">
				<col width="50%">
				<tr>
					<td>
						{if check_permission('documents')}
							<div id="docsTasks">
								<a href="index.php?do=docs&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_DOCUMENT#}</div>
									<div class="taskDescription">{#MAIN_LINK_DOC_TIPS#}</div>
								</a>
							</div>
						{else}
							<div id="docsTasks_no">
								<div class="taskTitle">{#MAIN_LINK_DOCUMENT#}</div>
								<div class="taskDescription">{#MAIN_LINK_DOC_TIPS#}</div>
							</div>
						{/if}
					</td>

					<td>
						{if check_permission('rubrics')}
							<div id="rubsTasks">
								<a href="index.php?do=rubs&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_RUBRICS#}</div>
									<div class="taskDescription">{#MAIN_LINK_RUBRIK_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="rubsTasks_no">
								<div class="taskTitle">{#MAIN_LINK_RUBRICS#}</div>
								<div class="taskDescription">{#MAIN_LINK_RUBRIK_TIP#}</div>
							</div>
						{/if}
					</td>
				</tr>

				<tr>
					<td>
						{if check_permission('request')}
							<div id="queryTasks">
								<a href="index.php?do=request&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_QUERYES#}</div>
									<div class="taskDescription">{#MAIN_LINK_REQUEST_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="queryTasks_no">
								<div class="taskTitle">{#MAIN_LINK_QUERYES#}</div>
								<div class="taskDescription">{#MAIN_LINK_REQUEST_TIP#}</div>
							</div>
						{/if}
					</td>

					<td>
						{if check_permission('navigation')}
							<div id="naviTasks">
								<a href="index.php?do=navigation&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_NAVIGATION#}</div>
									<div class="taskDescription">{#MAIN_LINK_NAVI_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="naviTasks_no">
								<div class="taskTitle">{#MAIN_LINK_NAVIGATION#}</div>
								<div class="taskDescription">{#MAIN_LINK_NAVI_TIP#}</div>
							</div>
						{/if}
					</td>
				</tr>

				<tr>
					<td>
						{if check_permission('template')}
							<div id="templTasks">
								<a href="index.php?do=templates&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_TEMPLATES#}</div>
									<div class="taskDescription">{#MAIN_LINK_TEMPLATES_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="templTasks_no">
								<div class="taskTitle">{#MAIN_LINK_TEMPLATES#}</div>
								<div class="taskDescription">{#MAIN_LINK_TEMPLATES_TIP#}</div>
							</div>
						{/if}
					</td>

					<td>
						{if check_permission('modules')}
							<div id="moduleTasks">
								<a href="index.php?do=modules&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_MODULES#}</div>
									<div class="taskDescription">{#MAIN_LINK_MODULES_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="moduleTasks_no">
								<div class="taskTitle">{#MAIN_LINK_MODULES#}</div>
								<div class="taskDescription">{#MAIN_LINK_MODULES_TIP#}</div>
							</div>
						{/if}
					</td>
				</tr>

				<tr>
					<td>
						{if check_permission('user')}
							<div id="userTasks">
								<a href="index.php?do=user&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_USERS#}</div>
									<div class="taskDescription">{#MAIN_LINK_USER_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="userTasks_no">
								<div class="taskTitle">{#MAIN_LINK_USERS#}</div>
								<div class="taskDescription">{#MAIN_LINK_USER_TIP#}</div>
							</div>
						{/if}
					</td>

					<td>
						{if check_permission('group')}
							<div id="groupTasks">
								<a href="index.php?do=groups&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_GROUPS#}</div>
									<div class="taskDescription">{#MAIN_LINK_UGROUP_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="groupTasks_no">
								<div class="taskTitle">{#MAIN_LINK_GROUPS#}</div>
								<div class="taskDescription">{#MAIN_LINK_UGROUP_TIP#}</div>
							</div>
						{/if}
					</td>
				</tr>

				<tr>
					<td>
						{if check_permission('gen_settings')}
							<div id="settTasks">
								<a href="index.php?do=settings&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_SETTINGS#}</div>
									<div class="taskDescription">{#MAIN_LINK_SETTINGS_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="settTasks_no">
								<div class="taskTitle">{#MAIN_LINK_SETTINGS#}</div>
								<div class="taskDescription">{#MAIN_LINK_SETTINGS_TIP#}</div>
							</div>
						{/if}
					</td>

					<td>
						{if check_permission('dbactions')}
							<div id="dbTasks">
								<a href="index.php?do=dbsettings&amp;cp={$sess}">
									<div class="taskTitle">{#MAIN_LINK_DATABASE#}</div>
									<div class="taskDescription">{#MAIN_LINK_DB_TIP#}</div>
								</a>
							</div>
						{else}
							<div id="dbTasks_no">
								<div class="taskTitle">{#MAIN_LINK_DATABASE#}</div>
								<div class="taskDescription">{#MAIN_LINK_DB_TIP#}</div>
							</div>
						{/if}
					</td>
				</tr>

				<tr>
					<td valign="top">
						{* <!-- STATISTIC --> *}
						<div id="statbox">
							<div class="title">{#MAIN_STAT#}</div><br />
							<div class="text">{#MAIN_STAT_DOCUMENTS#}</div>
							<div class="numeric">{$cnts.documents}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_RUBRICS#}</div>
							<div class="numeric">{$cnts.rubrics}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_QUERIES#}</div>
							<div class="numeric">{$cnts.request}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_TEMPLATES#}</div>
							<div class="numeric">{$cnts.templates}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_MODULES#}</div>
							<div class="numeric">{$cnts.modules_0+$cnts.modules_1}</div><br />
							<br />
							{if $cnts.modules_0}
								<div class="text">{#MAIN_STAT_MODULES_OFF#}</div>
								<div class="numeric">{$cnts.modules_0|default:0}</div><br />
								<br />
							{/if}
							<div class="text">{#MAIN_STAT_USERS#}</div>
							<div class="numeric">{$cnts.users_0+$cnts.users_1}</div><br />
							<br />
							{if $cnts.users_0}
								<div class="text">{#MAIN_STAT_USERS_WAIT#}</div>
								<div class="numeric">{$cnts.users_0|default:0}</div><br />
								<br />
							{/if}
						</div>
						<br />
					</td>

					<td valign="top">
						{* <!-- STATISTIC --> *}
						<div id="sysinfo">
							<div class="title">{#MAIN_STAT_SYSTEM_INFO#}</div><br />
							<div class="text">{#MAIN_STAT_AVE#}</div><div class="stat">{$smarty.const.APP_VERSION}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_PHP#}</div><div class="stat">{$php_version}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_MYSQL_VERSION#}</div><div class="stat">{$mysql_version}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_MYSQL#}</div><div class="stat">{$mysql_size}</div><br />
							<br />
							<div class="text">{#MAIN_STAT_CACHE#}</div><div id="cachesize" class="stat">{$cache_size}</div><br />
							<br />
							<div id="cc">&raquo;&nbsp; {#MAIN_STAT_CLEAR_CACHE#}</div>
							<div class="ajax">
								<div id="loading" style="display:none"><img src="{$tpl_dir}/js/jquery/images/ajax-loader-green.gif" border="0" /></div>
								<span id="ccc"></span>
							</div><br />	
								<div class="seesettings">
									<form style="clear:both; display:block; width:100%;">
										<label class="cursor"><input name="templateCacheClear" type="checkbox" value="1" checked="checked">&nbsp;Шаблоны</label><br>
										<label class="cursor"><input name="templateCompiledTemplateClear" type="checkbox" value="1" checked="checked">&nbsp;Страницы</label><br>
										<label class="cursor"><input name="moduleCacheClear" type="checkbox" value="1" checked="checked">&nbsp;Модули</label><br> 
										<label class="cursor"><input name="sqlCacheClear" type="checkbox" value="1" checked="checked">&nbsp;SQL запросы</label><br> 
										<label class="cursor"><input name="sessionClear" type="checkbox" value="1">&nbsp;Сессии</label>
									</form>
								</div>
							<br />
						</div><br />
					</td>
				</tr>
			</table>
		</td>

		<td valign="top">
			<table width="100%" border="0" cellpadding="5" cellspacing="5">
				<tr>
					<td>
						{* <!-- MODULES --> *}
						{if $modules && check_permission('modules')}
							<div id="activemodule">
								<div class="title">{#MAIN_QUICK_MODULE#}</div><br />
								{foreach from=$modules item=modul}
									<div class="text">
										&raquo;&nbsp;<a href="index.php?do=modules&action=modedit&mod={$modul->ModulPfad}&moduleaction=1&cp={$sess}">{$modul->ModulName}</a>
									</div><br />
									<br />
								{/foreach}
							</div>
						{/if}
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>