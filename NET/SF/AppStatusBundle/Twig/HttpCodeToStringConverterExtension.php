<?php

namespace NET\SF\AppStatusBundle\Twig;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HttpCodeToStringConverterExtension
 *
 * @author latinmad
 */
class HttpCodeToStringConverterExtension extends \Twig_Extension {

    public function getFilters() {
        return array(
            new \Twig_SimpleFilter("httpCodeToStringConverter", array($this, "httpCodeToStringConverter")),
        );
    }

    public function httpCodeToStringConverter($codeHttp) {
        switch ($codeHttp) {
            case 200:
                $message = "OK";
                break;
            case 400:
                $message = "Bad Request";
                break;            
            case 403:
                $message = "Forbidden";
                break;            
            case 404:
                $message = "Not found";
                break;
            case 405:
                $message = "Method Not Allowed";
                break;
            case 500:
                $message = "Internal Server Error";
                break;            
            case 503:
                $message = "Service Unavailable";
                break;            
            case 0:
                $message = "Connection timed out";
                break;
            default:
                $message = "Code Not exist";
                break;
        }
        return $message;
    }

}
