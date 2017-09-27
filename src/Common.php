<?php

namespace OpenHacienda;

class Common  
{
    /* ATRIBUTOS */
    CONST CODIGO_PAIS = '506';

    CONST FACTURA = '01';
    CONST NOTA_DEBITO = '02';
    CONST NOTA_CREDITO = '03';
    CONST TIQUETE = '04';
    CONST CONFIRM_OK_COMPROBANTE = '05';
    CONST CONFIRM_PARCIAL_COMPROBANTE = '06';
    CONST CONFIRM_RECHAZO_COMPROBANTE = '07';
    
    /* METODOS PUBLICOS */
    
    /**
     * Generar una clave númerica basada en los sigiuentes requerimientos
     *
     * 1) Los primeros tres dígitos corresponden al código del país (506).
     * 2) Del cuarto al quinto dígito, corresponde al día en que se genere el comprobante electrónico
     * 3) Del sexto al séptimo dígito, corresponde al mes en que se genere el comprobante electrónico
     * 4) Del octavo al noveno dígito, corresponde al año en que se genere el comprobante electrónico
     * 5) Del décimo al vigésimo primero dígito, corresponde al número de cédula del emisor.
     * 6) Del vigésimo segundo al cuadragésimo primero dígito, corresponde a la numeración consecutiva del comprobante
     *    electrónico.
     * 7) El cuadragésimo segundo le corresponde a la situación del comprobante electrónico para el cual se debe de 
     *    utilizar la siguiente codificación:
     * 
     *     CÓDIGO   SITUACIÓN DEL COMPROBANTE   DESCRIPCIÓN
     *              ELECTRÓNICO
     * 
     *       1      NORMAL                      Corresponde aquellos comprobantes electrónicos que
     *                                          son generados y transmitidos en el mismo acto de
     *                                          compraventa y prestación del servicio al sistema de
     *                                          validación de comprobantes electrónicos de la
     *                                          Dirección General de Tributación, conforme con lo
     *                                          establecido en la presente resolución.
     * 
     *       2      CONTINGENCIA                Corresponde aquellos comprobantes electrónicos que 
     *                                          sustituyen al comprobante físico emitido por 
     *                                          contingencia, conforme lo estipulado en el artículo 15
     *                                          de la presente resolución. 
     * 
     *       3      SIN INTERNET                Corresponde aquellos comprobantes que han sido 
     *                                          generados y expresados en formato electrónico
     *                                          conforme lo establecido en la presente resolución,
     *                                          pero no se cuenta con el respectivo acceso a internet 
     *                                          para el envío inmediato de los mismos a la Dirección
     *                                          General de Tributación, esto conforme lo indicado en
     *                                          el artículo 9 párrafo segundo de la presente 
     *                                          resolución.
     * 8) Del cuadragésimo tercero al quincuagésimo dígito, corresponde al código de seguridad, el cual debe ser 
     *    generado por el sistema del obligado tributario.             
     * 
     * @param string $fechaComprobante  Fecha en que se generó la factura electrónica
     * @return string
     * 
     */
    public static function generarClave($fechaEmision, $numeroIdentificacion, $tipoDocumento, $consecutivo)
    {
        $clave = self::CODIGO_PAIS;
        $clave .= str_replace('-', '', $fechaEmision);
        $clave .= $numeroIdentificacion;
        $clave .= self::generarConsecutivo($tipoDocumento, $consecutivo);

        return $clave;
    }

    
    public static function generarConsecutivo($tipoDocumento, $consecutivo, $establecimiento = '1', $pos = '1')
    {
        return str_pad($establecimiento, 4, '0', STR_PAD_LEFT) . str_pad($pos, 5, '0', STR_PAD_LEFT) . $tipoDocumento . str_pad($consecutivo, 10, '0', STR_PAD_LEFT);
    }

    /**
     * Validador de tipos de identificaciones 
     * Formatos soportados:
     *      Persona Física Nacional (Cédula de Identidad)       0P-TTTT-AAAA (12) 0401670661
     *      Persona Física Residente (Cédula de Residencia)     1NNN-CC...C-EE...E (12)
     *      Gobierno Central                                    2-PPP-CCCCCC (12)
     *      Persona Jurídica                                    3-TTT-CCCCCC (12)
     *      Institución Autónoma                                4-000-CCCCCC (12)
     * 
     * http://www.hacienda.go.cr/consultapagos/ayuda_cedulas.htm
     * 
     * @param string $id Identificación del emisor/receptor
     * @return string
     */
    public static function validarId($id) 
    {
        /**
         * Indica si la identificación del emisor/receptor tiene "-"
         * 
         * @return boolean
         */   
        $dash = (strpos($id, '-'));
        $lenId = strlen($id);

        if ($dash) {
            
            /* Si el id contiene 12 caracteres y el primer digito es 1 es porque es una persona 
            física con número de perosna fisica de residencia */
            if ($lenId == 12 && substr($id, 0, 1) == 1) {
                # CEDULAS RESIDENCIA

            } elseif ($lenId == 9 ) {
                # CEDULAS FISICAS
                $id = '000' . str_replace('-', '0', $id);
            } elseif ($lenId == 12) {
                # CEDULAS JURIDICAS
                $id = '00' . str_replace('-', '', $id);
            }
        } else {
            
        } 

        return $id;
    }

    /* METODOS PRIVADOS */
}
