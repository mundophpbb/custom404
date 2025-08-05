<?php
/**
 * Fichier de langue ACP pour l'extension de page 404 personnalisée (Français)
 *
 * @package mundophpbb\custom404\language\fr
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = [];
}

$lang = array_merge($lang, [
    // Interface du module ACP
    'ACP_CUSTOM404_SHOW_IMAGE' => 'Afficher une image sur la page 404',
    'ACP_CUSTOM404_SHOW_IMAGE_ON' => 'Activé',
    'ACP_CUSTOM404_SHOW_IMAGE_OFF' => 'Désactivé',
    'ACP_CUSTOM404_CATEGORY' => 'Erreur 404 personnalisée',
    'ACP_CUSTOM404_SETTINGS' => 'Paramètres',
    'ACP_CUSTOM404_TITLE' => 'Page 404 personnalisée',
    'ACP_CUSTOM404_TITLE_LABEL' => 'Titre de la page 404',
    'ACP_CUSTOM404_MESSAGE_LABEL' => 'Message de la page 404',
    'ACP_CUSTOM404_IMAGE_ALT_LABEL' => 'Texte alternatif de l’image',
    'ACP_CUSTOM404_IMAGE_PATH_LABEL' => 'Image de la page 404',
    'ACP_CUSTOM404_IMAGE_PATH_EXPLAIN' => 'Sélectionnez une image dans le répertoire de téléchargement de l’extension.',
    'ACP_CUSTOM404_IMAGE_PREVIEW' => 'Aperçu de l’image',
    'ACP_CUSTOM404_IMAGE_UPLOAD' => 'Télécharger une nouvelle image',
    'ACP_CUSTOM404_UPLOAD_INFO' => 'Formats autorisés : %s. Taille maximale : %d Mo.',
    'ACP_CUSTOM404_DEFAULT_IMAGE' => 'Image par défaut (404_error.png)',
    'ACP_CUSTOM404_CHOOSE_FILE' => 'Choisir un fichier',
    'ACP_CUSTOM404_NO_FILE_CHOSEN' => 'Aucun fichier sélectionné',
    'ACP_CUSTOM404_BBCODE_INFO' => 'Utilisez BBCode comme [b]gras[/b], [i]italique[/i], [url]lien[/url] ou [img]image[/img] pour formater le message.',
    'ACP_CUSTOM404_SAVED' => 'Paramètres enregistrés avec succès !',
    'ACP_CUSTOM404_IMAGE_UPLOADED' => 'Image téléchargée avec succès !',
    'ACP_CUSTOM404_INVALID_FILE_TYPE' => 'Type de fichier invalide. Seuls les formats %s sont autorisés.',
    'ACP_CUSTOM404_FILE_TOO_LARGE' => 'Le fichier dépasse la taille maximale autorisée de %d Mo.',
    'ACP_CUSTOM404_UPLOAD_FAILED' => 'Échec du téléchargement de l’image. Veuillez réessayer.',
    'ACP_CUSTOM404_DELETE_IMAGE' => 'Supprimer l’image',
    'ACP_CUSTOM404_DELETE_IMAGE_EXPLAIN' => 'Sélectionnez une image à supprimer dans le répertoire de téléchargement de l’extension.',
    'ACP_CUSTOM404_DELETE' => 'Supprimer',
    'ACP_CUSTOM404_DELETE_CONFIRM' => 'Êtes-vous sûr de vouloir supprimer cette image ?',
    'ACP_CUSTOM404_SELECT_IMAGE' => 'Sélectionner une image',
    'ACP_CUSTOM404_IMAGE_DELETED' => 'Image supprimée avec succès !',
    'ACP_CUSTOM404_IMAGE_NOT_FOUND' => 'Image non trouvée.',
    'ACP_CUSTOM404_INVALID_IMAGE' => 'Image sélectionnée invalide.',
    'ACP_CUSTOM404_PERMISSION_DENIED' => 'Permission refusée pour supprimer l’image. Vérifiez les autorisations du fichier.',
    'ACP_CUSTOM404_LOG_DIR_FAILED' => 'Échec de la création du répertoire de journaux. Vérifiez les autorisations du serveur.',
    'ACP_CUSTOM404_UPLOAD_DIR_FAILED' => 'Échec de la création du répertoire de téléchargement. Vérifiez les autorisations du serveur.',
    'ACP_CUSTOM404_DELETE_FAILED' => 'Échec de la suppression de l’image : %s',
    'ACP_CUSTOM404_NO_IMAGE_SELECTED' => 'Aucune image sélectionnée pour la suppression.',
    'ACP_CUSTOM404_OK' => 'OK',
    'ACP_CUSTOM404_THEME_LABEL' => 'Thème de la page 404',
    'ACP_CUSTOM404_THEME_LIGHT' => 'Clair',
    'ACP_CUSTOM404_THEME_DARK' => 'Sombre',
    'ACP_CUSTOM404_DEBUG_MODE' => 'Mode de débogage',
    'ACP_CUSTOM404_DEBUG_EXPLAIN' => 'Active le mode de débogage pour afficher des informations supplémentaires dans les journaux, facilitant le diagnostic des erreurs 404 et des problèmes de configuration. À utiliser uniquement à des fins de développement ou de dépannage.',
    'ACP_CUSTOM404_DEBUG_MODE_ON' => 'Désactiver le mode de débogage',
    'ACP_CUSTOM404_DEBUG_MODE_OFF' => 'Activer le mode de débogage',
    'ACP_CUSTOM404_RESET_DEFAULT' => 'Réinitialiser par défaut',
    'ACP_CUSTOM404_RESET_CONFIRM' => 'Êtes-vous sûr de vouloir réinitialiser le titre, le message et le texte alternatif de l’image aux valeurs par défaut ?',
    'ACP_CUSTOM404_RESET_SUCCESS' => 'Paramètres réinitialisés aux valeurs par défaut avec succès !',
    'ACP_CUSTOM404_NO_LOGS_DELETED' => 'Aucun journal n’a été supprimé, car il n’y a pas d’enregistrements datant de plus de 30 jours.',
    'ACP_CUSTOM404_SEARCH_CLEARED' => 'Recherche de journaux effacée avec succès.',

    // Journalisation des erreurs 404
    'ACP_CUSTOM404_LOGS' => 'Journaux des erreurs 404',
    'ACP_CUSTOM404_URL' => 'URL demandée',
    'ACP_CUSTOM404_IP_ADDRESS' => 'Adresse IP du client',
    'ACP_CUSTOM404_REQUEST_TIME' => 'Date/heure de la demande',
    'ACP_CUSTOM404_REFERRER' => 'Origine',
    'ACP_CUSTOM404_USER_AGENT' => 'Agent utilisateur',
    'ACP_CUSTOM404_NO_LOGS' => 'Aucun journal d’erreur 404 trouvé.',
    'ACP_CUSTOM404_EXPORT_LOGS' => 'Exporter les journaux au format CSV',
    'ACP_CUSTOM404_LOG_LIMIT' => 'Nombre de journaux à afficher',
    'ACP_CUSTOM404_DELETE_LOGS' => 'Supprimer tous les journaux',
    'ACP_CUSTOM404_DELETE_LOGS_CONFIRM' => 'Êtes-vous sûr de vouloir supprimer tous les journaux d’erreurs 404 datant de plus de 30 jours ?',
    'ACP_CUSTOM404_LOGS_DELETED' => 'Journaux d’erreurs 404 supprimés avec succès ! (%d enregistrements supprimés)',
    'ACP_CUSTOM404_LOG_SEARCH' => 'Rechercher dans les journaux',
    'ACP_CUSTOM404_LOG_SEARCH_PLACEHOLDER' => 'Entrez une URL, une IP, une origine ou un agent utilisateur',
    'ACP_CUSTOM404_TOTAL_LOGS' => 'Total des journaux',
    'ACP_CUSTOM404_CLEAR_SEARCH' => 'Effacer la recherche',

    // Message d’erreur de pagination
    'ACP_CUSTOM404_PAGINATION_ERROR' => 'Erreur lors de la génération de la pagination des journaux. Veuillez réessayer ou contacter le support.',

    // Aide pour BBCode
    'BBCODE_B_HELP' => 'Gras : [b]texte[/b]',
    'BBCODE_I_HELP' => 'Italique : [i]texte[/i]',
    'BBCODE_U_HELP' => 'Souligné : [u]texte[/u]',
    'BBCODE_URL_HELP' => 'Lien : [url=http://exemple.com]texte[/url] ou [url]http://exemple.com[/url]',
    'BBCODE_IMG_HELP' => 'Image : [img]http://exemple.com/image.jpg[/img]',
    'BBCODE_QUOTE_HELP' => 'Citation : [quote]texte[/quote]',
    'BBCODE_INSTRUCTIONS' => 'Utilisez BBCode pour formater le message, comme [b]gras[/b], [url]lien[/url] ou [img]image[/img].',

    // Valeurs par défaut de la page 404
    'CUSTOM404_DEFAULT_TITLE' => '404 - Page non trouvée',
    'CUSTOM404_DEFAULT_MESSAGE' => 'Oups, la page que vous recherchez n’existe pas !',
    'CUSTOM404_DEFAULT_IMAGE_ALT' => 'Image d’erreur 404',

    // Validation de formulaire
    'FORM_INVALID' => 'Formulaire invalide. Veuillez réessayer.',
    'FORM_TOKEN_MISSING' => 'Erreur : Jeton de formulaire introuvable.',
    'ACP_CUSTOM404_TITLE_REQUIRED' => 'Le titre ne peut pas être vide.',
    'ACP_CUSTOM404_MESSAGE_REQUIRED' => 'Le message ne peut pas être vide.',
    'ACP_CUSTOM404_TITLE_TOO_SHORT' => 'Le titre doit comporter au moins 3 caractères.',
    'ACP_CUSTOM404_MESSAGE_TOO_SHORT' => 'Le message doit comporter au moins 3 caractères.',

    // Boutons et interface générale
    'ACP_CUSTOM404_UPLOAD_IMAGE' => 'Télécharger une image',
    'ACP_CUSTOM404_SAVE_CHANGES' => 'Enregistrer les modifications',
    'L_BACK_TO_INDEX' => 'Retour à l’accueil',
    'L_CANCEL' => 'Annuler',
]);