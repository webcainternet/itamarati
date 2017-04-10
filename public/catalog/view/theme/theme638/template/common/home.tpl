<?php echo $header; ?>
<?php if ($top) { ?>
    <section class="top"><?php echo $top; ?></section>
<?php } ?>
    <section id="container">
        <div class="container">
            <div class="row"><?php echo $column_left; ?>
                <?php if ($column_left && $column_right) { ?>
                    <?php $class = 'col-sm-6'; ?>
                <?php } elseif ($column_left || $column_right) { ?>
                    <?php $class = 'col-sm-9'; ?>
                <?php } else { ?>
                    <?php $class = 'col-sm-12'; ?>
                <?php } ?>
                <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?></div>
                <?php echo $column_right; ?></div>
        </div>
    </section>
    <section class="content_bottom container">
		<div class="row">
			<?php echo $content_bottom; ?>
		</div>
	</section>

<div class='embed-container maps'>
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14619.100285326535!2d-46.520224!3d-23.648225!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xdb7cfef37f35a68f!2sAuto+Pe%C3%A7as+Itamarati!5e0!3m2!1spt-BR!2sbr!4v1487265409605" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

<script type="text/javascript">
$(document).ready(function(){
    $('.maps').click(function () {
        $('.maps iframe').css("pointer-events", "auto");
    });

    $( ".maps" ).mouseleave(function() {
      $('.maps iframe').css("pointer-events", "none"); 
    });
});
</script>

<style type="text/css">
    footer {
        margin-top: 0px !important;
    }
</style>

<?php if ($bottom) { ?>
    <section class="bottom"><?php echo $bottom; ?></section>
<?php }
echo $footer; ?>