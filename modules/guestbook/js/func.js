function SymError(){
	return true;
}
window.onerror = SymError;

function drucke(id,theme){
	// gibt eine Vorschau aus
	var html = document.getElementById(id).innerHTML;
	html = html.replace(/src="/gi, 'src="../' );
	html = html.replace(/&lt;/gi, '<' );
	html = html.replace(/&gt;/gi, '>' );
	var pFenster = window.open( '', null, 'height=600,width=780,toolbar=yes,location=yes,status=yes,menubar=yes,scrollbars=yes,resizable=yes' );
	var HTML = '<html><head></head><body style="font-family:arial,verdana;font-size:12px" onload="window.print()">'+html+'</body></html>';
	pFenster.document.write(HTML);
	pFenster.document.close();
}

function showhide(id,id2,text,text2){
	if (document.getElementById(id).style.display=="none"){
		document.getElementById(id).style.display="";
		document.getElementById(id2).innerHTML = text;
	}
	else{
		document.getElementById(id).style.display="none";
		document.getElementById(id2).innerHTML = text2;
	}
	return true;
}

function getFile(area,id){
	var winWidth = 500;
	var winHeight = 400;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?do=dl&p=downloadfile&area='+area+'&fileid='+id;
	var name = 'id';
	var features = 'menubar=yes,scrollbars=yes,toolbar=yes,resizable=yes,status=no,location=no,width='+winWidth+',height='+winHeight+',top='+h+',left='+w;
	window.open(url,name,features);
}

function getLink(area,id){
	var winWidth = 800;
	var winHeight = 600;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?do=dl&p=golink&area='+area+'&id='+id;
	var name = 'id';
	var features = 'menubar=yes,scrollbars=yes,toolbar=yes,resizable=yes,status=yes,location=yes,width='+winWidth+',height='+winHeight+',top='+h+',left='+w;
	window.open(url,name,features);
}

function helpwin(title,msg){
	var width="300", height="125";
	var left = (screen.width/2) - width/2;
	var top = (screen.height/2) - height/2;
	var styleStr = 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+',top='+top+',screenX='+left+',screenY='+top;
	var msgWindow = window.open("","msgWindow", styleStr);
	var head = '<head><title>'+title+'</title></head>';
	var body = '<center>'+msg+'<br><p><form><input type="button" value=" Done " onClick="self.close()"></form>';
	msgWindow.document.write(head+body);
}

function popex(url,name,width,height,center,resize,scroll,posleft,postop){
	if (posleft != 0) { x = posleft }
	if (postop != 0) { y = postop }
	if (!scroll) { scroll = 1 }
	if (!resize) { resize = 1 }
	if ((parseInt (navigator.appVersion) >= 4 ) && (center)){
		X = (screen.width - width ) / 2;
		Y = (screen.height - height) / 2;
	}
	if (scroll != 0) { scroll = 1 }
	var Win = window.open( url, name, 'width='+width+',height='+height+',top='+Y+',left='+X+',resizable='+resize+',scrollbars='+scroll+',location=no,directories=no,status=no,menubar=no,toolbar=no');
}

function popup(datei,name,breite,hoehe,srcoll){
	var posX=10;
	var posY=10;
	var scrolly = srcoll;
	var id = name;
	window.open(datei,name,"resizable=yes,scrollbars="+scrolly+" ,width="+breite+",height="+hoehe+"screenX="+posX+",screenY="+posY+",left="+posX+",top="+posY+"");
}

function enzypop(datei){
	var posX=10;
	var posY=10;
	var h=450;
	var w=500;
	window.open(datei,name,"resizable=yes,scrollbars=yes,width="+w+",height="+h+"screenX="+posX+",screenY="+posY+",left="+posX+",top="+posY+"");
}

function msgpop(datei,name,breite,hoehe,srcoll){
	var posX=(screen.availWidth-breite)/2;
	var posY=(screen.availHeight-hoehe)/2;
	var scrolly = srcoll;
	var id = name;
	window.open(datei,name,"scrollbars="+scrolly+",resizable=yes, width="+breite+",height="+hoehe+"screenX="+posX+",screenY="+posY+",left="+posX+",top="+posY+"");
}

function gbild(img_id,galid,area,ascdesc){
	var winWidth = 640;
	var winHeight = 480;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?p=gallerypic&img_id='+img_id+'&galid='+galid+'&area='+ area +'&ascdesc='+ascdesc+'#'+img_id;
	var name = 'name';
	var features = 'scrollbars=yes,resizable=yes,toolbar=yes,width='+winWidth+',height='+winHeight+',top='+h+',left='+w;
	window.open(url,name,features);
}

function inline_popup(img_id){
	var winWidth = 640;
	var winHeight = 480;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?p=misc&do=inlineshots&img_id='+img_id;
	var name = 'name';
	var features = 'scrollbars=yes,resizable=yes,toolbar=yes,width='+winWidth+',height='+winHeight+',top='+h+',left='+w;
	window.open(url,name,features);
}

tags = new Array();

function getarraysize(thearray){
	for (i=0;i<thearray.length;i++){
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null)) return i;
	}
	return thearray.length;
}

