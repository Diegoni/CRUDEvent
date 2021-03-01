<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}
$ci =& get_instance();
$path = 'application/helpers/';
$dir = 'variables/';
$extension = '_helper.php';
$files = glob($path.$dir.'*'.$extension);
foreach ($files as $file) {
    $ci->load->helper(str_replace($extension, "", str_replace($path, "", $file)));
}

abstract class VARIABLES
{
    const RUTINAS_DETALLES_TIPOS = 1;
    const RUTINAS_DETALLES_DESCRIPCIONES = 2;
    const TIPOS_IVA = 3;
    const COMPROBANTES = 4;
    const CONDICIONES_IVA = 5;
    const ESTADOS_DEVOLUCIONES = 6;
    const ESTADOS_PRESUPUESTOS = 7;
    const TIPOS_PAGOS = 8;
    const VENDEDORES = 9;
    const PERMISOS = 10;
    const ESTADOS = 11;
    const ARTICULOS_CATEGORIAS = 12;
    const TIPOS_DASHBOARDS = 13;
    const TIPOS_CHARTS_WIDGETS = 14;
    const TIPOS_LOGS = 15;
    const MIN_SCORE_RECAPTCHA = 16;
    const DATOS_EMPRESA_CLIENTE = 17;
}
