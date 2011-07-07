function SymError(){return true;}
window.onerror = SymError;

tags = new Array();

function getarraysize(thearray){
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null)) return i;
	}
	return thearray.length;
}

function arraypush(thearray,value) {
	thearraysize = getarraysize(thearray);thearray[thearraysize] = value;
}

function arraypop(thearray) {
	thearraysize = getarraysize(thearray);retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];return retval;
}

function setmode(modevalue) {
	document.cookie = "cmscodemode="+modevalue+"; path=/; expires=Wed, 1 Jan 2100 00:00:00 GMT;";
}

function normalmode(theform) {
	return true;
}

function stat(thevalue) {
	document.bbform.status.value = eval(thevalue+"_text");
}

function setfocus(theform) {
	theform.text.focus();
}

var selectedText = "";
AddTxt = "";

function getActiveText(msg) {
	selectedText = (document.all) ? document.selection.createRange().text : window.getSelection();if (msg.createTextRange) msg.caretPos = document.selection.createRange().duplicate();return true;
}

function AddText(NewCode,theform) {
	if (theform.text.createTextRange && theform.text.caretPos) {
		var caretPos = theform.text.caretPos;caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? NewCode + ' ' : NewCode;
	} else theform.text.value+=NewCode

	AddTxt = "";setfocus(theform);
}

function unametofield(theuser) {
	opener.document.f.tofromname.value = '' + theuser + '';
	window.close();
}

var MessageMax  = "";
var Override    = "";
MessageMax      = parseInt(MessageMax);
if ( MessageMax < 0 ){
	MessageMax = 0;
}

var B_open = 0;
var I_open = 0;
var U_open = 0;
var QUOTE_open = 0;
var CODE_open = 0;
var PHP_open = 0;

var ktags = new Array();
var myAgent = navigator.userAgent.toLowerCase();
var myVersion = parseInt(navigator.appVersion);

var is_ie  = ((myAgent.indexOf("msie") != -1)       && (myAgent.indexOf("opera") == -1));
var is_nav = ((myAgent.indexOf('mozilla')!=-1)      && (myAgent.indexOf('spoofer') == -1)
           && (myAgent.indexOf('compatible') == -1) && (myAgent.indexOf('opera') == -1)
           && (myAgent.indexOf('webtv') ==-1)       && (myAgent.indexOf('hotjava') == -1));

var is_win = ((myAgent.indexOf("win") != -1) || (myAgent.indexOf("16bit") != -1));
var is_mac = (myAgent.indexOf("mac") != -1);

var allcookies = document.cookie;
var pos = allcookies.indexOf("kmode=");

prep_mode();

function prep_mode() {
	if (pos != 1) {
		var cstart = pos + 7;
		var cend   = allcookies.indexOf(";", cstart);
		if (cend == -1) { cend = allcookies.length; }
		cvalue = allcookies.substring(cstart, cend);

		if (cvalue == 'helpmode') {
			document.f.kmode[0].checked = true;
		} else {
			document.f.kmode[1].checked = true;
		}
	}
	else {
		document.f.kmode[1].checked = true;
	}
}

function setmode(mVal){
	document.cookie = "kmode="+mVal+"; path=/; expires=Wed, 1 Dez 2040 00:00:00 GMT;";
}

function normmodestat(){
	if (document.f.kmode[0].checked) {
		return true;
	}
	else {
		return false;
	}
}



function khelp(msg){
	document.f.khelp_msg.value = eval( "khelp_" + msg );
}

function stacksize(thearray){
	for (i = 0 ; i < thearray.length; i++ ) {
		if ( (thearray[i] == "") || (thearray[i] == null) || (thearray == 'undefined') ) {
			return i;
		}
	}

	return thearray.length;
}

