{if $Empfehlen==1}
<a name="recommend"></a>
<h1>{#Recommend#}</h1>
<br />

{if $smarty.request.recommenOK==1}
<br />
<script>location.href='#recommend_thankyou'</script>
<a name="recommend_thankyou"></a>
<em><strong>{#RecommendThanks#}</strong></em>
{/if}
<p>

<script language="javascript" type="text/javascript">
function check_recommendForm()
{ldelim}
	if(document.getElementById('yE').value=='' || document.getElementById('yE').value.length < '5' || document.getElementById('yE').value.indexOf('@') == -1 )
	{ldelim}
		alert('{#Recommend_NoMail#}');
		document.getElementById('yE').focus();
		return false;
	{rdelim}
	if(document.getElementById('myE').value=='' || document.getElementById('myE').value.length < '5' || document.getElementById('myE').value.indexOf('@') == -1 )
	{ldelim}
		alert('{#Recommend_NoMyMail#}');
		document.getElementById('myE').focus();
		return false;
	{rdelim}
	if(document.getElementById('myN').value=='' || document.getElementById('myN').value.length < '3')
	{ldelim}
		alert('{#Recommend_NoMyName#}');
		document.getElementById('myN').focus();
		return false;
	{rdelim}
{rdelim}
</script>
<form method="post" onsubmit="return check_recommendForm();">

<label for="yE">{#EmailR#}</label>
<br />
<input id="yE" name="Email" type="text"  size="40" />
<br /> 
<label for="myE">{#EmailY#}</label><br />
<input id="myE" name="myEmail" type="text"  size="40"  />
<br />
<label for="myN">{#NameY#}</label><br />
<input id="myN" name="myName" type="text" size="40" />
<input type="hidden" name="fileaction" value="email" />
<input type="submit" class="button" value="{#ButtonSend#}" />
</form>
</p>
<div class="mod_download_spacer"></div>
{/if}