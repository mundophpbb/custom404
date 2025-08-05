<?php
/**
 * Fichier de langue (Front-End) pour l'extension de page 404 personnalisée (Français)
 *
 * @package mundophpbb\custom404\language\fr
 */
if (!defined('IN_PHPBB')) { exit; }
if (empty($lang) || !is_array($lang)) { $lang = []; }

$lang = array_merge($lang, [
    'CUSTOM404_DEFAULT_TITLE'       => '404 Non Trouvé',
    'CUSTOM404_DEFAULT_MESSAGE'     => 'La page que vous cherchez n’a pas été trouvée.',
    'CUSTOM404_DEFAULT_IMAGE_ALT'   => 'Image d’Erreur 404',
    'L_RETURN_TO_INDEX'             => 'Retour à l’Accueil',
]);