<?php
class ControllerModuleTMBlogCategory extends Controller {
	public function index($setting) {
		$this->load->language('module/tm_blog_category');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->load->model('simple_blog/article');

		$data['text_search_article'] = $this->language->get('text_search_article');
		$data['button_search'] = $this->language->get('button_search');

		if (isset($this->request->get['simple_blog_category_id'])) {
			$parts = explode('_', (string)$this->request->get['simple_blog_category_id']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$data['category_id'] = $parts[0];
		} else {
			$data['category_id'] = 0;
		}

		if (isset($parts[1])) {
			$data['child_id'] = $parts[1];
		} else {
			$data['child_id'] = 0;
		}

		$this->load->model('simple_blog/article');

		$data['categories'] = array();

		$categories = $this->model_simple_blog_article->getCategories(0);

		foreach ($categories as $category) {

			$children_data = array();

			$children = $this->model_simple_blog_article->getCategories($category['simple_blog_category_id']);

			foreach ($children as $child) {

				$children_data[] = array(
					'category_id' => $child['simple_blog_category_id'],
					'name'  => $child['name'],
					'href'  => $this->url->link('simple_blog/category', 'simple_blog_category_id=' . $category['simple_blog_category_id'] . '_' . $child['simple_blog_category_id'])
					);
			}

			$data['categories'][] = array(
				'simple_blog_category_id' => $category['simple_blog_category_id'],
				'name'     => $category['name'],
				'children' => $children_data,
				'href'     => $this->url->link('simple_blog/category', 'simple_blog_category_id=' . $category['simple_blog_category_id'])
				);
		}

		$data['category_search_article'] = $setting['category_search_article'];

		if (isset($this->request->get['blog_search'])) {
			$data['blog_search'] = $this->request->get['blog_search'];
		} else {
			$data['blog_search'] = '';
		}

		return $this->load->view('module/tm_blog_category', $data);
	}
}
?>