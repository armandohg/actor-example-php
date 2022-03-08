<?php

$urls = [
    "https://articulo.mercadolibre.com.mx/MLM-631622539-ventilador-raspberry-pi3-b-30x30x10mm-tornillos-tuercas-_JM",
    "https://articulo.mercadolibre.com.mx/MLM-675796019-ventilador-raspberry-pi-3007-30x30x7mm-5v-_JM#position=1&search_layout=stack&type=item&tracking_id=a9b7579c-2a4d-4f15-92ef-27df9a2fb2ac",
    "https://articulo.mercadolibre.com.mx/MLM-697929784-ventilador-5v-30mm-con-conector-dupont-_JM"
];

print "Starting ...\n";
print "ENV vars:\n";
print_r($_ENV);

foreach ($urls as $url) {
    print "Fetching {$url} ...\n";

    $regex = '/[A-Z]{3}-\d+/m';
    preg_match_all($regex, $url, $matches, PREG_SET_ORDER, 0);
    $mid = str_replace('-', '', $matches[0][0]);

    $body = file_get_contents($url);
    $body = accent2ascii($body);

    preg_match("/availableStock\":(\d+)/", $body, $matches);
    $stock = (int)$matches[1];

    preg_match("/localItemPrice\":(\d+)/", $body, $matches);
    $price = (float)$matches[1];

    preg_match('/item_name\":\"(.*?)\"/i', $body, $matches);
    $name = $matches[1];

    var_dump([
        'url' => $url,
        'sku' => $mid,
        'name' => $name,
        'stock' => $stock,
        'price' => $price,
    ]);
}

print "I am done!\n";


function accent2ascii(string $str): string
{
    $unwanted_array = array('Š' => 'S', 'š' => 's', 'Ž' => 'Z', 'ž' => 'z', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
        'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U',
        'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
        'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'þ' => 'b', 'ÿ' => 'y');
    $str = strtr($str, $unwanted_array);

    return $str;
}