function pushstack(thearray, newval){
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
	if (ktags[0]) {
		while (ktags[0]) {
			tagRemove = popstack(ktags)
			document.f.text.value += "[/" + tagRemove + "]";
			if ( (tagRemove != 'FONT') && (tagRemove != 'SIZE') && (tagRemove != 'COLOR') )
			{
				eval("document.f." + tagRemove + ".value = ' " + tagRemove + " '");
				eval(tagRemove + "_open = 0");
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


function changefont(theval, thetag){
    if (theval == 0)
    return;
		if(doInsert("[" + thetag + "=" + theval + "]", "[/" + thetag + "]", true))
		pushstack(ktags, thetag);
		document.f.ffont.selectedIndex  = 0;
    document.f.fsize.selectedIndex  = 0;
    document.f.fcolor.selectedIndex = 0;
}

function easytag(thetag)
{
	var tagOpen = eval(thetag + "_open");

	if ( normmodestat() ) {
		inserttext = prompt(prompt_start + "\n[" + thetag + "]xxx[/" + thetag + "]");
		if ( (inserttext != null) && (inserttext != "") ) {
			doInsert("[" + thetag + "]" + inserttext + "[/" + thetag + "] ", "", false);
		}
	}
	else {
		if (tagOpen == 0) {
			if(thetag == "PHP") {
				var openphp = '<?php ';
				var closephp = ' ?>';
			} else {
				var openphp = '';
				var closephp = '';
			}

			if(doInsert("[" + thetag + "]"+openphp+"", "[/" + thetag + "]", true)){
				eval(thetag + "_open = 1");
				eval("document.f." + thetag + ".value += '*'");
				pushstack(ktags, thetag);
				khelp('close');
			}
		}
		else {
			lastindex = 0;
			for (i = 0 ; i < ktags.length; i++ ) {
				if ( ktags[i] == thetag ) {
					lastindex = i;
				}
			}

			while (ktags[lastindex]) {
				if(thetag == "PHP") {
					var closephp = ' ?>';
				} else {
					var closephp = '';
				}
				tagRemove = popstack(ktags);
				doInsert(""+closephp+"[/" + tagRemove + "]", "", false)
				eval("document.f." + tagRemove + ".value = ' " + tagRemove + " '");
				eval(tagRemove + "_open = 0");
			}
		}
	}
}

function tag_list(){
	var listtype = prompt(list_prompt, "");

	if ((listtype == "a") || (listtype == "1") || (listtype == "i")) {
		thelist = "[LIST=" + listtype + "]\n";
	}
	else {
		thelist = "[LIST]\n";
	}
	var listentry = "initial";
	while ((listentry != "") && (listentry != null)) {
		listentry = prompt(list_prompt2, "");
		if ((listentry != "") && (listentry != null)) {
			thelist = thelist + "[*]" + listentry + "\n";
		}
	}
	doInsert(thelist + "[/LIST]\n", "", false);
}

function tag_url() {
    var FoundErrors = '';
    var enterURL   = prompt(text_enter_url, "http://");
    var enterTITLE = prompt(text_enter_url_name, "Webseiten-Name");

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }
    if (!enterTITLE) {
        FoundErrors += " " + error_no_title;
    }

    if (FoundErrors) {
        alert(""+FoundErrors);
        return;
    }
	doInsert("[URL="+enterURL+"]"+enterTITLE+"[/URL]", "", false);
}

function tag_image(){
    var FoundErrors = '';
    var enterURL   = prompt(text_enter_image, "http://");

    if (!enterURL) {
        FoundErrors += " " + error_no_url;
    }

    if (FoundErrors) {
        alert(""+FoundErrors);
        return;
    }

	doInsert("[IMG]"+enterURL+"[/IMG]", "", false);
}

function tag_email(){
    var emailAddress = prompt(text_enter_email, "");

    if (!emailAddress) {
		alert(error_no_email);
		return;
	}

	doInsert("[EMAIL]"+emailAddress+"[/EMAIL]", "", false);
}


function doInsert(ktag, kctag, once){
	var isClose = false;
	var obj_ta = document.f.text;

	if ( (myVersion >= 4) && is_ie && is_win) {
		if(obj_ta.isTextEdit){
			obj_ta.focus();
			var sel = document.selection;
			var rng = sel.createRange();
			rng.colapse;
			if((sel.type == "Text" || sel.type == "None") && rng != null){
				if(kctag != "" && rng.text.length > 0)
					ktag += rng.text + kctag;

				else if(once)
					isClose = true;

				rng.text = ktag;
			}
		}
		else{
			if(once)
				isClose = true;

			obj_ta.value += ktag;
			alert('MOZZ');
		}
	}
	else {
		if(once) {
			isClose = true;
		}

		// obj_ta.value += ktag;
		// Fix für Mozilla:
		// Fügt Tag an der gewünschten position ein!
		var tarea = document.getElementById('msgform');
    	var selEnd = tarea.selectionEnd;
    	var txtLen = tarea.value.length;
    	var txtbefore = tarea.value.substring(0,selEnd);
    	var txtafter =  tarea.value.substring(selEnd, txtLen);
		tarea.value = txtbefore + ktag + txtafter;
		obj_ta.value = tarea.value;
	}
	obj_ta.focus();
	return isClose;
}

function MWJ_findObj( oName, oFrame, oDoc ) {
	if( !oDoc ) {
        if( oFrame ) {
            oDoc = oFrame.document;
        } else {
            oDoc = window.document;
        }
    }

	if( oDoc[oName] ) {
        return oDoc[oName];
    }

    if( oDoc.all && oDoc.all[oName] ) {
        return oDoc.all[oName];
    }

	if( oDoc.getElementById && oDoc.getElementById(oName) ) {
        return oDoc.getElementById(oName);
    }

	for( var x = 0; x < oDoc.forms.length; x++ ) {
        if( oDoc.forms[x][oName] ) {
            return oDoc.forms[x][oName];
        }
    }

	for( var x = 0; x < oDoc.anchors.length; x++ ) {
        if( oDoc.anchors[x].name == oName ) {
            return oDoc.anchors[x];
        }
    }

	for( var x = 0; document.layers && x < oDoc.layers.length; x++ ) {
		var theOb = MWJ_findObj( oName, null, oDoc.layers[x].document );
        if( theOb ) {
            return theOb;
        }
    }

	if( !oFrame && window[oName] ) {
        return window[oName];
    }

    if( oFrame && oFrame[oName] ) {
        return oFrame[oName];
    }

	for( var x = 0; oFrame && oFrame.frames && x < oFrame.frames.length; x++ ) {
		var theOb = MWJ_findObj( oName, oFrame.frames[x], oFrame.frames[x].document );

        if( theOb ) {
            return theOb;
        }
    }

    return null;
}

function cpengine_toggleImage(oId, path) {
    var image = MWJ_findObj(oId);
    var imagePath = image.src.slice(0, image.src.lastIndexOf('/')+1);
    var imageName = image.src.slice(image.src.lastIndexOf('/')+1, image.src.length);

    if (imageName == 'minus.gif') {
        image.src = imagePath + 'plus.gif';
    } else {
        image.src = imagePath + 'minus.gif';
    }
}

function MWJ_retrieveCookie( cookieName ) {
	var cookieJar = document.cookie.split( "; " );
	for( var x = 0; x < cookieJar.length; x++ ) {
		var oneCookie = cookieJar[x].split( "=" );
		if( oneCookie[0] == escape( cookieName ) ) { return unescape( oneCookie[1] ); }
	}
	return null;
}

function cpengine_setCookie(name,value) {
	value = value+'@';

    // ein Jahr
    var lifeTime = 31536000;
	var currentStr = MWJ_retrieveCookie(name);

    if( !currentStr ) {
		//store the id
		MWJ_setCookie( name, value, lifeTime );
	} else if ( currentStr.indexOf(value)+1 ) {
		//delete from list of ids
		value = new RegExp(value,'');
		MWJ_setCookie(name, currentStr.replace(value,''), lifeTime);
	} else {
		//add to list of ids
		MWJ_setCookie(name, currentStr+value, lifeTime);
	}
}

function MWJ_setCookie( cookieName, cookieValue, lifeTime, path, domain, isSecure ) {
	if( !cookieName ) { return false; }
	if( lifeTime == "delete" ) { lifeTime = -10; }
	document.cookie = escape( cookieName ) + "=" + escape( cookieValue ) +
		( lifeTime ? ";expires=" + ( new Date( ( new Date() ).getTime() + ( 1000 * lifeTime ) ) ).toGMTString() : "" ) +
		( path ? ";path=" + path : "") + ( domain ? ";domain=" + domain : "") +
		( isSecure ? ";secure" : "");
	//check if the cookie has been set/deleted as required
	if( lifeTime < 0 ) { if( typeof( MWJ_retrieveCookie( cookieName ) ) == "string" ) { return false; } return true; }
	if( typeof( MWJ_retrieveCookie( cookieName ) ) == "string" ) { return true; } return false;
}

function cpengine_getCookie(name){
   var i=0  //Suchposition im Cookie
   var suche = name+"="
   while (i<document.cookie.length){
      if (document.cookie.substring(i, i+suche.length)==suche){
         var ende = document.cookie.indexOf(";", i+suche.length)
         ende = (ende>-1) ? ende : document.cookie.length
         var cook = document.cookie.substring(i+suche.length, ende)
         return unescape(cook)
      }
      i++
   }
   return null
}

function MWJ_changeDisplay( oName, oDisp, oFrame ) {
	var theDiv = MWJ_findObj( oName, oFrame );

    if( !theDiv ) { return; }

    if( theDiv.style ) {
        theDiv = theDiv.style;
    }

    if( typeof( oDisp ) == 'string' ) {
        oDisp = oDisp.toLowerCase();
    }

    theDiv.display = ( oDisp == 'none' ) ? 'none' : ( oDisp == 'block' ) ? 'block' : ( oDisp == 'inline' ) ? 'inline' : '';
}

function MWJ_getStyle( oName, oStyle, oFrame ) {
    if( oName == 'document' ) {
		var theBody = oFrame ? oFrame.document : window.document;

        if( theBody.documentElement && theBody.documentElement.style && theBody.documentElement.style.backgroundColor ) {
            return theBody.documentElement.style.backgroundColor;
        }

        if( theBody.body && theBody.body.style && theBody.body.style.backgroundColor ) {
            return theBody.body.style.backgroundColor;
        }

        if( theBody.documentElement && theBody.documentElement.style && theBody.documentElement.style.background ) {
            return theBody.documentElement.style.background;
        }

        if( theBody.body && theBody.body.style && theBody.body.style.background ) {
            return theBody.body.style.background;
        }

		if( theBody.bgColor ) {
            return theBody.bgColor;
        }

        return '#ffffff';
	}

	var theDiv = MWJ_findObj( oName, oFrame );

    if( !theDiv ) {
        return null;
    }

    if( theDiv.style && oStyle != 'clip' ) {
        theDiv = theDiv.style;
    }

    switch( oStyle ) {
		case 'visibility':
            return ( ( theDiv.visibility && !( theDiv.visibility.toLowerCase().indexOf( 'hid' ) + 1 ) ) ? true : false );
		case 'left':
			return ( parseInt( theDiv.left ) ? parseInt( theDiv.left ) : 0 );
		case 'top':
			return ( parseInt( theDiv.top ) ? parseInt( theDiv.top ) : 0 );
		case 'zIndex':
			return ( isNaN( theDiv.zIndex ) ? 0 : theDiv.zIndex );
		case 'background':
			return ( theDiv.bgColor ? theDiv.bgColor : theDiv.background-color ? theDiv.background-color : theDiv.background );
		case 'display':
            return ( theDiv.display ? theDiv.display : '' );
		case 'size':
			if( typeof( theDiv.pixelWidth ) != 'undefined' ) { return [theDiv.pixelWidth,theDiv.pixelHeight]; }
			if( typeof( theDiv.width ) != 'undefined' ) { return [parseInt(theDiv.width),theDiv.parseInt(height)]; }
			if( theDiv.clip && typeof( theDiv.clip.bottom ) == 'number' ) { return [theDiv.clip.right,theDiv.clip.bottom]; }
			return [0,0];
		case 'clip':
			if( theDiv.clip ) { return theDiv.clip; }
			theDiv = ( theDiv.style && theDiv.style.clip ) ? theDiv.style.clip : 'rect()';
			theDiv = theDiv.substr( theDiv.indexOf( '(' ) + 1 ); var theClip = new Object();
			for( var x = 0, y = ['top','right','bottom','left']; x < 4; x++ ) {
				theClip[y[x]] = parseInt( theDiv ); if( isNaN( theClip[y[x]] ) ) { theClip[y[x]] = 0; }
				theDiv = theDiv.substr( theDiv.indexOf( ( theDiv.indexOf( ' ' ) + 1 ) ? ' ' : ( theDiv.indexOf( '	' ) + 1 ) ? '	' : ',' ) + 1 );
			} return theClip;
		default:
			return null;
	}
}


function InsertCode(code,field_id,field_name) {
	var field_name = 'text';
	var field_id = 'msgform';
	if (document.getElementById(field_id).createTextRange){
		document.getElementById(field_id).focus();
		document.selection.createRange().duplicate().text = code;
	}
	else if (document.getElementById && !document.all) { // Mozilla
		var tarea = document.getElementById(field_id);
		var selEnd = tarea.selectionEnd;
		var txtLen = tarea.value.length;
		var txtbefore = tarea.value.substring(0,selEnd);
		var txtafter =  tarea.value.substring(selEnd, txtLen);
		tarea.value = txtbefore + code + txtafter;
	}
	else {
		document.entryform.field_name.value += code;
	}
}