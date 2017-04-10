<?php
class ModelShippingJoseanMatiasFaixaCEP extends Model {

    function getQuote($address) {
        $this->load->language('shipping/joseanmatias_faixa_cep');

        $postcode = (int) preg_replace("/[^0-9]/", "", $address['postcode']);

        $status = false;

        $faixa_cep_interval = json_decode($this->config->get('joseanmatias_faixa_cep_interval'), true);

        if (isset($address['product_info']) && $address['product_info']) {
            $cart_subtotal = (isset($address['product_info']['special']) && $address['product_info']['special'] ? (float) $address['product_info']['special'] * (int) $address['product_info']['quantity'] : (float) $address['product_info']['price'] * (int) $address['product_info']['quantity']);
        } else {
            $cart_subtotal = $this->cart->getSubTotal();
        }

        $faixa_cep_title = $this->language->get('text_description');

        if ($faixa_cep_interval && $this->config->get('joseanmatias_faixa_cep_status')) {
            foreach ($faixa_cep_interval as $interval) {
                //DEFINE AS FAIXAS DE CEP
                if ($cart_subtotal >= (float) $interval['order_total']) {
                    if (strstr($interval['cep'], ':')) {
                        $ceps = explode(":", str_replace("-", "", $interval['cep']));

                        if ($postcode >= (int) $ceps[0] && $postcode <= (int) $ceps[1]) {
                            $status = true;
                        }
                    } elseif ($interval['cep']) {
                        $cep = str_replace("-", "", $interval['cep']);

                        if ($postcode == $cep) {
                            $status = true;
                        }
                    }

                    $faixa_cep_title = $interval['title'];
                    $faixa_cep_cost = (float) $interval['cost'];
                }

                if ($status === true)
                    break;
            }
        }

        $method_data = array();

        if ($status && isset($faixa_cep_cost)) {
            $quote_data = array();

            $quote_data['joseanmatias_faixa_cep'] = array(
                'code' => 'joseanmatias_faixa_cep.joseanmatias_faixa_cep',
                'title' => $faixa_cep_title,
                'cost' => $faixa_cep_cost,
                'tax_class_id' => 0,
                'text' => 'R$ '.$faixa_cep_cost
            );

            $method_data = array(
                'code' => 'joseanmatias_faixa_cep',
                'title' => $this->language->get('text_title'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get('joseanmatias_faixa_cep_sort_order'),
                'error' => false
            );
        }

        return $method_data;
    }
}
?>