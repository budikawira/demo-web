<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Util;
use App\Trx;

class PaymentController extends Controller
{
    //
    public function sendMoney(Request $request) {
        $json = json_decode($request->getContent());

        $trx = new Trx(ICON_SEND_MONEY, "Send Money", md5(time()));
        $trx->message = "Send money to ".
            $json->contact->name." (".$json->contact->token.") is successful!";
        $trx->amount = $json->amount;
        $trx->status = STATUS_SUCCESS;
        $trx->createdDate = date('Y-m-d h:i:s');

        return $trx->toJson();
    }

    public function cellular(Request $request) {
        $json = json_decode($request->getContent());

        $trx = new Trx(ICON_CELULLAR, $json->type, md5(time()));
        $trx->amount = $json->amount;
        $trx->status = STATUS_SUCCESS;
        $trx->createdDate = date('Y-m-d h:i:s');
        if ($json->type == "Top Up") {
            $trx->message = "Isi ulang ".$json->product." ke nomor ".$json->phone." berhasil!";
        } else {
            $trx->message = "Beli paket ".$json->product." ke nomor ".$json->phone." berhasil!";
        }

        return $trx->toJson();
    }

    public function pln(Request $request) {
        $json = json_decode($request->getContent());

        $trx = new Trx(ICON_PLN, "PLN", md5(time()));
        $trx->amount = $json->amount;
        $trx->status = STATUS_SUCCESS;
        $trx->createdDate = date('Y-m-d h:i:s');
        $trx->message = "Token Meter $json->meterNo : ".rand(11111111,99999999);
        return $trx->toJson();
    }

    public function withdraw(Request $request) {
        $json = json_decode($request->getContent());
        $trx = new Trx(ICON_TO_BANK, "Withdraw to Bank", md5(time()));
        $trx->amount = $json->amount;
        $trx->status = STATUS_SUCCESS;
        $trx->message = "Withdraw to ".$json->bank->name.", account: ".$json->bank->account." is successful!";
        $trx->createdDate = date('Y-m-d h:i:s');
        return $trx->toJson();
    }

//    public function topUpManual1(Request $request) {
//        //$json = json_decode($request->getContent()); //for demo, input is not required
//        $response = array();
//        $digits = 3;
//        $response['unique'] = rand(pow(10, $digits-1), pow(10, $digits)-1);
//        return json_encode($response);
//    }

    public function topUpManual1(Request $request) {
        $json = json_decode($request->getContent()); //for demo, input is not required
        $digits = 3;

        $unique = rand(pow(10, $digits-1), pow(10, $digits)-1);
        $trx = new Trx(ICON_TOP_UP, "Top Up Manual", md5(time()));
        $trx->amount = $json->amount + $unique;
        $trx->status = STATUS_WAITING_FOR_TRANSFER;
        $trx->message = "Transfer to ".$json->bank->name;
        $trx->createdDate = date('Y-m-d H:i:s');
        $trx->expiredDate = date('Y-m-d 23:59:59', strtotime("+3 days"));
        $data = array();
        $data['unique'] = $unique;
        $data['bankName'] = $json->bank->name;
        $data['bankAccount'] = 1234567890;
        $data['bankAccountName'] = "PT Aplikasi Demo";
        $trx->data = $data;
        return $trx->toJson();
    }

    public function price(Request $request) {
        $json = json_decode($request->getContent());
        $code = $json->code; //product code
        $out = array();
        $out['price'] = 35000;

        return json_encode($out);
    }

    public function payment(Request $request) {
        $json = json_decode($request->getContent());
        $trx = new Trx(ICON_QR_PAY, "Payment QR", md5(time()));
        $trx->amount = $json->amount;
        $trx->status = STATUS_SUCCESS;
        $trx->message = $json->product." (".$json->code.")";
        $trx->createdDate = date('Y-m-d h:i:s');
        return $trx->toJson();
    }

    public function invoice(Request $request) {
        $json = json_decode($request->getContent());
        $digits = 3;
        $unique = rand(pow(10, $digits-1), pow(10, $digits)-1);

        $trx = new Trx(ICON_INVOICE, "Invoice", md5(time()));
        $trx->amount = $json->amount + $unique;
        $trx->status = STATUS_WAITING_FOR_TRANSFER;
        if (strlen($json->message) == 0) $json->message="-";
        $trx->message = "Catatan: ".$json->message;
        $trx->createdDate = date('Y-m-d h:i:s');
        $trx->expiredDate = date('Y-m-d 23:59:59', strtotime("+3 days"));
        $data = array();
        //$url = "http://10.0.2.2:8000/api/invoice";
        $url = "http://demo.sistemonline.biz.id/public/api/invoice";
        $url .= "/".base64_encode($trx->amount);
        $url .= "/".base64_encode($json->bankName);
        $url .= "/".base64_encode($json->bankAccount);
        $url .= "/".base64_encode($trx->expiredDate);
        $url .= "/".base64_encode($json->message);
        $data['url'] = $url;
        $trx->data = $data;

        return $trx->toJson();
    }

    public function getInvoice(Request $request, $amount, $bankName, $bankAccount, $expired,
                               $message) {
        $amount = base64_decode($amount);
        $content = view()->make("payment.invoice", ['amount' => Util::toCurrency($amount),
            'bankName' => base64_decode($bankName), 'bankAccount' => base64_decode($bankAccount),
            'expired' => base64_decode($expired), 'message' => base64_decode($message)]);
        $response = response()->make($content);
        $response->header('Content-type', 'image/jpeg');
        return $response;
    }

}
