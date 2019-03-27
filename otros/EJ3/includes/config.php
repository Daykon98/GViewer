<?php
/**
 * Configuración del soporte de UTF-8, localización (idioma y país)
*/
session_start();
ini_set('default_charset', 'UTF-8');
setLocale(LC_ALL, 'es_ES.UTF.8');
date_default_timezone_set('Europe/Madrid');