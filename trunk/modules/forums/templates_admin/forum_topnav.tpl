<table border="0" cellpadding="2" cellspacing="1" width="100%" id="ModuleMenu">
  <tr>
    <td width="10%"{if $smarty.request.moduleaction=='1'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=1&amp;cp={$sess}">&raquo; {#ForumsView#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='delete_topics'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=delete_topics&cp={$sess}">&raquo;&nbsp;{#DelTopics#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='user_ranks'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=user_ranks&amp;cp={$sess}">&raquo;&nbsp;{#Ranks#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='import'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=import&amp;cp={$sess}">&raquo;&nbsp;{#Import#}</a></td>
  </tr>
  <tr>
    <td width="10%"{if $smarty.request.moduleaction=='group_perms'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=group_perms&amp;cp={$sess}">&raquo;&nbsp;{#Perm_GroupsAll#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='attachment_manager'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=attachment_manager&amp;cp={$sess}">&raquo;&nbsp;{#AttachManager#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='list_icons'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=list_icons&amp;cp={$sess}">&raquo;&nbsp;{#ListIoncs#}</a></td>
    <td width="10%">&nbsp;</td>
  </tr>
  <tr>
  <td width="10%"{if $smarty.request.moduleaction=='settings'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=settings&amp;cp={$sess}">&raquo;&nbsp;{#NavSettings#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='show_attachments'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=show_attachments&amp;cp={$sess}">&raquo;&nbsp;{#ShowAttachments#}</a></td>
    <td width="10%"{if $smarty.request.moduleaction=='list_smilies'}class="over"{/if}><a class="" style="margin-right:1px" href="index.php?do=modules&amp;action=modedit&amp;mod=forums&amp;moduleaction=list_smilies&amp;cp={$sess}">&raquo;&nbsp;{#Smilieys#}</a></td>
    <td width="10%">&nbsp;</td>
  </tr>
</table>