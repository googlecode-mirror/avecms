
{strip}
<script type="text/javascript" language="javascript">
var req;
var timeout;

function handleError(message) {ldelim}alert("Error: "+message){rdelim}

function processReqChange()
{ldelim}
	try {ldelim}
		if (req.readyState == 4) {ldelim}
			/*clearTimeout(timeout);*/
			if (req.status == 200) {ldelim}
				var response = req.responseText;
				if(response.indexOf('||' != -1)) {ldelim}
					var update = new Array();
					update = response.split('||');
					document.getElementById(update[0]).innerHTML = update[1];
				{rdelim}
			{rdelim} else handleError(req.statusText);
		{rdelim}
	{rdelim} catch (e) {ldelim}{rdelim}
{rdelim}

function sendRequest()
{ldelim}
	req = null;
	if (window.XMLHttpRequest) {ldelim}
		try {ldelim}
			req = new XMLHttpRequest();
		{rdelim} catch (e) {ldelim}{rdelim}
	{rdelim} else if (window.ActiveXObject) {ldelim}
		try {ldelim}
			req = new ActiveXObject('Msxml2.XMLHTTP');
		{rdelim} catch (e) {ldelim}
			try {ldelim}
				req = new ActiveXObject('Microsoft.XMLHTTP');
			{rdelim} catch (e) {ldelim}{rdelim}
		{rdelim}
	{rdelim}

	if (req) {ldelim}
		var ajq = document.getElementById('ajQuery').value;
		var cid = document.getElementById('ajSearchCateg').value;
		req.open('GET', '{$BASE_PATH}modules/download/ajax.search.php?ajq=' + ajq + '&cid=' + cid, true);
		req.onreadystatechange = processReqChange;
		req.send(null);
		/*timeout = setTimeout(function(){ldelim} req.abort(); handleError("Time over") {rdelim}, 10000);*/
	{rdelim}
{rdelim}
</script>

<div class="mod_download_titlebar">{#SearchF#}</div>
<div class="mod_download_ajaxsearch_info">{#SearchInf#}</div>
<form>
	<table width="100%" border="0" cellpadding="1" cellspacing="0" class="mod_download_ajaxsearchcontainer">
		<tr>
			<td class="mod_download_ajaxsearchcontainer_td">{#Categ#}:</td>
			<td class="mod_download_ajaxsearchcontainer_td">
				<select onchange="sendRequest();"  id="ajSearchCateg" name="select" class="mod_download_ajaxsearchfield" >
					<option value="0">{#All#}</option>
					{foreach from=$DLCategs item=dlc}
						<option value="{$dlc->Id}" {if $smarty.request.categ==$dlc->Id}selected="selected" {/if}>{$dlc->KatName}</option>
					{/foreach}
				</select>
			</td>
		</tr>
		<tr>
			<td class="mod_download_ajaxsearchcontainer_td">{#SearchW#}:</td>
			<td class="mod_download_ajaxsearchcontainer_td">
				<input autocomplete="off" type="text" id="ajQuery" onkeyup="sendRequest();" onclick="sendRequest();" class="mod_download_ajaxsearchfield" />
				<span id="showDiv"></span>
			</td>
		</tr>
	</table>
</form>

{/strip}
