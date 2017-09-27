<?php

require_once __DIR__ . '/vendor/autoload.php';

use OpenHacienda\Factura;

$fechaEmision = '01-01-2016';
$numeroCedulaEmisor = '3-101-570764';
$numeroCedulaReceptor = '4-167-661';
$numeroCedulaResidente = '172400110315';
$miNumeroConsecutivo = 8912;

$factura1 = new Factura($numeroCedulaEmisor, $numeroCedulaReceptor, $miNumeroConsecutivo, $fechaEmision);
$factura2 = new Factura($numeroCedulaResidente, $numeroCedulaReceptor, $miNumeroConsecutivo);

try {
    $factura1->getClave($fechaEmision)
            ->imprimir();

    $factura2->getClave()
    ->imprimir();

} catch (\Exception $e) {
    echo "Error ", $e->message(), "\n";
}