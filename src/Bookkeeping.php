<?php

namespace BizBezzie\Bookkeeping;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class Bookkeeping
{

    /**
     * @var mixed
     */
    private $url;
    private $token;

    /**
     * Bookkeeping constructor.
     *
     * @param  null  $url
     * @param  null  $token
     */
    public function __construct($url = null, $token = null)
    {
        $this->config = Config::get('bookkeeping');

        $this->url   = $this->config['url'];
        $this->token = $this->config['token'];
    }

    /**
     * Get Vouchers
     *
     * @param  null  $url
     * @param  null  $token
     *
     * @return \Illuminate\Http\Client\Response
     */
    public function getVouchers()
    {
        $response = Http::withToken($this->token)->withHeaders(['Accept' => 'application/json'])->get($this->url.'/api/bookkeeping/vouchers');

        return $this->checkResponse($response);
    }

    /**
     * Post Receipt Voucher
     *
     * @param $voucher_category
     * @param $cr_ledgers
     * @param $dr_ledgers
     * @param  null  $url
     * @param  null  $token
     *
     * @return mixed
     */
    public function postReceipt($cr_ledgers, $dr_ledgers)
    {
        return $this->postVoucher('Receipt', $cr_ledgers, $dr_ledgers);
    }

    /**
     * Post Journal Voucher
     *
     * @param $voucher_category
     * @param $cr_ledgers
     * @param $dr_ledgers
     * @param  null  $url
     * @param  null  $token
     *
     * @return mixed
     */
    public function postJournal($cr_ledgers, $dr_ledgers)
    {
        return $this->postVoucher('Journal', $cr_ledgers, $dr_ledgers);
    }

    /**
     * Post any Voucher
     * @param $voucher_category
     * @param $cr_ledgers
     * @param $dr_ledgers
     * @param  null  $url
     * @param  null  $token
     *
     * @return mixed
     */
    public function postVoucher($voucher_category, $cr_ledgers, $dr_ledgers)
    {
        $response = Http::withToken($this->token)->withHeaders(['Accept' => 'application/json'])->asForm()->post(
                $this->url.'/api/bookkeeping/vouchers',
                [
                    'voucher'     => $voucher_category,
                    'transaction' => array_merge($cr_ledgers, $dr_ledgers),
                ]
            );

        return $this->checkResponse($response);
    }

    /**
     * @param $response
     *
     * @return mixed
     */
    protected function checkResponse($response)
    {
        if ($response->successful())
        {
            return json_decode($response, true);
        }
        elseif ($response->failed())
        {
            session()->flash('error', "Request failed.");

            return $response;
        }
        elseif ($response->failed())
        {
            session()->flash('error', "Request failed.");

            return $response;
        }
        elseif ($response->failed())
        {
            session()->flash('error', "Request failed.");

            return $response;
        }
    }

}