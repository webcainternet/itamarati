<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

       $data['theme_path'] = $this->config->get($this->config->get('config_theme') . '_directory');
        

		$data['scripts'] = $this->document->getScripts('footer');


      $data['maintenance'] = $this->config->get('config_maintenance');
      
		$data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
		$data['text_extra'] = $this->language->get('text_extra');
		$data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');
		$data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$data['text_voucher'] = $this->language->get('text_voucher');
		$data['text_affiliate'] = $this->language->get('text_affiliate');
		$data['text_special'] = $this->language->get('text_special');
		$data['text_account'] = $this->language->get('text_account');
		$data['text_order'] = $this->language->get('text_order');
		$data['text_wishlist'] = $this->language->get('text_wishlist');
		$data['text_newsletter'] = $this->language->get('text_newsletter');
 
      $data['text_account'] = $this->language->get('text_account');
     $data['text_follow'] = $this->language->get('text_follow');
     $data['text_support'] = $this->language->get('text_support');
     $data['text_twi'] = $this->language->get('text_twi');
     $data['text_fb'] = $this->language->get('text_fb');
     $data['text_rss'] = $this->language->get('text_rss');
     $data['text_yt'] = $this->language->get('text_yt');
     $data['text_phone'] = $this->language->get('text_phone');
     

		$this->load->model('catalog/information');

		$data['informations'] = array();

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
				$data['informations'][] = array(
					'title' => $result['title'],
					'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id'])
				);
			}
		}

 
           if ($this->request->server['HTTPS']) {
      $server = $this->config->get('config_ssl');
   } else {
      $server = $this->config->get('config_url');
   }
     if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
     $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
   } else {
      $data['logo'] = '';
   }
   $data['name'] = $this->config->get('config_name');
    $data['home'] = $this->url->link('common/home');
      
		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
		$data['manufacturer'] = $this->url->link('product/manufacturer');
		$data['voucher'] = $this->url->link('account/voucher', '', true);
		$data['affiliate'] = $this->url->link('affiliate/account', '', true);
		$data['special'] = $this->url->link('product/special');
		$data['account'] = $this->url->link('account/account', '', true);
		$data['order'] = $this->url->link('account/order', '', true);
		$data['wishlist'] = $this->url->link('account/wishlist', '', true);
		$data['newsletter'] = $this->url->link('account/newsletter', '', true);

     $data['footer_top'] = $this->load->controller('common/footer_top');
     
 
          $data['tm_social_list'] = $this->load->controller('module/tm_social_list');
     
 
      $data['address'] = nl2br($this->config->get('config_address'));
     $data['telephone'] = $this->config->get('config_telephone');
      $data['fax'] = $this->config->get('config_fax');
      $data['open_shop'] = $this->config->get('config_open');
     

		$data['powered'] = "";

       if(($this->config->has('config_simple_blog_status')) && ($this->config->get('config_simple_blog_status'))) {
        $data['simple_blog_found'] = 1;
       $tmp = $this->config->get('config_simple_blog_footer_heading');
       if (!empty($tmp)) {
       $data['simple_blog_footer_heading'] = $this->config->get('config_simple_blog_footer_heading');
        } else {
        $data['simple_blog_footer_heading'] = $this->language->get('text_simple_blog');
       }
       $data['simple_blog']  = $this->url->link('simple_blog/article');
        }
       

		// Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		return $this->load->view('common/footer', $data);
	}
}
