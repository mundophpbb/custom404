<?php
/**
 * File di lingua (Front-End) per l'estensione della pagina 404 personalizzata (Italiano)
 *
 * @package mundophpbb\custom404\language\it
 */
if (!defined('IN_PHPBB')) { exit; }
if (empty($lang) || !is_array($lang)) { $lang = []; }

$lang = array_merge($lang, [
    'CUSTOM404_DEFAULT_TITLE'       => '404 Non Trovato',
    'CUSTOM404_DEFAULT_MESSAGE'     => 'La pagina che stai cercando non è stata trovata.',
    'CUSTOM404_DEFAULT_IMAGE_ALT'   => 'Immagine di Errore 404',
    'L_RETURN_TO_INDEX'             => 'Torna all’Indice',
]);