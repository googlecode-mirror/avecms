<br />
<div class="mod_searchbox">
  <form method="get" action="/index.php">
    <input type="hidden" name="module" value="search" />
    <input style="width:350px" class="query" name="query" type="text" value="{$smarty.request.query|stripslashes|escape:html}" />
    <input type="submit" class="button" style="vertical-align: middle;" value="{#SEARCH_BUTTON#}" />
  <input title="{#SEARCH_HELP#}" type="button" class="button" style="vertical-align: middle;" value="?" />
   <br />

<div style="margin-top:5px">
<input style="border:0px" type="radio" name="ts" value="0" {if $smarty.request.ts==0 || !$smarty.request.ts}checked="checked"{/if} />{#SEARCH_IN_DESCRIPTION#}
<input style="border:0px" type="radio" name="ts" value="1" {if $smarty.request.ts==1}checked="checked"{/if} />{#SEARCH_IN_TITLE#}

<input style="border:0px" type="radio" name="or" value="0" {if $smarty.request.or==0 || !$smarty.request.or}checked="checked"{/if} />{#SEARCH_USE_AND#}
<input style="border:0px" type="radio" name="or" value="1" {if $smarty.request.or==1}checked="checked"{/if} />{#SEARCH_USE_OR#}
</div>
  </form>
</div>