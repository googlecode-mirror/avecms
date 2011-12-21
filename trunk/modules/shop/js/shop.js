function shop_image_pop(text,t)
{
	var html = text;
	var title = t;
	html = html.replace(/src="/gi, 'src="../' );
	html = html.replace(/&lt;/gi, '<' );
	html = html.replace(/&gt;/gi, '>' );
	var pFenster = window.open( '', null, 'height=600,width=600,toolbar=no,location=no,status=yes,menubar=no,scrollbars=0,resizable=1' ) ;
	var HTML = '<html><head><title>' + title + '</title></head><body style="font-family:verdana,arial; text-align:center">' + html + '</body></html>' ;
	pFenster.document.write(HTML);
	pFenster.document.close();
}