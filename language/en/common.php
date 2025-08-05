<?php
/**
 * Front-End Language File for Custom 404 Page Extension (English)
 *
 * @package mundophpbb\custom404\language\en
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = [];
}

$lang = array_merge($lang, [
    // Default 404 Page Values
    'CUSTOM404_DEFAULT_TITLE'       => '404 - Page Not Found',
    'CUSTOM404_DEFAULT_MESSAGE'     => 'Oops, the page you’re looking for doesn’t exist!',
    'CUSTOM404_DEFAULT_IMAGE_ALT'   => '404 Error Image',
    'L_RETURN_TO_INDEX'             => 'Return to Index',
]);