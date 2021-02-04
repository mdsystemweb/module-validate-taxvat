<?php
namespace Mdsystemweb\ValidateTaxvat\Controller\Index;

class Validate extends \Magento\Framework\App\Action\Action
{
	protected $_pageFactory;

	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory)
	{
		$this->_pageFactory = $pageFactory;
		return parent::__construct($context);
	}

	public function execute()
	{
        $array = [
            'error'=>'',
            'result'=>[]
        ];

        $get = filter_input_array(INPUT_GET, FILTER_DEFAULT);

	    //se estiver preenchida a variavel _POST['cpf']
        if (!empty($get['cpf']))
        {
            if ($this->validation($get['cpf'])) {

                $array['error'] = false;
                $array['result']['status'] = true;
                $array['result']['cpf'] = $get['cpf'];

            } else {

                $array['error'] = true;
                $array['result']['status'] = false;
                $array['result']['cpf'] = $get['cpf'];

            }
        }

        echo json_encode($array);
	}

	public function validation($cpf){
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}
