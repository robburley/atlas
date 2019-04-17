<?php

namespace App\Helpers;


use Exception;

class FonoApi
{
    static $_ApiKey = null;
    static $_ApiUrl = "https://fonoapi.freshpixl.com/v1/";

    function __construct($ApiKey, $url = null)
    {
        if ($url != null) {
            self::$_ApiUrl = $url;
        }

        self::$_ApiKey = $ApiKey;
    }

    /**
     * Instaniate Self
     */
    public static function init($ApiKey)
    {
        return new self($ApiKey);
    }

    /**
     *
     * Gets Device Data Object from fonoapi.freshpixl.com
     *
     * @param      $device
     * @param null $position
     * @param null $brand
     *
     * @return mixed
     * @throws \Exception
     */
    public static function getDevice($device, $position = null, $brand = null)
    {
        $url = self::$_ApiUrl . "getdevice";

        $postData = [
            'brand'    => trim($brand),
            'device'   => trim($device),
            'position' => $position,
            'token'    => self::$_ApiKey
        ];

        $result = json_decode(self::sendPostData($url, $postData));

        if (isset($result->status)) {
            throw new Exception($result->message);
        } else {
            return $result;
        }
    }

    /**
     * Sends Post Data to the Server
     *
     * @param $url
     * @param $post
     *
     * @return mixed
     */
    static function sendPostData($url, $post)
    {
        try {

            $rUrl = null;

            if (isset($_SERVER['HTTP_HOST']) && $_SERVER['REQUEST_URI']) {
                $rUrl = "http" . (!empty($_SERVER['HTTPS']) ? "s" : "") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            }

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_REFERER, $rUrl);
            $result = curl_exec($ch);

            if (false === $result) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }

            curl_close($ch);

            return $result;

        } catch (Exception $e) {

            $result["status"] = $e->getCode();
            $result["message"] = "Curl Failed";
            $result["innerException"] = $e->getMessage();

            return json_encode($result);
        }
    }
}