function arraypush(thearray,value){
	thearraysize = getarraysize(thearray);
	thearray[thearraysize] = value;
}

function arraypop(thearray){
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}

function setmode(modevalue){
	document.cookie = "cmscodemode="+modevalue+"; path=/; expires=Wed, 1 Jan 2100 00:00:00 GMT;";
}

function normalmode(theform){
	return true;
}

function stat(thevalue){
	document.bbform.status.value = eval(thevalue+"_text");
}

function setfocus(theform){
	theform.text.focus();
}

var selectedText = "";
AddTxt = "";

function getActiveText(msg){
	selectedText = (document.all) ? document.selection.createRange().text : window.getSelection();
	if (msg.createTextRange) msg.caretPos = document.selection.createRange().duplicate();
	return true;
}

function AddText(NewCode,theform){
	if (theform.text.createTextRange && theform.text.caretPos){
		var caretPos = theform.text.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? NewCode+' ' : NewCode;
	}
	else theform.text.value+=NewCode
	AddTxt = "";
	setfocus(theform);
}

function smilie(thesmilie){
	var ie = document.all ? 1 : 0;
	if (!ie){
		document.f.text.value += ' '+thesmilie+' '
	}
	else{
		AddSmile = " "+thesmilie+" ";
		theform = f;
		AddText(AddSmile,theform);
	}
}

function unametofield(theuser){
	opener.document.f.tofromname.value = ''+theuser+'';
	window.close();
}

var Override = "";
var MessageMax = "";
MessageMax = parseInt(MessageMax);
if ( MessageMax < 0 ) MessageMax = 0;
var B_open = 0;
var I_open = 0;
var U_open = 0;
var QUOTE_open = 0;
var CODE_open = 0;
var PHP_open = 0;
var ktags = new Array();
var myAgent = navigator.userAgent.toLowerCase();
var myVersion = parseInt(navigator.appVersion);
var is_ie = ((myAgent.indexOf("msie") != -1) && (myAgent.indexOf("opera") == -1));
var is_nav = ((myAgent.indexOf('mozilla')!=-1) && (myAgent.indexOf('spoofer')==-1)
	&& (myAgent.indexOf('compatible') == -1) && (myAgent.indexOf('opera')==-1)
	&& (myAgent.indexOf('webtv') ==-1) && (myAgent.indexOf('hotjava')==-1));
var is_win = ((myAgent.indexOf("win")!=-1) || (myAgent.indexOf("16bit")!=-1));
var is_mac = (myAgent.indexOf("mac")!=-1);
var allcookies = document.cookie;
var pos = allcookies.indexOf("kmode=");
prep_mode();

function prep_mode(){
	if (pos != 1){
		var cstart = pos+7;
		var cend = allcookies.indexOf(";", cstart);
		if (cend == -1){
			cend = allcookies.length;
		}
		cvalue = allcookies.substring(cstart, cend);
		if (cvalue == 'helpmode'){
			document.f.kmode[0].checked = true;
		}
		else{
			document.f.kmode[1].checked = true;
		}
	}
	else{
		document.f.kmode[1].checked = true;
	}
}

function setmode(mVal){
	document.cookie = "kmode="+mVal+"; path=/; expires=Wed, 1 Dez 2040 00:00:00 GMT;";
}

function normmodestat(){
	if (document.f.kmode[0].checked){
		return true;
	}
	else{
		return false;
	}
}

function khelp(msg){
	document.f.khelp_msg.value = eval( "khelp_"+msg );
}

function stacksize(thearray){
	for (i=0;i<thearray.length;i++){
		if ( (thearray[i] == "") || (thearray[i] == null) || (thearray == 'undefined') ){
			return i;
		}
	}
	return thearray.length;
}

function pushstack(thearray,newval){
	arraysize = stacksize(thearray);
	thearray[arraysize] = newval;
}

function popstack(thearray){
	arraysize = stacksize(thearray);
	theval = thearray[arraysize - 1];
	delete thearray[arraysize - 1];
	return theval;
}

function closeall(){
	if (ktags[0]){
		while (ktags[0]){
			tagRemove = popstack(ktags)
			document.f.text.value += "[/"+tagRemove+"]";
			if ( (tagRemove != 'FONT') && (tagRemove != 'SIZE') && (tagRemove != 'COLOR') ){
				eval("document.f."+tagRemove+".value = ' "+tagRemove+" '");
				eval(tagRemove+"_open = 0");
			}
		}
	}
	ktags = new Array();
	document.f.text.focus();
}

