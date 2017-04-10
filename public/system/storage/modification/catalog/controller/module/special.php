<?php
class ControllerModuleSpecial extends Controller {
	public function index($setting) {

       static $module = 0;
       
		$this->load->language('module/special');

 
     $data['text_sale'] = $this->language->get('text_sale'); 
      $data['text_new'] = $this->language->get('text_new'); 
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_tax'] = $this->language->get('text_tax');

       $data['text_sale'] = $this->language->get('text_sale');
       $data['text_new'] = $this->language->get('text_new');
       

		$data['button_cart'] = $this->language->get('button_cart');

       $data['text_quick']        = $this->language->get('text_quick');
        $data['text_manufacturer'] = $this->language->get('text_manufacturer');
       $data['text_model']        = $this->language->get('text_model');
        
 
        $data['text_option'] = $this->language->get('text_option');
       $data['text_select'] = $this->language->get('text_select');
       $data['button_upload'] = $this->language->get('button_upload');
       $data['text_loading'] = $this->language->get('text_loading');
       
		$data['button_wishlist'] = $this->language->get('button_wishlist');
		$data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('catalog/product');

		$this->load->model('tool/image');


       $data['label_sale'] = $this->config->get('config_label_sale');
        $data['label_discount'] = $this->config->get('config_label_discount');
        $data['label_new'] = $this->config->get('config_label_new');
        if ($this->config->get('config_label_new')) {
       $product_new = $this->model_catalog_product->getLatestProducts($this->config->get('config_label_new_limit'));
       }
       
		$data['products'] = array();
 
       $lim_last=5; 
       $filter_data = array(
         'sort'  => 'p.date_added',
          'order' => 'DESC',
          'start' => 0,
         'limit' => $lim_last
        );
        $results1 = $this->model_catalog_product->getProducts($filter_data);
        $last_array = array();
        foreach ($results1 as $result) {
        $last_array[] = $result['product_id'];      
        };
        
      

		$filter_data = array(
			'sort'  => 'pd.name',
			'order' => 'ASC',
			'start' => 0,
			'limit' => $setting['limit']
		);

		$results = $this->model_catalog_product->getProductSpecials($filter_data);

		if ($results) {
			foreach ($results as $result) {

       if ($this->config->get('config_label_new')) {
       $label_new = 0;
       foreach ($product_new as $product_new_id => $product) {
       if ($product_new[$product_new_id]['product_id'] == $result['product_id']) {
       $label_new = 1;
       break;
        }
       }
       }
       
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
				} else {
					$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
				}

				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
				} else {
					$price = false;
				}

				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);

       $label_discount = '-' . (int)(100 - ($result['special'] * 100 / $result['price'])) . '%';
       
				} else {
					$special = false;

       $label_discount = false;
        
				}

				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
				} else {
					$tax = false;
				}

				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}


       $options = array();
       foreach ($this->model_catalog_product->getProductOptions($result['product_id']) as $option) {
       $product_option_value_data = array();
       foreach ($option['product_option_value'] as $option_value) {
        if (!$option_value['subtract'] || ($option_value['quantity'] > 0)) {
        if ((($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) && (float)$option_value['price']) {
        $price_option = $this->currency->format($this->tax->calculate($option_value['price'], $result['tax_class_id'], $this->config->get('config_tax') ? 'P' : false), $this->session->data['currency']);
        } else {
        $price_option = false;
        }
       $product_option_value_data[] = array(
       'product_option_value_id' => $option_value['product_option_value_id'],
        'option_value_id'         => $option_value['option_value_id'],
        'name'                    => $option_value['name'],
       'image'                   => $this->model_tool_image->resize($option_value['image'], 50, 50),
       'price'                   => $price_option,
       'price_prefix'            => $option_value['price_prefix']
        );
        }
       }
       $options[] = array(
       'product_option_id'    => $option['product_option_id'],
       'product_option_value' => $product_option_value_data,
       'option_id'            => $option['option_id'],
       'name'                 => $option['name'],
        'type'                 => $option['type'],
        'value'                => $option['value'],
       'required'             => $option['required']
       );
        }
       

       $desc = html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8');
        $pos = strpos($desc,'<iframe');
       if (is_int($pos)) {
       $pos2 = strpos($desc, '</iframe>') + 9;
       $video = substr($desc, $pos, $pos2);
        $quick_descr = str_replace($video, '', $desc);
        } else{
       $quick_descr = $desc;
       }
       
				$data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,

       'img-width'  => $setting['width'],
        'img-height' => $setting['height'],
       
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
					'price'       => $price,
					'special'     => $special,

       'label_discount' => $label_discount,
        'label_new' => $this->config->get('config_label_new') ? $label_new : 0,
       
					'tax'         => $tax,
 
      'last_array' => $last_array,  
      'limit_last' => $lim_last,  
					'rating'      => $rating,

       'author'        => $result['manufacturer'],
       'description1'  => $quick_descr,
        'manufacturers' => $data['manufacturers'] = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $result['manufacturer_id']),
       'model'         => $result['model'],
        
					'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
,
        'options'     => $options
       
				);
			}


       $data['module'] = $module++;
        
			return $this->load->view('module/special', $data);
		}
	}
}