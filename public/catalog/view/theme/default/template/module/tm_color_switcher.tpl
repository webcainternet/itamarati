<div id="style_switcher">
	<div class="toggler"></div>
	<p><?php echo $title; ?></p>
	<ul id="color-box">
		<?php foreach ($color_schemes as $color_scheme) { ?>
		<?php if ($color_scheme['scheme'] == $active_color_scheme) { ?>
		<li class="active"><div class="color_scheme <?php echo $color_scheme['scheme']; ?>" data-scheme="<?php echo $color_scheme['scheme']; ?>">&nbsp;</div></li>
		<?php } else { ?>
		<li><div class="color_scheme <?php echo $color_scheme['scheme']; ?>" data-scheme="<?php echo $color_scheme['scheme']; ?>">&nbsp;</div></li>
		<?php } ?>
		<?php } ?>
	</ul>
</div>