function add_code(NewCode){
	document.f.text.value += NewCode;
	document.f.text.focus();
}

function changefont(theval,thetag){
	if (theval == 0)
		return;
	if (doInsert("["+thetag+"="+theval+"]", "[/"+thetag+"]", true))
		pushstack(ktags, thetag);
	document.f.ffont.selectedIndex = 0;
	document.f.fsize.selectedIndex = 0;
	document.f.fcolor.selectedIndex = 0;
}

function easytag(thetag){
	var tagOpen = eval(thetag+"_open");
	if ( normmodestat() ){
		inserttext = prompt(prompt_start+"\n["+thetag+"]xxx[/"+thetag+"]");
		if ( (inserttext != null) && (inserttext != "") ){
			doInsert("["+thetag+"]"+inserttext+"[/"+thetag+"] ", "", false);
		}
	}
	else{
		if (tagOpen == 0){
			if (thetag == "PHP"){
				var openphp = '<?php ';
				var closephp = ' ?>';
			}
			else{
				var openphp = '';
				var closephp = '';
			}
			if (doInsert("["+thetag+"]"+openphp+"", "[/"+thetag+"]", true)){
				eval(thetag+"_open = 1");
				eval("document.f."+thetag+".value += '*'");
				pushstack(ktags, thetag);
				khelp('close');
			}
		}
		else{
			lastindex = 0;
			for (i=0;i<ktags.length;i++){
				if ( ktags[i] == thetag ){
					lastindex = i;
				}
			}
			while (ktags[lastindex]){
				if (thetag == "PHP"){
					var closephp = ' ?>';
				}
				else{
					var closephp = '';
				}
				tagRemove = popstack(ktags);
				doInsert(""+closephp+"[/"+tagRemove+"]", "", false)
				eval("document.f."+tagRemove+".value = ' "+tagRemove+" '");
				eval(tagRemove+"_open = 0");
			}
		}
	}
}

function tag_list(){
	var listtype = prompt(list_prompt, "");
	if ((listtype == "a") || (listtype == "1") || (listtype == "i")){
		thelist = "[LIST="+listtype+"]\n";
	}
	else{
		thelist = "[LIST]\n";
	}
	var listentry = "initial";
	while ((listentry != "") && (listentry != null)){
		listentry = prompt(list_prompt2, "");
		if ((listentry != "") && (listentry != null)){
			thelist = thelist+"[*]"+listentry+"\n";
		}
	}
	doInsert(thelist+"[/LIST]\n", "", false);
}

function tag_url(){
	var FoundErrors = '';
	var enterURL = prompt(text_enter_url, "http://");
	var enterTITLE = prompt(text_enter_url_name, "Название сайта");
	if (!enterURL){
		FoundErrors += " "+error_no_url;
	}
	if (!enterTITLE){
		FoundErrors += " "+error_no_title;
	}
	if (FoundErrors){
		alert(""+FoundErrors);
		return;
	}
	doInsert("[URL="+enterURL+"]"+enterTITLE+"[/URL]", "", false);
}

function tag_image(){
	var FoundErrors = '';
	var enterURL = prompt(text_enter_image, "http://");
	if (!enterURL){
		FoundErrors += " "+error_no_img;
	}
	if (FoundErrors){
		alert(""+FoundErrors);
		return;
	}
	doInsert("[IMG]"+enterURL+"[/IMG]", "", false);
}

function tag_email(){
	var emailAddress = prompt(text_enter_email, "");
	if (!emailAddress){
		alert(error_no_email);
		return;
	}
	doInsert("[EMAIL]"+emailAddress+"[/EMAIL]", "", false);
}

function doInsert(ktag,kctag,once){
	var isClose = false;
	var obj_ta = document.f.text;
	if ( (myVersion >= 4) && is_ie && is_win){
		if (obj_ta.isTextEdit){
			obj_ta.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			if ((sel.type == "Text" || sel.type == "None") && rng != null){
				if (kctag != "" && rng.text.length > 0)
					ktag += rng.text+kctag;
				else if (once)
					isClose = true;
				rng.text = ktag;
			}
		}
		else{
			if (once)
			isClose = true;
			obj_ta.value += ktag;
			//alert('MOZZ');
		}
	}
	else{
		if (once){
			isClose = true;
		}
		// obj_ta.value += ktag;
		// Fix fьr Mozilla:
		// Fьgt Tag an der gewьnschten position ein!
		var tarea = document.getElementById('post');
		var selEnd = tarea.selectionEnd;
		var txtLen = tarea.value.length;
		var txtbefore = tarea.value.substring(0,selEnd);
		var txtafter = tarea.value.substring(selEnd, txtLen);
		tarea.value = txtbefore+ktag+txtafter;
		obj_ta.value = tarea.value;
	}
	obj_ta.focus();
	return isClose;
}

