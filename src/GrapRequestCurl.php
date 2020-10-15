<?php

namespace App;

use App\GrapRequestInterface;

class GrapRequestCurl implements GrapRequestInterface
{
    private $link;

    private $ressource;

    private $message;

    public function __construct()
    {}

    public function init($link)
    {
        $this->ressource = curl_init($link);
        curl_setopt($this->ressource, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ressource, CURLOPT_SSL_VERIFYPEER, 0);
        return $this;
    }

    public function execute()
    {
        if (curl_exec($this->ressource)) {
            $infos = curl_getinfo($this->ressource);
            $this->message = $this->formatMessage($infos);
        } else {
            $this->message = 'Erreur Curl : ' . curl_error($this->ressource);
        }

        return $this;
    }

    public function getMessage()
    {
        return $this->message;
    }

    private function formatMessage($infos)
    {
        return sprintf("Chargé en %s secondes pour la requete %s  <br />",
            $infos['total_time'],
            $infos['url']
        );
    }

}
