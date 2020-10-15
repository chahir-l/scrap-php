<?php 

namespace App;

interface GrapRequestInterface{

    public function execute();

    public function getMessage();

    public function init($element);
}