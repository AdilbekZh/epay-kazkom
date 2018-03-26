<?php
return [
    'pay_test_mode' => true,

    'MERCHANT_CERTIFICATE_ID'   => '',
    'MERCHANT_NAME'             => '',
    'PRIVATE_KEY_PATH'          => '',
    'PRIVATE_KEY_PASS'          => '',
    'XML_TEMPLATE_FN'           => '',
    'XML_COMMAND_TEMPLATE_FN'   => '',
    'PUBLIC_KEY_PATH'           => '',
    'MERCHANT_ID'               => '',
    // Линк для возврата покупателя в магазин (на сайт) после успешного проведения оплаты
    'EPAY_BACK_LINK'            => 'http://epay.kkb.kz/jsp/hbpay/pay_req.jsp',
    // Линк для отправки результата авторизации в магазин.
    'EPAY_POST_LINK'            => 'http://epay.kkb.kz/jsp/hbpay/pl.jsp',
    // Линк для отправки неудачного результата авторизации либо информации об ошибке в магазин.
    'EPAY_FAILURE_POST_LINK'    => 'http://epay.kkb.kz/jsp/hbpay/pl.jsp',

    'EPAY_FORM_TEMPLATE'        => 'default.xsl',
    
    // Для теста
    'TEST_MERCHANT_CERTIFICATE_ID'   => '00C182B189',
    'TEST_MERCHANT_NAME'             => 'Demo Shop',
    'TEST_PRIVATE_KEY_PATH'          => storage_path('app/certs/test/test_prv.pem');,
    'TEST_PRIVATE_KEY_PASS'          => 'nissan',
    'TEST_PUBLIC_KEY_PATH'           => storage_path('app/certs/test/kkbca.pem'),
    'TEST_MERCHANT_ID'               => '92061101',
];
