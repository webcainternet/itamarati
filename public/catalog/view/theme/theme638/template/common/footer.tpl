<footer>  
	
	
    <div class="container">
        <div class="row">
			<div class="col-sm-12">
				<?php if ($logo) { ?>
					<a href="<?php echo $home; ?>"><img src="/image/catalog/LOGO_ITAMARATI.png" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive"/></a>
				<?php } else { ?>
					<h1>
						<a href="<?php echo $home; ?>"><?php echo $name; ?></a>
					</h1>
				<?php } ?>
				
				<div class="phone"> <span><?php echo $text_phone; ?></span> <?php echo $telephone; ?> </div>
				
				<?php if ($open_shop) { ?> <div class="open-block"><?php echo $open_shop; ?> </div><?php } ?>
				
				<div class="newsletter-block"></div>
				
			</div>
            <div class="col-xs-6 col-sm-3">
                <?php if ($informations) { ?>
                    <div class="footer_box">
                        <h5><?php echo $text_information; ?></h5>
                        <ul class="list-unstyled">
                            <?php foreach ($informations as $information) { ?>
                                <li>
                                    <a href="<?php echo $information['href']; ?>"><?php echo $information['title']; ?></a>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
            <div class="col-xs-6 col-sm-3">
                <div class="footer_box">
                    <h5><?php echo $text_service; ?></h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo $contact; ?>"><?php echo $text_contact; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $return; ?>"><?php echo $text_return; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $sitemap; ?>"><?php echo $text_sitemap; ?></a>
                        </li>
                        <?php if(isset($simple_blog_found)) { ?>
                            <li><a href="<?php echo $simple_blog; ?>"><?php echo $simple_blog_footer_heading; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-xs-6 col-sm-3">
                <div class="footer_box">
                    <h5><?php echo $text_account; ?></h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="<?php echo $account; ?>"><?php echo $text_account; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $order; ?>"><?php echo $text_order; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $wishlist; ?>"><?php echo $text_wishlist; ?></a>
                        </li>
                        <li>
                            <a href="<?php echo $newsletter; ?>"><?php echo $text_newsletter; ?></a>
                        </li>
                    </ul>
                </div>
            </div>   

            <div class="col-xs-6 col-sm-3">
                <div class="footer_box">
                    <h5>Veja também</h5>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#">Sucatas</a>
                        </li>
                        <li>
                            <a href="#">Air Bags</a>
                        </li>
                        <li>
                            <a href="#">Motores</a>
                        </li>
                        <li>
                            <a href="#">Rodas</a>
                        </li>
                    </ul>
                </div>
            </div>  

        </div>

        <div class="copyright">
            <div class="container">
                Auto Peças Itamarati - São Paulo - SP - Airbag, Capo, Portas, Tampas, Paineis, Rodas, Retrovisores, Lanternas, Farois! Lider em Vendas! - Todos os direitos reservados © <?php echo date("Y"); ?>
            </div>
        </div>


    </div>
	
</footer>

<script src="https://lojavirtual.digital/lojavirtualfooter.js" type="text/javascript"></script>
<script src="catalog/view/theme/<?php echo $theme_path; ?>/js/livesearch.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/<?php echo $theme_path; ?>/js/script.js" type="text/javascript"></script>
</div>

<div class="ajax-overlay"></div>
<!-- coder by xena -->

    <script>
      function showForm(data){
        $.ajax({
          url: 'index.php?route=product/fastorder/getForm',
          type: 'post',
          data: {product_name: data['product_name'], price: data['price'] ,product_id: data['product_id'], product_link: data['product_link']},

          beforeSend: function() {
          },
          complete: function() {
          },
          success: function(result) {
            $('#fastorder-form-container'+data['product_id']).html(result);
          },
          error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
          }
        });
    };
    </script>
</body></html>