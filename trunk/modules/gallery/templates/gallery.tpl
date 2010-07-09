{if $gallery->gallery_type == 3}
	<link rel="stylesheet" href="{$ABS_PATH}modules/gallery/templates/css/lightbox.css" type="text/css" media="screen" />
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/prototype.js"></script>
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/lightbox.js"></script>

{elseif $gallery->gallery_type == 4}
	<link rel="stylesheet" href="{$ABS_PATH}modules/gallery/templates/css/lightview.css" type="text/css" media="screen" />
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/prototype.js"></script>
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/scriptaculous.js?load=effects"></script>
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/lightview.js"></script>

{elseif $gallery->gallery_type == 5}
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/sexylightbox/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/sexylightbox/sexylightbox.v2.3.jquery.min.js"></script>
	<link rel="stylesheet" href="{$ABS_PATH}modules/gallery/templates/js/sexylightbox/sexylightbox.css" type="text/css" media="all" />
	<script type="text/javascript">
	$(document).ready(function(){ldelim}
		SexyLightbox.initialize({ldelim}color:'black', dir: '{$ABS_PATH}modules/gallery/templates/js/sexylightbox/sexyimages'{rdelim});
	{rdelim});
	</script>

{elseif $gallery->gallery_type == 6}
	<script type="text/javascript" src="{$ABS_PATH}modules/gallery/templates/js/highslide/highslide-with-gallery.js"></script>
	<link rel="stylesheet" type="text/css" href="{$ABS_PATH}modules/gallery/templates/js/highslide/highslide.css" />
	<script type="text/javascript">
	hs.graphicsDir = '{$ABS_PATH}modules/gallery/templates/js/highslide/graphics/';
	hs.align = 'center';
	hs.transitions = ['expand', 'crossfade'];
	hs.outlineType = 'rounded-white';
	hs.fadeInOut = true;
	hs.numberPosition = 'caption';
	hs.dimmingOpacity = 0.75;

	/* Add the controlbar */
	if (hs.addSlideshow) hs.addSlideshow({ldelim}
		/*slideshowGroup: 'group',*/
		interval: 5000,
		repeat: false,
		useControls: true,
		fixedControls: 'fit',
		overlayOptions: {ldelim}
			opacity: .75,
			position: 'bottom center',
			hideOnMouseOut: true
		{rdelim}
	{rdelim});
	</script>

{elseif $gallery->gallery_type == 7}
	{$gallery->gallery_script}
{/if}

{if $gallery->gallery_description_show == 1}
	<h3>{$gallery->gallery_title|escape}</h3><br />
	{$gallery->gallery_description|escape}
{/if}

{foreach name=img from=$images item=image}
	<div class="galimages_border">
		<div class="mod_gal_imgcontainer">
			{if $gallery->gallery_title_show == 1}
				<div class="mod_gal_header">{$image.image_title|default:#NoTitle#|escape}</div>
			{/if}
			<div class="mod_gal_img">
				{assign var=description value=$image.image_description|default:#NoDescr#|escape}

				{if $gallery->gallery_type == 2}
					<a href="javascript:void(0);" onclick="galpop('{$ABS_PATH}index.php?module=gallery&amp;pop=1&amp;image={$image.id}','gal','500','500','{if $image.image_type == 'video'}1{else}0{/if}')" title="{$description}">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->gallery_type == 3}
					<a href="{$ABS_PATH}modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" title="{$description}" rel="lightbox[group{$gallery->id}]">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->gallery_type == 4}
					<a href="{$ABS_PATH}modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" title="{$description}" rel="gallery[group{$gallery->id}]" class="lightview">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->gallery_type == 5}
					<a href="{$ABS_PATH}modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" title="{$description}" rel="sexylightbox[group{$gallery->id}]">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" /></a>
				{elseif $gallery->gallery_type == 6}
					<a href="{$ABS_PATH}modules/gallery/uploads/{if $gallery->gallery_folder != ''}{$gallery->gallery_folder}/{/if}{$image.image_filename}" onclick="return hs.expand(this)" class="highslide">
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" title="{$description}" /></a>
				{elseif $gallery->gallery_type == 7}
					{$image.gallery_image_template}
				{else}
					<img src="{$image.thumbnail}" alt="{$image.image_title|escape}" border="0" title="{$description}" />
				{/if}

				{if $gallery->gallery_image_size_show == 1}
					<div class="mod_gal_kbsize">{$image.image_size} kb</div>
				{/if}
			</div>
		</div>
	</div>

	{if $smarty.foreach.img.iteration % $gallery->gallery_image_on_line == 0}
		<div style="clear:both">&nbsp;</div>
	{/if}
{/foreach}

{if $smarty.foreach.img.total % $gallery->gallery_image_on_line != 0}
	<div style="clear:both">&nbsp;</div>
{/if}

{if $more_images == 1}
	<a href="javascript:void(0);" onclick="popup('{$ABS_PATH}index.php?module=gallery&amp;pop=1&amp;sub=allimages&amp;gallery={$gallery->id}','comment','750','750','1');">{#MoreImages#}</a>
{else}
	<div class="container_pages_navigation">
		{$page_nav}
	</div>
{/if}