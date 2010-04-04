
<!-- gallery.tpl -->
{strip}

{if $gallery->type_out == 3}
	<link rel="stylesheet" href="modules/gallery/templates/css/lightbox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="modules/gallery/templates/js/prototype.js"></script>
	<script type="text/javascript" src="modules/gallery/templates/js/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="modules/gallery/templates/js/lightbox.js"></script>

{elseif $gallery->type_out == 4}
	<link rel="stylesheet" href="modules/gallery/templates/css/lightview.css" type="text/css" media="screen" />
	<script type="text/javascript" src="modules/gallery/templates/js/prototype.js"></script>
	<script type="text/javascript" src="modules/gallery/templates/js/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="modules/gallery/templates/js/lightview.js"></script>

{elseif $gallery->type_out == 5}
	<script type="text/javascript" src="modules/gallery/templates/js/sexylightbox/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="modules/gallery/templates/js/sexylightbox/sexylightbox.v2.3.jquery.min.js"></script>
	<link rel="stylesheet" href="modules/gallery/templates/js/sexylightbox/sexylightbox.css" type="text/css" media="all" />
	{literal}
	<script type="text/javascript">
	$(document).ready(function(){
		SexyLightbox.initialize({color:'black', dir: 'modules/gallery/templates/js/sexylightbox/sexyimages'});
	});
	</script>
	{/literal}

{elseif $gallery->type_out == 6}
	<script type="text/javascript" src="modules/gallery/templates/js/highslide/highslide-with-gallery.js"></script>
	<link rel="stylesheet" type="text/css" href="modules/gallery/templates/js/highslide/highslide.css" />
	{literal}
	<script type="text/javascript">
	hs.graphicsDir = 'modules/gallery/templates/js/highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	// Add the controlbar
	if (hs.addSlideshow) hs.addSlideshow({
		//slideshowGroup: 'group',
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		}
	});
	</script>
	{/literal}

{elseif $gallery->type_out == 7}
	{$gallery->script_out}
{/if}

{if $gallery->show_description == 1}
	<h3>{$gallery->gallery_title|escape}</h3><br />
	{$gallery->gallery_description|escape}
{/if}

{foreach name=img from=$images item=image}
	<div class="galimages_border">
		<div class="mod_gal_imgcontainer">
			{if $gallery->show_title == 1}
				<div class="mod_gal_header">{$image.image_title|default:#NoTitle#|escape}</div>
			{/if}
			<div class="mod_gal_img">
				{assign var=description value=$image.image_description|default:#NoDescr#|escape}

				{if $gallery->type_out == 2}
					<a href="javascript:void(0);" onclick="galpop('index.php?module=gallery&amp;pop=1&amp;iid={$image.id}','gal','500','500','{if $image.image_type == 'video'}1{else}0{/if}')" title="{$description}">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->type_out == 3}
					<a href="modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" title="{$description}" rel="lightbox[group{$gallery->id}]">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->type_out == 4}
					<a href="modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" title="{$description}" rel="gallery[group{$gallery->id}]" class="lightview">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->type_out == 5}
					<a href="modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" title="{$description}" rel="sexylightbox[group{$gallery->id}]">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->type_out == 6}
					<a href="modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" onclick="return hs.expand(this)" class="highslide">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" title="{$description}" /></a>
				{elseif $gallery->type_out == 7}
					{$image.image_tpl}
				{else}
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" title="{$description}" />
				{/if}

				{if $gallery->show_size == 1}
					<div class="mod_gal_kbsize">{$image.image_size} kb</div>
				{/if}
			</div>
		</div>
	</div>

	{if $smarty.foreach.img.iteration % $gallery->image_on_line == 0}
		<div style="clear:both">&nbsp;</div>
	{/if}
{/foreach}

{if $smarty.foreach.img.total % $gallery->image_on_line != 0}
	<div style="clear:both">&nbsp;</div>
{/if}

<div class="container_pages_navigation">
	{$page_nav}
</div>

{if $more_images == 1}
	<br />
	<a href="javascript:void(0);" onclick="popup('index.php?module=gallery&amp;pop=1&amp;sub=allimages&amp;gallery={$gallery->id}&amp;theme_folder={$theme_folder}','comment','750','750','1');">{#MoreImages#}</a>
{/if}

{/strip}
<!-- /gallery.tpl -->
