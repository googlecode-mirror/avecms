// initialisation
editAreaLoader.init({
	id: "template_text"	// id of the textarea to transform
	,start_highlight: true	// if start with highlight
	,show_line_colors: true
	,word_wrap: true
	,font_family: "verdana, monospace"
	,font_size: "10"
	,allow_toggle: false
	,language: "ru"
	,syntax: "html"
	,allow_resize: "y"
	,toolbar: "fullscreen, search, go_to_line, |, undo, redo, |, select_font, |, change_smooth_selection, highlight, reset_highlight, word_wrap, |, help"
//	,toolbar: "fullscreen, search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, word_wrap, |, help"
//	,syntax_selection_allow: "html,css,js,php,xml"
//	,allow_toggle: false
//	,display: "later"
});
function toogle_editable(id)
{
	editAreaLoader.execCommand(id, 'set_editable', !editAreaLoader.execCommand(id, 'is_editable'));
}