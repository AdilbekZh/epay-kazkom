<?php
namespace Dosarkz\EPayKazCom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class RecurAuthPay
 * @package packages\dosarkz\epayKazcom\src
 */
class BasicAuth extends Epay
{
    /**
     * @var string
     */
    public $template_path  = 'templates/basic_auth_template.xml';

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct();

        $this->order_id         = isset($params['order_id'])    ? $params['order_id'] : null;
        $this->currency         = isset($params['currency'])    ? $params['currency'] : $this->currency;
        $this->amount           = isset($params['amount'])      ? $params['amount'] : 0;
        $this->email            = isset($params['email'])       ? $params['email'] : "";
        $this->hashed           = isset($params['hashed'])      ? $params['hashed'] : false;
        $this->template         = $this->generateXml();
        $this->appendix         = $this->generateAppendix();
    }

    private function generateXml()
    {
        if(file_exists(__DIR__.'/'.$this->template_path)){

           $xml = $this->readXmlFile(__DIR__.'/'.$this->template_path);

            $array = [
                'MERCHANT_CERTIFICATE_ID',
                'MERCHANT_NAME',
                'ORDER_ID',
                'CURRENCY',
                'MERCHANT_ID',
                'AMOUNT',
            ];

            $params = $this->getListParams($array);
            $header_template = $this->setParamsToTemplate($xml,$params);
            $template =  $this->generateXmlTemplate($header_template,$this->kkb);

            if ($this->hashed)
            {
                return base64_encode($template);
            }

            return $template;
        }

        return null;
    }

    public function generateUrl()
    {
        $request = new Request();
        $back_link = config('epay.EPAY_BACK_LINK');
        $post_link = config('epay.EPAY_POST_LINK');
        $form_template = config('epay.EPAY_FORM_TEMPLATE');

        $request->merge([
            'Signed_Order_B64'  =>  $this->template,
            'BackLink'          =>  isset($back_link) ? env('EPAY_BACK_LINK') : null,
            'PostLink'          =>  isset($post_link) ? env('EPAY_POST_LINK') : null,
            'appendix'          =>  $this->appendix,
            'template'          =>  isset($form_template) ? $form_template : null
        ]);

        $validator = Validator::make($request->all(),
            [
                'Signed_Order_B64'  => 'required',
                'email'             => 'email',
                'appendix'          => 'required',
                'BackLink'         => 'required',
                'PostLink'         => 'required',
                'FailureBackLink'    => 'string',
                'template'          => 'string',
            ]
        );

        if ($validator->fails())
        {
            return $validator->errors();
        }

        $params = http_build_query($request->only(['Signed_Order_B64','email','BackLink','PostLink',
            'template']));

        if(config('epay.pay_test_mode') == true)
        {
            $url = 'https://testpay.kkb.kz/jsp/process/logon.jsp';
        }else{
            $url = 'https://epay.kkb.kz/jsp/process/logon.jsp';
        }

        return $url.'?'.$params;
    }



}
