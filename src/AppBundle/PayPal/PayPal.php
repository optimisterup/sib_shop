<?php
namespace AppBundle\PayPal;

class PayPal {
    /**
     * Последние сообщения об ошибках
     * @var array
     */
    protected $_errors = array();

    /**
     * Данные API
     * Обратите внимание на то, что для песочницы нужно использовать соответствующие данные
     * @var array
     */
    protected $_credentials = array(
        'USER' => 'k448687_api1.nwytg.com',
        'PWD' => 'Y2PBZPT6S5HVQKXM',
        'SIGNATURE' => 'Af5HeeSz1nM71etr-OHJ2F51czMhAT83-whiEsb3vOsOMf9He18MDWYE',
    );

    /**
     * Указываем, куда будет отправляться запрос
     * Реальные условия - https://api-3t.paypal.com/nvp
     * Песочница - https://api-3t.sandbox.paypal.com/nvp
     * @var string
     */
    protected $_endPoint = 'https://api-3t.sandbox.paypal.com/nvp';

    /**
     * Версия API
     * @var string
     */
    protected $_version = '95.0';

    /**
     * Сформировываем запрос
     *
     * @param string $method Данные о вызываемом методе перевода
     * @param array $params Дополнительные параметры
     * @return array / boolean Response array / boolean false on failure
     */
    public function request($method,$params = array()) {
        $this -> _errors = array();
        if( empty($method) ) { // Проверяем, указан ли способ платежа
            $this -> _errors = array('Не указан метод перевода средств');
            return false;
        }

        // Параметры нашего запроса
        $requestParams = array(
                'METHOD' => $method,
                'VERSION' => $this -> _version
            ) + $this -> _credentials;

        // Сформировываем данные для NVP
        $request = http_build_query($requestParams + $params);

        // Настраиваем cURL
        $curlOptions = array (
            CURLOPT_URL => $this -> _endPoint,
            CURLOPT_VERBOSE => 1,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_CAINFO => dirname(__FILE__) . '/cacert.pem', // Файл сертификата
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $request
        );

        $ch = curl_init();
        curl_setopt_array($ch,$curlOptions);

        // Отправляем наш запрос, $response будет содержать ответ от API
        $response = curl_exec($ch);

        // Проверяем, нету ли ошибок в инициализации cURL
        if (curl_errno($ch)) {
            $this -> _errors = curl_error($ch);
            curl_close($ch);
            return false;
        } else  {
            curl_close($ch);
            $responseArray = array();
            parse_str($response,$responseArray); // Разбиваем данные, полученные от NVP в массив
            return $responseArray;
        }
    }






}