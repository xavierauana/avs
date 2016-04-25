<?php
/**
 * Author: Xavier Au
 * Date: 11/3/16
 * Time: 11:21 AM
 */

namespace App\dto;


class ajaxResponseDataObject
{
    public $code;
    public $message;
    public $data;

    /**
     * ajaxResponseDataObject constructor.
     * @param $code
     * @param $message
     */
    public function __construct($code=null, $message=null, $data=null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }


}