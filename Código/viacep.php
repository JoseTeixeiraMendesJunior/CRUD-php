<?php

$adress = (object) [
    'cep' => '',
    'logradouro' => '',
    'bairro' => '',
    'localidade' => '',
    'uf' => '',

];

if(isset($_POST['cep']))
    $ceps = $_POST['cep'];
    $url = "https://viacep.com.br/ws/{$ceps}/json/";

    $adress = json_decode(file_get_contents($url));


