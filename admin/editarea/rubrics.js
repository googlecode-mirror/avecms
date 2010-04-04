// initialisation
editAreaLoader.init({
	id: "RubrikTemplate"	// id of the textarea to transform
	,start_highlight: true	// if start with highlight
	,allow_toggle: true
	,language: "ru"
	,syntax: "html"
	,toolbar: "fullscreen, search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight"
	,syntax_selection_allow: "html,css,js,php,xml"
	,min_width: "400"
	,allow_resize: "no"
	,display: "later"
	,font_size: "8"
	,font_family: "verdana, monospace"
});

function toogle_editable(id)
{
	editAreaLoader.execCommand(id, 'set_editable', !editAreaLoader.execCommand(id, 'is_editable'));
}