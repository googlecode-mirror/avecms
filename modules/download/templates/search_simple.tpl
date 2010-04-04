{literal}
<script type="text/javascript" language="javascript">
function createXMLHttpRequest() {

var ua;

if(window.XMLHttpRequest) {
    try {
      ua = new XMLHttpRequest();
    } catch(e) {
      ua = false;
    }
  } else if(window.ActiveXObject) {
    try {
      ua = new ActiveXObject("Microsoft.XMLHTTP");
    } catch(e) {
      ua = false;
    }
  }
  return ua;
}

var req = createXMLHttpRequest();

function sendRequest(id) {
 var code = document.getElementById('ajQuery').value;
 var kid = document.getElementById('ajSearchCateg').value;
 req.open('get', 'modules/download/ajax.search.php?content=' + code + '&kid=' + kid);
 
 req.onreadystatechange = handleResponse;
  req.send(null);
}

function handleResponse() {

  if(req.readyState == 4){
    var response = req.responseText;
    var update = new Array();

    if(response.indexOf('||' != -1)) {
      update = response.split('||');
      document.getElementById(update[0]).innerHTML = update[1];
    }
  }
  else
  alert("loading" + ajax.readyState);
}
{/literal}
</script>

<div class="mod_download_titlebar">{#SearchF#}</div>
<div class="mod_download_ajaxsearch_info">{#SearchInf#}</div>
<form>
<table width="100%" border="0" cellpadding="1" cellspacing="0" class="mod_download_ajaxsearchcontainer">

<tr>
  <td class="mod_download_ajaxsearchcontainer_td">{#Categ#}:</td>
  <td class="mod_download_ajaxsearchcontainer_td">
  <select onchange="sendRequest();"  id="ajSearchCateg" name="select" class="mod_download_ajaxsearchfield" >
  <option value="9999">{#All#}</option>
  {foreach from=$DLCategs item=dlc}
    <option value="{$dlc->Id}" {if $smarty.request.categ==$dlc->Id}selected="selected" {/if}>{$dlc->KatName}</option>
{/foreach}
  </select>
  </td>
</tr>
<tr>
<td class="mod_download_ajaxsearchcontainer_td">{#SearchW#}:</td>
<td class="mod_download_ajaxsearchcontainer_td"><input autocomplete="off" type="text" id="ajQuery" onkeyup="sendRequest();" onclick="sendRequest();" class="mod_download_ajaxsearchfield" /><span id="showDiv"></span></td>
</tr>
</table>

</form>