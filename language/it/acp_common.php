<?php
/**
 * File di lingua ACP per l'estensione della pagina 404 personalizzata (Italiano)
 *
 * @package mundophpbb\custom404\language\it
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = [];
}

$lang = array_merge($lang, [
    // Interfaccia del modulo ACP
    'ACP_CUSTOM404_SHOW_IMAGE' => 'Mostra immagine sulla pagina 404',
    'ACP_CUSTOM404_SHOW_IMAGE_ON' => 'Abilitato',
    'ACP_CUSTOM404_SHOW_IMAGE_OFF' => 'Disabilitato',
    'ACP_CUSTOM404_CATEGORY' => 'Errore 404 personalizzato',
    'ACP_CUSTOM404_SETTINGS' => 'Impostazioni',
    'ACP_CUSTOM404_TITLE' => 'Pagina 404 personalizzata',
    'ACP_CUSTOM404_TITLE_LABEL' => 'Titolo della pagina 404',
    'ACP_CUSTOM404_MESSAGE_LABEL' => 'Messaggio della pagina 404',
    'ACP_CUSTOM404_IMAGE_ALT_LABEL' => 'Testo alternativo dell’immagine',
    'ACP_CUSTOM404_IMAGE_PATH_LABEL' => 'Immagine della pagina 404',
    'ACP_CUSTOM404_IMAGE_PATH_EXPLAIN' => 'Seleziona un’immagine dalla directory di caricamento dell’estensione.',
    'ACP_CUSTOM404_IMAGE_PREVIEW' => 'Anteprima dell’immagine',
    'ACP_CUSTOM404_IMAGE_UPLOAD' => 'Carica nuova immagine',
    'ACP_CUSTOM404_UPLOAD_INFO' => 'Formati consentiti: %s. Dimensione massima: %d MB.',
    'ACP_CUSTOM404_DEFAULT_IMAGE' => 'Immagine predefinita (404_error.png)',
    'ACP_CUSTOM404_CHOOSE_FILE' => 'Scegli file',
    'ACP_CUSTOM404_NO_FILE_CHOSEN' => 'Nessun file selezionato',
    'ACP_CUSTOM404_BBCODE_INFO' => 'Usa BBCode come [b]grassetto[/b], [i]corsivo[/i], [url]link[/url] o [img]immagine[/img] per formattare il messaggio.',
    'ACP_CUSTOM404_SAVED' => 'Impostazioni salvate con successo!',
    'ACP_CUSTOM404_IMAGE_UPLOADED' => 'Immagine caricata con successo!',
    'ACP_CUSTOM404_INVALID_FILE_TYPE' => 'Tipo di file non valido. Sono consentiti solo i formati %s.',
    'ACP_CUSTOM404_FILE_TOO_LARGE' => 'Il file supera la dimensione massima consentita di %d MB.',
    'ACP_CUSTOM404_UPLOAD_FAILED' => 'Caricamento dell’immagine fallito. Riprova.',
    'ACP_CUSTOM404_DELETE_IMAGE' => 'Elimina immagine',
    'ACP_CUSTOM404_DELETE_IMAGE_EXPLAIN' => 'Seleziona un’immagine da eliminare dalla directory di caricamento dell’estensione.',
    'ACP_CUSTOM404_DELETE' => 'Elimina',
    'ACP_CUSTOM404_DELETE_CONFIRM' => 'Sei sicuro di voler eliminare questa immagine?',
    'ACP_CUSTOM404_SELECT_IMAGE' => 'Seleziona immagine',
    'ACP_CUSTOM404_IMAGE_DELETED' => 'Immagine eliminata con successo!',
    'ACP_CUSTOM404_IMAGE_NOT_FOUND' => 'Immagine non trovata.',
    'ACP_CUSTOM404_INVALID_IMAGE' => 'Immagine selezionata non valida.',
    'ACP_CUSTOM404_PERMISSION_DENIED' => 'Permesso negato per eliminare l’immagine. Controlla i permessi del file.',
    'ACP_CUSTOM404_LOG_DIR_FAILED' => 'Impossibile creare la directory dei log. Controlla i permessi del server.',
    'ACP_CUSTOM404_UPLOAD_DIR_FAILED' => 'Impossibile creare la directory di caricamento. Controlla i permessi del server.',
    'ACP_CUSTOM404_DELETE_FAILED' => 'Eliminazione dell’immagine fallita: %s',
    'ACP_CUSTOM404_NO_IMAGE_SELECTED' => 'Nessuna immagine selezionata per l’eliminazione.',
    'ACP_CUSTOM404_OK' => 'OK',
    'ACP_CUSTOM404_THEME_LABEL' => 'Tema della pagina 404',
    'ACP_CUSTOM404_THEME_LIGHT' => 'Chiaro',
    'ACP_CUSTOM404_THEME_DARK' => 'Scuro',
    'ACP_CUSTOM404_DEBUG_MODE' => 'Modalità di debug',
    'ACP_CUSTOM404_DEBUG_EXPLAIN' => 'Abilita la modalità di debug per visualizzare informazioni aggiuntive nei log, facilitando la diagnosi di errori 404 e problemi di configurazione. Usare solo per scopi di sviluppo o risoluzione dei problemi.',
    'ACP_CUSTOM404_DEBUG_MODE_ON' => 'Disabilita modalità di debug',
    'ACP_CUSTOM404_DEBUG_MODE_OFF' => 'Abilita modalità di debug',
    'ACP_CUSTOM404_RESET_DEFAULT' => 'Ripristina predefinito',
    'ACP_CUSTOM404_RESET_CONFIRM' => 'Sei sicuro di voler ripristinare il titolo, il messaggio e il testo alternativo dell’immagine ai valori predefiniti?',
    'ACP_CUSTOM404_RESET_SUCCESS' => 'Impostazioni ripristinate ai valori predefiniti con successo!',
    'ACP_CUSTOM404_NO_LOGS_DELETED' => 'Nessun log eliminato, poiché non ci sono registrazioni più vecchie di 30 giorni.',
    'ACP_CUSTOM404_SEARCH_CLEARED' => 'Ricerca nei log cancellata con successo.',

    // Registrazione degli errori 404
    'ACP_CUSTOM404_LOGS' => 'Log degli errori 404',
    'ACP_CUSTOM404_URL' => 'URL richiesta',
    'ACP_CUSTOM404_IP_ADDRESS' => 'Indirizzo IP del cliente',
    'ACP_CUSTOM404_REQUEST_TIME' => 'Data/ora della richiesta',
    'ACP_CUSTOM404_REFERRER' => 'Origine',
    'ACP_CUSTOM404_USER_AGENT' => 'Agente utente',
    'ACP_CUSTOM404_NO_LOGS' => 'Nessun log di errori 404 trovato.',
    'ACP_CUSTOM404_EXPORT_LOGS' => 'Esporta log come CSV',
    'ACP_CUSTOM404_LOG_LIMIT' => 'Numero di log da visualizzare',
    'ACP_CUSTOM404_DELETE_LOGS' => 'Elimina tutti i log',
    'ACP_CUSTOM404_DELETE_LOGS_CONFIRM' => 'Sei sicuro di voler eliminare tutti i log degli errori 404 più vecchi di 30 giorni?',
    'ACP_CUSTOM404_LOGS_DELETED' => 'Log degli errori 404 eliminati con successo! (%d registrazioni rimosse)',
    'ACP_CUSTOM404_LOG_SEARCH' => 'Cerca nei log',
    'ACP_CUSTOM404_LOG_SEARCH_PLACEHOLDER' => 'Inserisci un URL, IP, origine o agente utente',
    'ACP_CUSTOM404_TOTAL_LOGS' => 'Totale log',
    'ACP_CUSTOM404_CLEAR_SEARCH' => 'Cancella ricerca',

    // Messaggio di errore di paginazione
    'ACP_CUSTOM404_PAGINATION_ERROR' => 'Errore nella generazione della paginazione dei log. Riprova o contatta il supporto.',

    // Aiuto per BBCode
    'BBCODE_B_HELP' => 'Grassetto: [b]testo[/b]',
    'BBCODE_I_HELP' => 'Corsivo: [i]testo[/i]',
    'BBCODE_U_HELP' => 'Sottolineato: [u]testo[/u]',
    'BBCODE_URL_HELP' => 'Link: [url=http://esempio.com]testo[/url] o [url]http://esempio.com[/url]',
    'BBCODE_IMG_HELP' => 'Immagine: [img]http://esempio.com/immagine.jpg[/img]',
    'BBCODE_QUOTE_HELP' => 'Citazione: [quote]testo[/quote]',
    'BBCODE_INSTRUCTIONS' => 'Usa BBCode per formattare il messaggio, come [b]grassetto[/b], [url]link[/url] o [img]immagine[/img].',

    // Valori predefiniti della pagina 404
    'CUSTOM404_DEFAULT_TITLE' => '404 - Pagina non trovata',
    'CUSTOM404_DEFAULT_MESSAGE' => 'Ops, la pagina che stai cercando non esiste!',
    'CUSTOM404_DEFAULT_IMAGE_ALT' => 'Immagine di errore 404',

    // Validazione del modulo
    'FORM_INVALID' => 'Modulo non valido. Riprova.',
    'FORM_TOKEN_MISSING' => 'Errore: Token del modulo non trovato.',
    'ACP_CUSTOM404_TITLE_REQUIRED' => 'Il titolo non può essere vuoto.',
    'ACP_CUSTOM404_MESSAGE_REQUIRED' => 'Il messaggio non può essere vuoto.',
    'ACP_CUSTOM404_TITLE_TOO_SHORT' => 'Il titolo deve contenere almeno 3 caratteri.',
    'ACP_CUSTOM404_MESSAGE_TOO_SHORT' => 'Il messaggio deve contenere almeno 3 caratteri.',

    // Pulsanti e interfaccia generale
    'ACP_CUSTOM404_UPLOAD_IMAGE' => 'Carica immagine',
    'ACP_CUSTOM404_SAVE_CHANGES' => 'Salva modifiche',
    'L_BACK_TO_INDEX' => 'Torna all’indice',
    'L_CANCEL' => 'Annulla',
]);