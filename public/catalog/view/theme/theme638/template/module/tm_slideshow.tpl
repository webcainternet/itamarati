<div class="fluid_container" >
	<div class="camera_container">
		<div id="camera_wrap_<?php echo $module; ?>">
			<?php foreach ($banners as $banner) { ?>
			<div title="<?php echo $banner['title']; ?>" data-thumb="<?php echo $banner['image']; ?>" <?php if ($banner['link']) { ?> data-link="<?php echo $banner['link']; ?>"<?php } ?> data-src="<?php echo $banner['image']; ?>">
				<?php if ($banner['description']) { ?>
				<div class="camera_caption fadeIn">
					<?php echo $banner['description']; ?>
				</div>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
	</div>
	<div class="clear"></div>
</div>

<script>
	;(function ($) {
		var o = $('#camera_wrap_<?php echo $module; ?>');
		$(window).load(function(){
			if (o.length) {
				o.camera({
					navigation: true,
					playPause: false,
					thumbnails: false,
					navigationHover: true,
					barPosition: 'top',
					loader: false,
					time: 3000,
					transPeriod:800,
					alignment: 'center',
					autoAdvance: true,
					mobileAutoAdvance: true,
					barDirection: 'leftToRight', 
					barPosition: 'bottom',
					easing: 'easeInOutExpo',
					fx: 'simpleFade',
					height: '45.46%',
					minHeight: '300px',
					hover: true,
					pagination: false,
					loaderColor			: '#1f1f1f', 
					loaderBgColor		: 'transparent',
					loaderOpacity		: 1,
					loaderPadding		: 0,
					loaderStroke		: 3,
				})
			}
		});
	})(jQuery);
</script>