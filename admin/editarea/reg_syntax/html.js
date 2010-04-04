/*
* last update: 2006-08-24
*/

editAreaLoader.load_syntax["html"] = {
	'COMMENT_SINGLE' : {}
	,'COMMENT_MULTI' : {'<!--' : '-->'}
	,'QUOTEMARKS' : {1: "'", 2: '"'}
	,'KEYWORD_CASE_SENSITIVE' : false
	,'KEYWORDS' : {
	}
	,'OPERATORS' :[
    '[', ']'
	]
	,'DELIMITERS' :[
    '<', '>'
	]
	,'REGEXPS' : {
		'doctype' : {
			'search' : '()(<!DOCTYPE[^>]*>)()'
			,'class' : 'doctype'
			,'modifiers' : ''
			,'execute' : 'before' // before or after
		}
		,'body' : {
			'search' : '(<)(/?body[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'body'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'style' : {
			'search' : '(<)(/?style[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'style'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'form' : {
			'search' : '(<)(/?form[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'form'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'select' : {
			'search' : '(<)(/?select[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'select'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'input' : {
			'search' : '(<)(/?input[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'input'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'textarea' : {
			'search' : '(<)(/?textarea[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'textarea'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'option' : {
			'search' : '(<)(/?option[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'option'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'html' : {
			'search' : '(<)(/?html[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'html'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'meta' : {
			'search' : '(<)(/?meta[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'meta'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'link' : {
			'search' : '(<)(/?link[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'link'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'head' : {
			'search' : '(<)(/?head[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'head'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'title' : {
			'search' : '(<)(/?title[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'title'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'table' : {
			'search' : '(<)(/?table[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'table'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'tr' : {
			'search' : '(<)(/?tr[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'tr'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'td' : {
			'search' : '(<)(/?td[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'td'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'tbody' : {
			'search' : '(<)(/?tbody[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'tbody'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'script' : {
			'search' : '(<)(/?script[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'script'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'a' : {
			'search' : '(<)(/?a[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'a'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'img' : {
			'search' : '(<)(/?img[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'img'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'div' : {
			'search' : '(<)(/?div[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'div'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'br' : {
			'search' : '(<)(/?br[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'br'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'strong' : {
			'search' : '(<)(/?strong[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'strong'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'p' : {
			'search' : '(<)(/?p[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'p'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'em' : {
			'search' : '(<)(/?em[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'em'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'ul' : {
			'search' : '(<)(/?ul[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'ul'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'li' : {
			'search' : '(<)(/?li[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'li'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'small' : {
			'search' : '(<)(/?small[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'small'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
        ,'ol' : {
			'search' : '(<)(/?ol[^ \r\n\t>]*)([^>]*>)'
			,'class' : 'ol'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}
		,'tags' : {
			'search' : '(<)(/?[a-z][^ \r\n\t>]*)([^>]*>)'
			,'class' : 'tags'
			,'modifiers' : 'gi'
			,'execute' : 'before' // before or after
		}

		,'attributes' : {
			'search' : '( |\n|\r|\t)([^ \r\n\t=]+)(=)'
			,'class' : 'attributes'
			,'modifiers' : 'g'
			,'execute' : 'before' // before or after
		}
	}
	,'STYLES' : {
		'COMMENTS': 'color: #AAAAAA;'
		,'QUOTESMARKS': 'color: #0000ff;'
		,'KEYWORDS' : {
			}
		,'OPERATORS' : 'color: #FF0066;'
		,'DELIMITERS' : 'color: #707070;'
		,'REGEXPS' : {
			'attributes': 'color: #A3B876;'
			,'tags': 'color: #E62253;'
			,'doctype': 'color: #8DCFB5;'
			,'table': 'color: #008080;'
            ,'style': 'color: #ff00ff;'
			,'tr': 'color: #008080;'
			,'td': 'color: #008080;'
			,'tbody': 'color: #008080;'
			,'script': 'color: #800000;'
			,'a': 'color: #008000;'
			,'img': 'color: #800080;'
			,'div': 'color: #000080;'
            ,'strong': 'color: #000080;'
            ,'p': 'color: #000080;'
            ,'em': 'color: #000080;'
            ,'ul': 'color: #000080;'
            ,'li': 'color: #000080;'
            ,'ol': 'color: #000080;'
            ,'small': 'color: #000080;'
			,'br': 'color: #000080;'
			,'body': 'color: #000080;'
			,'meta': 'color: #000080;'
			,'html': 'color: #000080;'
			,'link': 'color: #000080;'
			,'title': 'color: #000080;'
			,'head': 'color: #000080;'
			,'form': 'color: #ff8000;'
			,'input': 'color: #ff8000;'
			,'textarea': 'color: #ff8000;'
			,'option': 'color: #ff8000;'
			,'select': 'color: #ff8000;'
			,'test': 'color: #00FF00;'
		}
	}
};
