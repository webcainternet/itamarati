<?php
class ControllerModuleTMColorSwitcher extends Controller {

	public function index() {
		$this->load->language('module/tm_color_switcher');

		$data['heading_title'] = $this->language->get('heading_title');

		$this->document->addScript('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/js/tmcolorswitcher/jquery.cookies.js');

		$this->user = new Cart\User($this->registry);

		if ($this->user->hasPermission('modify', 'module/tm_color_switcher')) {
			$this->document->addScript('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/js/tmcolorswitcher/style_switcher.js');
			$data['active_color_scheme'] = $this->config->get('tm_color_switcher_scheme');
		} else {
			$this->document->addScript('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/js/tmcolorswitcher/style_switcher_demo.js');
			if (isset($_COOKIE['tm_color_switcher_scheme'])) {
				$data['active_color_scheme'] = $_COOKIE['tm_color_switcher_scheme'];
			} else {
				$data['active_color_scheme'] = '';
			}
		}

		$color_schemes = glob('catalog/view/theme/' . $this->config->get($this->config->get('config_theme') . '_directory') . '/stylesheet/color_schemes/*');

		$i = 0; foreach ($color_schemes as $scheme) {
			$data['color_schemes'][$i] = array(
				'scheme' => preg_replace('/\\.[^.\\s]{3,4}$/', '', explode('color_schemes/', $scheme)[1]),
				'name'   => 'Color Scheme' . ' ' . ($i + 1)
				);
			$i++;
		}

		$data['title'] = $this->language->get('title');

		return $this->load->view('module/tm_color_switcher', $data);
	}
	public function updateSchame() {

		$this->load->model('module/tm_color_switcher');

		$json = array();
		$this->user = new Cart\User($this->registry);
		if ($this->user->hasPermission('modify', 'module/tm_color_switcher')) {
			$json['permission'] = true;
		} else {
			$json['permission'] = false;
		}

		$json['post'] = $this->request->post['tm_color_switcher_scheme'];

		$this->model_module_tm_color_switcher->editSettingValue('tm_color_switcher', 'tm_color_switcher_scheme', $json['post']);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}