function pnbox(){
	var winWidth = 580;
	var winHeight = 500;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?templateid=pn';
	var name = 'id';
	var features = 'scrollbars=yes,toolbar=yes,resizable=yes,width='+winWidth+',height='+winHeight+',top='+h+',left='+w;
	window.open(url,name,features);
}

function pnto(ato){
	var winWidth = 580;
	var winHeight = 500;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?templateid=pn&action=compose&an='+ato;
	var name = 'id';
	location.href = url;
}

function emailto(ato){
	var winWidth = 580;
	var winHeight = 400;
	var w = (screen.width - winWidth)/2;
	var h = (screen.height - winHeight)/2 - 60;
	var url = 'index.php?templateid=email&action=compose&an='+ato;
	var name = 'id';
	location.href = url;
}

function MM_callJS(jsStr){
	return eval(jsStr)
}

function MWJ_retrieveCookie( cookieName ){
	var cookieJar = document.cookie.split( "; " );
	for (var x=0;x<cookieJar.length;x++){
		var oneCookie = cookieJar[x].split( "=" );
		if ( oneCookie[0] == escape( cookieName ) ){
			return unescape( oneCookie[1] );
		}
	}
	return null;
}

function koobi4_setCookie(name,value){
	value = value+'@';
	var lifeTime = 31536000;
	var currentStr = MWJ_retrieveCookie(name);
	if ( !currentStr ){
		MWJ_setCookie( name, value, lifeTime );
	}
	else if ( currentStr.indexOf(value)+1 ){
		value = new RegExp(value,'');
		MWJ_setCookie(name, currentStr.replace(value,''), lifeTime);
	}
	else{
		MWJ_setCookie(name, currentStr+value, lifeTime);
	}
}

function MWJ_setCookie(cookieName,cookieValue,lifeTime,path,domain,isSecure){
	if ( !cookieName ){
		return false;
	}
	if ( lifeTime == "delete" ){
		lifeTime = -10;
	}
	document.cookie = escape( cookieName )+"="+escape( cookieValue ) +
		( lifeTime ? ";expires="+( new Date( ( new Date() ).getTime()+( 1000 * lifeTime ) ) ).toGMTString() : "" ) +
		( path ? ";path="+path : "")+( domain ? ";domain="+domain : "") +
		( isSecure ? ";secure" : "");
	if ( lifeTime < 0 ){
		if ( typeof( MWJ_retrieveCookie( cookieName ) ) == "string" ){
			return false;
		}
		return true;
	}
	if ( typeof( MWJ_retrieveCookie( cookieName ) ) == "string" ){
		return true;
	}
	return false;
}

var ie = document.all ? 1 : 0;

function high(kselect){
	if (ie){
		while (kselect.tagName != "TR"){
			kselect = kselect.parentElement;
		}
	}
	else{
		while (kselect.tagName != "TR"){
			kselect = kselect.parentNode;
		}
	}
}

function off(kselect){
	if (ie){
		while (kselect.tagName != "TR"){
			kselect = kselect.parentElement;
		}
	}
}

function changesel(kselect){
	if (kselect.checked){
		high(kselect);
	}
	else{
		off(kselect);
	}
}

function selall(kselect){
	var fmobj = document.kform;
	for (var i=0;i<fmobj.elements.length;i++){
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)){
			e.checked = fmobj.allbox.checked;
			if (fmobj.allbox.checked){
				high(e);
			}
			else{
				off(e);
			}
		}
	}
}

function CheckCheckAll(kselect){
	var fmobj = document.kform;
	var TotalBoxes = 0;
	var TotalOn = 0;
	for (var i=0;i<fmobj.elements.length;i++){
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox')){
			TotalBoxes++;
			if (e.checked){
				TotalOn++;
			}
		}
	}
	if (TotalBoxes==TotalOn){
		fmobj.allbox.checked=true;
	}
	else{
		fmobj.allbox.checked=false;
	}
}

function select_read(){
	var fmobj = document.kform;
	for (var i=0;i<fmobj.elements.length;i++){
		var e = fmobj.elements[i];
		if ((e.type=='hidden') && (e.value == 1) && (! isNaN(e.name) )){
			eval("fmobj.msgid_"+e.name+".checked=true;");
			high(e);
		}
	}
}

function desel(){
	var fmobj = document.kform;
	for (var i=0;i<fmobj.elements.length;i++){
		var e = fmobj.elements[i];
		if (e.type=='checkbox'){
			e.checked=false;
			off(e);
		}
	}
}