<?php

if (!function_exists('toAxios')) {
    /**
     * Returns json data for vue notification
     *
     * @param String $type
     * @param String $message
     * @param null|array $additional
     * @return false|string
     */
    function toAxios(String $type, String $message, Array $additional = null)
    {
        $data = [
            'type' => $type,
            'message' => $message
        ];

        return is_null($additional) ? json_encode($data) : json_encode(array_merge($data, $additional));
    }
}

if (!function_exists('app')) {
    /**
     * Return app
     *
     * @param $app
     * @return mixed
     */
    function app(\App\Vendor\Application\ApplicationInterface $app)
    {
        return $app->getApp();
    }
}

if (!function_exists('generateUrl')) {
    /**
     * Generates a redirect link
     *
     * @param $refer
     * @return string
     */
    function generateUrl($refer)
    {
        return "http://$_SERVER[HTTP_HOST]$_SERVER[REQUERST_URI]?r=$refer";
    }
}