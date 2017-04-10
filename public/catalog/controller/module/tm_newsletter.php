<?php

class ControllerModuleTMNewsletter extends Controller
{
	private $error = array();

	private function install()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "tm_newsletter` (
			`tm_newsletter_id` int(11) NOT NULL AUTO_INCREMENT,
			`tm_newsletter_email` varchar(255) NOT NULL,
			PRIMARY KEY (`tm_newsletter_id`)
			)");
	}

	public function index($setting)
	{
		$this->install();
		$this->load->language('module/tm_newsletter');

		$data['heading_title']       = $this->language->get('heading_title');
		$data['entry_mail']          = $this->language->get('entry_mail');
		$data['button_subscribe']    = $this->language->get('button_subscribe');
		$data['success']             = $this->language->get('text_success');
		$data['error_invalid_email'] = $this->language->get('error_invalid_email');

		if (isset($setting['tm_newsletter_description'][$this->config->get('config_language_id')])) {
			$data['description'] = html_entity_decode($setting['tm_newsletter_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
		}

		$data['action'] = $this->url->link('module/tm_newsletter', '', true);


		return $this->load->view('module/tm_newsletter', $data);
	}
	public function addNewsletter() {
		if (isset($this->request->post['tm_newsletter_email'])) {
			$this->load->model('account/customer');
			$this->load->model('module/tm_newsletter');
			$this->load->language('module/tm_newsletter');

			$input_email = $this->request->post['tm_newsletter_email'];

			if ($this->customer->isLogged() && strcmp($this->customer->getEmail(), $input_email) == 0) {
				if ($this->customer->getNewsletter() == 0) {
					$this->model_account_customer->editNewsletter(1);
				} else {
					$this->error['tm_newsletter_exist_email'] = $this->language->get('error_exist_email');
				}
			} else {
				if (count($this->model_module_tm_newsletter->getNewsletterByEmail($input_email)) != 0) {
					$this->error['tm_newsletter_exist_email'] = $this->language->get('error_exist_email');
				} else if (count($this->model_account_customer->getCustomerByEmail($input_email)) == 0) {
					$this->model_module_tm_newsletter->addNewsletter($input_email);
				} else {
					$this->error['tm_newsletter_exist_user'] = $this->language->get('error_exist_user');
				}
			}

			if (count($this->error) > 0) {
				foreach ($this->error as $err) {
					echo $err;
				}
			}
		}
	}
}