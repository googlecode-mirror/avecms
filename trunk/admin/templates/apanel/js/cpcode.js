function helpwin(text) {
	var html = text;
	html = html.replace(/src="/gi, 'src="../' );
	html = html.replace(/&lt;/gi, '<' );
	html = html.replace(/&gt;/gi, '>' );
	var pFenster = window.open( '', null, 'height=400,width=600,toolbar=no,location=no,status=yes,menubar=no,scrollbars=yes,resizable=yes' ) ;
	var HTML = '<html><head></head><body style="font-family:verdana,arial;font-size:11px">' + html + '</body></html>' ;
	pFenster.document.write(HTML);
	pFenster.document.close();
}

function cp_pop(url, width, height, scrollbar, winname) {
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.8;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.8;
	if (typeof scrollbar=='undefined') var scrollbar=1;
	if (typeof winname=='undefined') var winname='pop';
	window.open(url,winname,'left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
}

function cp_imagepop(url, width, height, scrollbar) {
	if (typeof width=='undefined' || width=='') var width = screen.width * 0.8;
	if (typeof height=='undefined' || height=='') var height = screen.height * 0.8;
	if (typeof scrollbar=='undefined') var scrollbar=1;
	window.open('browser.php?typ=bild&mode=fck&target='+url+'','imgpop','left=0,top=0,width='+width+',height='+height+',scrollbars='+scrollbar+',resizable=1');
}

function cp_code(v, feldname, form) {
	if (document.selection) {
		var str = document.selection.createRange().text;
		document.getElementById(feldname).focus();
		var sel = document.selection.createRange();
		sel.text = "<" + v + ">" + str + "</" + v + ">";
		return;
	}
	else if (document.getElementById && !document.all) {
		var txtarea = document.forms[form].elements[feldname];
		var selLength = txtarea.textLength;
		var selStart = txtarea.selectionStart;
		var selEnd = txtarea.selectionEnd;
		if (selEnd == 1 || selEnd == 2)
		selEnd = selLength;
		var s1 = (txtarea.value).substring(0,selStart);
		var s2 = (txtarea.value).substring(selStart, selEnd)
		var s3 = (txtarea.value).substring(selEnd, selLength);
		txtarea.value = s1 + '<' + v + '>' + s2 + '</' + v + '>' + s3;
		return;
	}
	else {
		cp_insert('<' + v + '></' + v + '> ');
	}
}

function cp_tag(v, feldname, form) {
	if (document.selection) {
		var str = document.selection.createRange().text;
		document.getElementById(feldname).focus();
		var sel = document.selection.createRange();
		sel.text = "[" + v + "]" + str + "[/" + v + "]";
		return;
	}
	else if (document.getElementById && !document.all) {
		var txtarea = document.forms[form].elements[feldname];
		var selLength = txtarea.textLength;
		var selStart = txtarea.selectionStart;
		var selEnd = txtarea.selectionEnd;
		if (selEnd == 1 || selEnd == 2)
		selEnd = selLength;
		var s1 = (txtarea.value).substring(0,selStart);
		var s2 = (txtarea.value).substring(selStart, selEnd)
		var s3 = (txtarea.value).substring(selEnd, selLength);
		txtarea.value = s1 + '[' + v + ']' + s2 + '[/' + v + ']' + s3;
		return;
	}
	else {
		cp_insert('[' + v + '][/' + v + '] ');
	}
}

function cp_insert(what,feldname, form) {
	if (document.getElementById(feldname).createTextRange) {
		document.getElementById(feldname).focus();
		document.selection.createRange().duplicate().text = what;
	}
	else if (document.getElementById && !document.all) {
		var tarea = document.forms[form].elements[feldname];
		var selEnd = tarea.selectionEnd;
		var txtLen = tarea.value.length;
		var txtbefore = tarea.value.substring(0,selEnd);
		var txtafter =  tarea.value.substring(selEnd, txtLen);
		tarea.value = txtbefore + what + txtafter;
	}
	else {
		document.entryform.text.value += what;
	}
}

var ie  = document.all  ? 1 : 0;
function selall(kselect) {
	var fmobj = document.kform;
	for (var i=0;i<fmobj.elements.length;i++) {
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox') && (!e.disabled)) {
			e.checked = fmobj.allbox.checked;
		}
	}
}

function CheckCheckAll(kselect) {
	var fmobj = document.kform;
	var TotalBoxes = 0;
	var TotalOn = 0;
	for (var i=0;i<fmobj.elements.length;i++) {
		var e = fmobj.elements[i];
		if ((e.name != 'allbox') && (e.type=='checkbox')) {
			TotalBoxes++;
			if (e.checked) {
				TotalOn++;
			}
		}
	}
	if (TotalBoxes==TotalOn) {
		fmobj.allbox.checked=true;
	}
	else {
		fmobj.allbox.checked=false;
	}
}

function select_read() {
	var fmobj = document.kform;
	for (var i=0;i<fmobj.elements.length;i++) {
		var e = fmobj.elements[i];
		if ((e.type=='hidden') && (e.value == 1) && (! isNaN(e.name) )) {
			eval("fmobj.msgid_" + e.name + ".checked=true;");
		}
	}
}

function desel() {
	var fmobj = document.uactions;
	for (var i=0;i<fmobj.elements.length;i++) {
		var e = fmobj.elements[i];
		if (e.type=='checkbox') {
			e.checked=false;
		}
	}
}
	
(function($){$.fn.extend({limit:function(limit,element){var interval,f;var self=$(this);$(this).focus(function(){interval=window.setInterval(substring,100)});$(this).blur(function(){clearInterval(interval);substring()});substringFunction="function substring(){ var val = $(self).val();var length = val.length;if(length > limit){$(self).val($(self).val().substring(0,limit));}";if(typeof element!='undefined')substringFunction+="if($(element).html() != limit-length){$(element).html((limit-length<=0)?'0':limit-length);}";substringFunction+="}";eval(substringFunction);substring()}})})(jQuery);

$(document).ready(function(){

    //===== Очистка кэша =====//
	$(".clearCache").click( function() {
		$('#ccc').html('');
		
		$.post(ave_path+'admin/index.php?do=settings&sub=clearcache&ajax=run&templateCacheClear=1&templateCompiledTemplateClear=1&moduleCacheClear=1&sqlCacheClear=1', function(){
			$('#cachesize').html('0 Kb');
			$('#ccc').html('Кэш очищен');
			alert('Кэш очищен');
		});
	});	
});