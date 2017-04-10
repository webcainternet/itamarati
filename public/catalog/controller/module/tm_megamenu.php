<?php

class ControllerModuleTMMegaMenu extends Controller
{

	public function index($setting)
	{
		$this->load->language('module/category');
		$this->load->language('module/tm_megamenu');

		$this->document->addScript('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/js/tmmegamenu/superfish.min.js');
		$this->document->addScript('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/js/tmmegamenu/jquery.rd-navbar.min.js');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');

		$categories = $this->model_catalog_category->getCategories(0);

		$data['menu_items'] = array();
		if (isset($setting['menu_item'])) {
			$j = 0;
			foreach ($setting['menu_item'] as $menu_item) {
				if (($j < sizeof($categories) && $setting['menu_item'][$j]['type'] == 0) || $setting['menu_item'][$j]['type'] == 1) {

					if ($j < sizeof($categories) && $menu_item['type'] == 0) {
						for ($i = $j; $i < sizeof($categories); $i++) {
							if ($categories[$j]['top']) {
								break;
							}
						}
						$category = $categories[$j];
						$name     = $category['name'];
						$href     = $this->url->link('product/category', 'path=' . $category['category_id']);
						$liClass  = $menu_item['submenu_type'] == 1 ? 'sf-with-mega' : '';

					} else {
						if (isset($menu_item[$this->config->get('config_language_id')]['title'])) {
							$name = $menu_item[$this->config->get('config_language_id')]['title'];
						} else {
							$name = '';
						}

						if (!empty($menu_item['link'])) {
							$href = $menu_item['link'];
						} else {
							$href = '';
						}

						$liClass = $menu_item['submenu_show'] == 1 ? 'sf-with-mega' : '';
					}
					if ($j < sizeof($categories) && $menu_item['type'] == 0 && $menu_item['submenu_type'] == 0) {
						$multilevel = $this->getCatTree($categories[$j]['category_id']) . "\n";
					} elseif ($j < sizeof($categories)) {
						$multilevel        = '';
						$subcategory_count = 0;
						$subwithsub_count  = 0;
						$subwithprod_count = 0;
						$products_count    = 0;
						$categories_arr    = [];

						if (isset($menu_item['column'])) {
							$columns = array();
							for ($i = 0; $i < $menu_item['columns']; $i++) {
								$subcategory      = array();
								$list             = '';
								$module           = '';
								$category_show    = '';
								$category_href    = '';
								$subcategory_href = '';

								if ($menu_item['column'][$i]['content'] != 0 && $menu_item['type'] == 1) {
									if ($menu_item['column'][$i]['category_show'] == 1) {
										$category_show = $this->model_catalog_category->getCategory($menu_item['column'][$i]['category_id']);
										$category_href = $this->url->link('product/category', 'path=' . $category_show['category_id']);

										$exist = false;
										foreach ($categories_arr as $cat) {
											if ($cat['id'] == $menu_item['column'][$i]['category_id']) {
												$exist = true;
												break;
											}
										}

										if (!$exist) {
											$categories_arr[] = array(
												'id'         => $menu_item['column'][$i]['category_id'],
												'count_prod' => 0,
												'count_sub'  => 0,
												);
										}
									}
								}

								switch ($menu_item['column'][$i]['content']) {
									case 4:
									if (isset($menu_item['column'][$i]['category_id']) && $menu_item['type'] == 1) {
										$category_id = (int)$menu_item['column'][$i]['category_id'];
										foreach ($categories_arr as $key => $value) {
											if ($categories_arr[$key]['id'] == $menu_item['column'][$i]['category_id']) {
												$glob_key = $key;
											}
										}
									} else {
										$category_id = (int)$categories[$j]['category_id'];
									}

									if ($menu_item['type'] == 1 && isset($glob_key)) {
										$start = $categories_arr[$glob_key]['count_prod'];
									} else {
										$start = $products_count;
									}


									$filter_data = array(
										'filter_category_id'  => $category_id,
										'filter_sub_category' => true,
										'sort'                => 'p.date_added',
										'order'               => 'DESC',
										'start'               => $start,
										'limit'               => $menu_item['column'][$i]['prod_limit']
										);

									$results = $this->model_catalog_product->getProducts($filter_data);
									if (isset($results)) {
										foreach ($results as $product_info) {
											$list .= "<li>\n<a href=\"" . $this->url->link('product/product', '&product_id=' . $product_info['product_id']) . "\">" . $product_info['name'] . "</a>\n</li>\n";
											if ($menu_item['type'] == 1 && isset($glob_key)) {
												$categories_arr[$glob_key]['count_prod']++;
											} else {
												$products_count++;
											}
										}
									}

									break;
									case 3:
									if (isset($menu_item['column'][$i]['category_id']) && $menu_item['type'] == 1) {
										$subcategories = $this->model_catalog_category->getCategories((int)$menu_item['column'][$i]['category_id']);
									} else {
										$subcategories = $this->model_catalog_category->getCategories((int)$categories[$j]['category_id']);
									}


									if (isset($subcategories[$subwithsub_count])) {
										$subcategory_href = $this->url->link('product/category', 'path=' . $subcategories[$subwithsub_count]['category_id']);
										$subcategory = $this->model_catalog_category->getCategory((int)$subcategories[$subwithsub_count]['category_id']);

										$subcategories2 = $this->model_catalog_category->getCategories((int)$subcategories[$subwithsub_count]['category_id']);

										if (isset($subcategories2)) {
											for ($l = 0; $l < $menu_item['column'][$i]['limit']; $l++) {
												if (isset($subcategories2[$l])) {
													$subcategory_name = $subcategories2[$l]['name'];
													$subcategories2_href = $this->url->link('product/category', 'path=' . $subcategories2[$l]['category_id']);
													$list .= "<li>\n<a href=\"" . $subcategories2_href . "\">" . $subcategory_name . "</a>\n</li>\n";
												}
											}
										}

										$subwithsub_count++;
									}
									break;

									case 2:
									if (isset($menu_item['column'][$i]['category_id']) && $menu_item['type'] == 1) {
										$subcategories = $this->model_catalog_category->getCategories((int)$menu_item['column'][$i]['category_id']);
										foreach ($categories_arr as $key => $value) {
											if ($categories_arr[$key]['id'] == $menu_item['column'][$i]['category_id']) {
												$glob_key = $key;
											}
										}
									} else {
										$subcategories = $this->model_catalog_category->getCategories((int)$categories[$j]['category_id']);
									}

									if ($menu_item['type'] == 1 && isset($glob_key)) {
										$num = $categories_arr[$glob_key]['count_sub'];
										$categories_arr[$glob_key]['count_sub']++;
									} else {
										$num = $subwithprod_count;
										$subwithprod_count++;
									}

									if (isset($subcategories[$num])) {
										$subcategory_href = $this->url->link('product/category', 'path=' . $subcategories[$num]['category_id']);

										$subcategory = $this->model_catalog_category->getCategory((int)$subcategories[$num]['category_id']);

										if (!empty($subcategory)) {
											$filter_data = array(
												'filter_category_id'  => (int)$subcategory['category_id'],
												'filter_sub_category' => true,
												'sort'                => 'p.date_added',
												'order'               => 'DESC',
												'start'               => 0,
												'limit'               => $menu_item['column'][$i]['prod_limit']
												);

											$results = $this->model_catalog_product->getProducts($filter_data);
											if (isset($results)) {
												foreach ($results as $product_info) {
													$list .= "<li>\n<a href=\"" . $this->url->link('product/product', '&product_id=' . $product_info['product_id']) . "\">" . $product_info['name'] . "</a>\n</li>\n";
												}
											}
										}
									}
									break;

									case 1:
									if (isset($menu_item['column'][$i]['category_id']) && $menu_item['type'] == 1) {
										$subcategories = $this->model_catalog_category->getCategories((int)$menu_item['column'][$i]['category_id']);
									} else {
										$subcategories = $this->model_catalog_category->getCategories((int)$categories[$j]['category_id']);
									}

									if (isset($subcategories)) {
										$tmp = $menu_item['column'][$i]['limit'] + $subcategory_count;
										for ($l = $subcategory_count; $l < $tmp; $l++) {
											if (isset($subcategories[$l])) {
												$subcategory_name = $subcategories[$l]['name'];
												$subcategories_href = $this->url->link('product/category', 'path=' . $subcategories[$l]['category_id']);
												$list .= "<li>\n<a href=\"" . $subcategories_href . "\">" . $subcategory_name . "</a>\n</li>\n";
											}
											$subcategory_count++;
										}
									}
									break;

									case 0:
									if (isset($menu_item['column'][$i]['module_id'])) {
										$code = $this->model_extension_module->getModuleCode($menu_item['column'][$i]['module_id']);
										$setting_info = $this->model_extension_module->getModule($menu_item['column'][$i]['module_id']);
										if ($setting_info && $setting_info['status']) {
											$module .= $this->load->controller('module/' . $code, $setting_info);
										}
									}
									break;
								}

								$columns[] = array(
									'width'                => $menu_item['column'][$i]['width'],
									'custom_category'      => $category_show,
									'custom_category_href' => $category_href,
									'module'               => $module,
									'list'                 => $list,
									'subcategory'          => $subcategory,
									'subcategory_href'     => $subcategory_href,
									);
							}
						}
					}

					if (!isset($columns)) {
						$columns = array();
					}

					if (is_file(DIR_IMAGE . $menu_item['image'])) {
						$image = $this->model_tool_image->resize($menu_item['image'], $menu_item['image_width'], $menu_item['image_height']);
					} else {
						$image = '';
					}

					$data['menu_items'][] = array(
						'href'       => $href,
						'name'       => $name,
						'mega'       => $liClass,
						'multi'      => $multilevel,
						'per-row'    => $menu_item['columns-per-row'],
						'column'     => $columns,
						'background' => $image
						);

					if ($menu_item['type'] == 0) {
						$j++;
					}
				}
			}
		}

		return $this->load->view('module/tm_megamenu', $data);
	}

	function getCatTree($category_id = 0)
	{
		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		$this->load->model('catalog/category');
		$category_data = "";

		$categories = $this->model_catalog_category->getCategories((int)$category_id);

		foreach ($categories as $category) {
			$name = $category['name'];
			$href = $this->url->link('product/category', 'path=' . $category['category_id']);
			$class = in_array($category['category_id'], $parts) ? " class=\"active\"" : "";
			$parent = $this->getCatTree($category['category_id']);
			if ($parent) {
				$class = $class ? " class=\"active\"" : " class=\"parent\"";
			}
			$category_data .= "<li>\n<a href=\"" . $href . "\"" . $class . ">" . $name . "</a>" . $parent . "\n</li>\n";

		}

		return strlen($category_data) ? "<ul class=\"simple_menu\">\n" . $category_data . "\n</ul>\n" : "";
	}
}