<?php if ($menu_items) { ?>
<div class="megamenu">
	<h3><?php echo $heading_title;?></h3>
	<ul class="sf-menu">
		<?php foreach ($menu_items as $menu_item) { ?>
		<li <?php echo (!empty($menu_item['mega'])) ? 'class="' . $menu_item['mega'] . '"' : ''; ?>>
			<?php if (empty($menu_item['href'])) { ?>
			<span><?php echo $menu_item['name']; ?></span>
			<?php } else { ?>
			<a href="<?php echo $menu_item['href']; ?>"><?php echo $menu_item['name']; ?></a>
			<?php } ?>
			<?php if (!empty($menu_item['multi'])) { ?>
			<?php echo $menu_item['multi']; ?>
			<?php } elseif (!empty($menu_item['mega'])) { ?>
			<ul class="sf-mega" <?php echo (!empty($menu_item['background'])) ? 'style="background-image: url(' . $menu_item['background'] . ');"' : '' ?>>
				<?php for ($i = 0; $i < count($menu_item['column']); $i++) {
					$column = $menu_item['column'][$i];
					if ($i % $menu_item['per-row'] == 0 && $i != 0) { ?>
				</li><li class="sf-mega_row">
				<?php } elseif ($i == 0) { ?>
				<li class="sf-mega_row">
					<?php } ?>
					<div class="sf-mega_section" style="width: <?php echo $column['width']; ?>">
						<?php if (!empty($column['custom_category'])) { ?>
						<div class="submenu_category_title">
							<a href="<?php echo $column['custom_category_href']; ?>">
								<?php echo $column['custom_category']['name']; ?>
							</a>
						</div>
						<?php } ?>
						<?php if (!empty($column['module'])) { ?>
						<div class="megamenu_module">
							<?php echo $column['module']; ?>
						</div>
						<?php } ?>
						<?php if (!empty($column['subcategory'])) { ?>
						<div class="submenu_title">
							<a href="<?php echo $column['subcategory_href'] ?>">
								<?php echo $column['subcategory']['name']; ?>
							</a>
						</div>
						<?php } ?>
						<?php if (!empty($column['list'])) { ?>
						<ul>
							<?php echo $column['list']; ?>
						</ul>
						<?php } ?>
					</div>
					<?php if ($i == count($menu_item['column'])) { ?>
				</li>
				<?php } ?>
				<?php } ?>
			</ul>
			<?php } ?>
		</li>
		<?php } ?>
	</ul>
</div>
<script>
	;(function ($) {
		$(window).load(function () {
			var o = $('.sf-menu');
			o.superfish();
			o.find('li a').each(function () {
				if ($(location).attr('href').indexOf($(this).attr('href')) >= 0){
					$(this).addClass('active');
					return;
				}
			})
			if (o.parents('aside').length){
				var width = $('.container').outerWidth() - $('aside').outerWidth();
				o.find('.sf-mega').each(function () {
					$(this).width(width);
				})
			}
		});
	})(jQuery);
</script>
<?php } ?>