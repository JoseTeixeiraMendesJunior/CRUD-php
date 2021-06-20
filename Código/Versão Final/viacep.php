<?php
function getAddres() {


    if(isset($_POST['cep'])) {
        $ceps = $_POST['cep'];

        $ceps = filterCep($ceps);

        if(isCep($ceps)) {
            $address = getAddressViaCep($ceps);
            if(property_exists($address,'erro')) {
                $address = addresEmpty();
                $address->cep = 'CEP não encontrado!';
            }
        } else {
            $address = addresEmpty();
            $address->cep = 'CEP inválido!';
        }
    } else {
        $address = addresEmpty();
    }

    return $address;
}

function addresEmpty () {
    return (object) [
        'cep' => '',
        'logradouro' => '',
        'bairro' => '',
        'localidade' => '',
        'uf' => ''
    ];
}

function filterCep (String $ceps):String {
    //exlcui caracteres indesejados do cep recebido
 return preg_replace('/[^0-9]/','',$ceps);
}
function isCep(String $ceps):bool {
    // confere se o cep tem formato válido
    return preg_match('/^[0-9]{5}-?[0-9]{3}$/',$ceps);
}
function getAddressViaCep (String $ceps) {
    //faz a consulta ao via cep e retorna um objeto com os dados
    $url = "https://viacep.com.br/ws/{$ceps}/json/";
    return json_decode(file_get_contents($url));
}