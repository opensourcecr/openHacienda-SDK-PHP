<?php

namespace OpenHacienda;

use OpenHacienda\Common;

/**
 * Clase para generar Facturas Electrónicas 
 * 
 * @package clase
 * @author Open Source Costa Rica <opensource.lat@email.com>
 * @version 1.0.0
 * @license MIT
 * @copyright 2017 (c) Open Source Costa Rica
 * 
 */

class Factura 
{
    /* ATRIBUTOS */

    /**
     * Corresponde a la clave del comprobante. Es un campo de 50 posiciones y se tiene que utilizar para la consulta 
     * del código QR. Ver nota 1 y 4.1
     * 
     * @var string $clave
     */
    private $clave;
    
    /**
     * Numeración consecutiva del comprobante
     *
     * @var string $numeroConsecutivo
     */
    private $numeroConsecutivo;

    /**
     * Undocumented variable
     *
     * @var string $fechaEmision
     */
    private $fechaEmision;

    /**
     * Undocumented variable
     *
     * @var string $emisor
     */
    private $emisor;

    /**
     * Undocumented variable
     *
     * @var string $receptor
     */
    private $receptor;

    /**
     * Undocumented variable
     *
     * @var string $condicionVenta
     */
    private $condicionVenta;

    /**
     * Undocumented variable
     *
     * @var string $plazoCredito
     */
    private $plazoCredito;

    /**
     * Undocumented variable
     *
     * @var string $medioPago
     */
    private $medioPago;

    /**
     * Undocumented variable
     *
     * @var string $detalleServicio
     */
    private $detalleServicio;

    /**
     * Undocumented variable
     *
     * @var string $resumenFactura
     */
    private $resumenFactura;

    /**
     * Undocumented variable
     *
     * @var string $normativa
     */
    private $normativa;

    /**
     * Undocumented variable
     *
     * @var string $otros
     */
    private $otros;

    /**
     * Undocumented variable
     *
     * @var string $signature
     */
    private $signature;

    /**
     * Undocumented variable
     *
     * @var string $establecimiento
     */
    private $establecimiento;


    public function __construct($emisorId, $receptorId, $numeroConsecutivo, $fechaEmision = '') 
    {

        $this->emisor = Common::validarId($emisorId);
        $this->receptor = Common::validarId($receptorId);
        $this->numeroConsecutivo = $numeroConsecutivo;
        $this->fechaEmision = ($fechaEmision == '') ? date('dmY') : $fechaEmision;
    }


    /* METODOS PUBLICOS */

    /**
     * Se obtiene la estructura de la clave
     * https://tribunet.hacienda.go.cr/docs/esquemas/2016/v4.1/Resolucion_Comprobantes_Electronicos_DGT-R-48-2016_v4.1.pdf
     * Página 7, Artículo 5° [Clave numérica]
     *
     * @param string $fechaComprobante Fecha en que se generó la factura electrónica (dd-mm-yyyy)
     * @return stting
     */
    public function getClave()
    {   
        $this->clave = Common::generarClave($this->fechaEmision, $this->emisor, Common::FACTURA, $this->numeroConsecutivo); 
        return $this;
    }

    public function imprimir()
    {
        echo 'Clave......: ', $this->clave, "\n";
        echo 'Emisor.....: ', $this->emisor, "\n";
        echo 'Receptor...: ', $this->receptor, "\n";
        echo 'Consecutivo: ', $this->numeroConsecutivo, "\n";
        echo "------------------------------ \n";
    }

    /* METODOS PRIVATOS */

}