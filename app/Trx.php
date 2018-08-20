<?php
/**
 * Created by PhpStorm.
 * User: Asus
 * Date: 8/1/2018
 * Time: 9:51 PM
 */

namespace App;

define('ICON_TOP_UP',0);
define('ICON_SEND_MONEY', 1);
define('ICON_CELULLAR',2);
define('ICON_PLN',3);
define('ICON_INVOICE',4);
define('ICON_TO_BANK',5);
define('ICON_QR_PAY',6);

define('STATUS_FAILED', 0);
define('STATUS_SUCCESS', 1);
define('STATUS_WAITING_FOR_TRANSFER', 2);

class Trx {

    public $iconId;
    public $title;
    public $amount;
    public $message;
    public $status;
    public $transactionId;
    public $createdDate;
    public $expiredDate;
    public $data; //additional data in json format

    public function __construct($iconId, $title, $transactionId) {
        $this->iconId = $iconId;
        $this->title = $title;
        $this->transactionId = $transactionId;
    }

    public function toJson() {
        return json_encode($this);
    }

} 