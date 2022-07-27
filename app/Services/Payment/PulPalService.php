<?php

namespace App\Services\Payment;

/*
 * PulPal Service
 *
 * */

use App\Events\Payment\PaymentSuccessEvent;
use App\Services\System\LogService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class PulPalService
{
    /*
    * Test Ucun: https://merchant-dev.pulpal.az
    * email:
    *
    * */
    /*
     * ###############################################
     * Test: https://merchant-dev.pulpal.az
     * email: testemindev@bk.ru
     * password: 6467100Aa!@#$%^
     * Production: https://merchant.pulpal.az
     * ###############################################
     * Test Kart
     * PAN: 4169741370562587
     * date: 01/22
     * CVV: 544
     * ###############################################
     * */
    protected $key        = '$2y$10$deSuhU5gDk6LSsLcyF0oJO77UbbHemZlcgpaMZt0nmaq1zOpWwtxW';
    protected $salt       = '$2y$10$fKL3JQbx0AjNDZVaz3H0V.yBWFD88Y8l9cz4QU5QKskVVjdh8TgsO';
    protected $production = false;
    protected $merchantId;
    protected $devUrl     = 'https://pay-dev.pulpal.az/payment';
    protected $proUrl     = 'https://pay.pulpal.az/payment';
    protected $price;
    protected $externalId;
    protected $repeatable = 'true';
    protected $name_az;
    protected $name_en;
    protected $name_ru;
    protected $description_az;
    protected $description_en;
    protected $description_ru;

    /*
     * Set MerchantId
     * Bu hissede merchant
     * id set edirik
     * */
    public function setMerchantId($val): PulPalService
    {
        $this->merchantId = $val;
        return $this;
    }

    /*
     * Set Producation
     * Bu hissede real odenisin
     * olub olmamasini qeyd edirik
     * */
    public function setProduction(bool $val): PulPalService
    {
        $this->production = $val;
        return $this;
    }

    /*
     * Signature
     * Bu hissede gonderilevek imazni
     * teyin edirik
     * */
    public function signature(): string
    {
        $epochTime = intdiv(time(), 300);
        $result    = $this->name_en;
        $result    .= $this->name_az;
        $result    .= $this->name_ru;
        $result    .= $this->description_en;
        $result    .= $this->description_az;
        $result    .= $this->description_ru;
        $result    .= $this->merchantId;
        $result    .= $this->externalId;
        $result    .= $this->price;
        $result    .= $epochTime;
        $result    .= $this->salt;
        return sha1($result);
    }

    /*
     * Api Params
     * Bu hissede requeste gonderilecek
     * parametirleri elave edirik
     * */
    public function apiParams(): string
    {
        $params = [
            'externalId'     => $this->externalId,
            'price'          => $this->price,
            'merchantId'     => $this->merchantId,
            'signature2'     => $this->signature(),
            'repeatable'     => $this->repeatable,
            'name_en'        => $this->name_en,
            'name_az'        => $this->name_az,
            'name_ru'        => $this->name_ru,
            'description_en' => $this->description_en,
            'description_az' => $this->description_az,
            'description_ru' => $this->description_ru,
        ];
        return http_build_query($params);
    }

    /*
     * Get URL
     * Bu hissede odenis etmek ucun url
     * hazirlayiriq
     * */
    public function getUrl(array $params, int $price, string $name, $description = null): string
    {
        $this->externalId     = json_encode($params);
        $this->price          = intval($price * 100);
        $this->name_az        = $name;
        $this->name_en        = $name;
        $this->name_ru        = $name;
        $this->description_az = $description ? $description : $name;
        $this->description_en = $description ? $description : $name;
        $this->description_ru = $description ? $description : $name;
        $url                  = $this->production ? $this->proUrl : $this->devUrl;
        return $url . '?' . $this->apiParams();
    }

    /*
     * Url Generate
     * */
    /**
     * @throws BindingResolutionException
     */
    public function urlGenerate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = validator()->make($request->all(),
            [
                'price' => ['required', 'numeric'],
                'ids'   => ['required']
            ],
            [
                'price.required' => helper()->translate('validator.Required'),
                'ids.required'   => helper()->translate('validator.Required'),
            ]
        );

        if ($validator->fails()):
            return helper()->response('error', $validator->errors());
        endif;

        $url = $this->setMerchantId(482)
            ->getUrl(['ids' => $request->ids, 'auth_key' => $request->key], $request->price, 'SenedTap.Az');
        return helper()->response('success', $url);
    }

    /*
     * Delivery
     * Bu hissede odenis basa catdiqdan sonra
     * hansi proseslerin olmasini isteyirkse
     * o kodlari yaziriq
     * */
    public function delivery(): bool
    {
        $request_body    = file_get_contents('php://input');
        $request         = json_decode($request_body, true);
        $nonce           = request()->header('nonce');
        $signature       = request()->header('signature');
        $price           = $request['Price'];
        $debt            = $request['Debt'];
        $product_type    = $request['ProductType'];
        $amount          = $request['Amount'];
        $provider_type   = $request['ProviderType'];
        $payment_attempt = $request['PaymentAttempt'];
        $external        = json_decode($request['ExternalId'], true);
        $my_signature    = base64_encode(pack('H*', hash_hmac('sha256', route('payment.delivery') . $nonce . $request_body, $this->key)));
        /*
         * Bu hissede odenis tamamlandiqdan sonra
         * edilecek emeliyyatlari yaziriq
         * */
        if ($nonce > 0 && $my_signature == $signature):
            /*
             * Bu hissede odenis tamamlandiqdan sonra
             * olacaq hadiseleri (events) yaziriq
             * */
            PaymentSuccessEvent::dispatch([
                'external'        => $external,
                'price'           => $price,
                'debt'            => $debt,
                'product_type'    => $product_type,
                'amount'          => $amount,
                'provider_type'   => $provider_type,
                'payment_attempt' => $payment_attempt,
            ]);
        else:
            LogService::payment('Ödəniş tamamlanmadı. Ödəmədə problem var', [
                'my_signature' => $my_signature,
                'signature'    => $signature,
                'nonce'        => $nonce,
            ]);
        endif;
        return false;
    }

    /*
     * Redirect
     * Bu hissede PulPal-dan redirect url
     * sorgu geldikde edilecekleri yaziriq
     * */
    public function redirect(): string
    {
        $request = request()->query('ExternalId');
        return route('web.index');
    }
}
