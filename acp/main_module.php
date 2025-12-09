<?php
namespace mundophpbb\custom404\acp;
class main_module
{
    public $u_action;
    public $tpl_name = '@mundophpbb_custom404/acp_custom404';
    public $page_title = 'ACP_CUSTOM404_TITLE';
    protected $user;
    protected $language;
    protected $filesystem;
    protected $phpbb_container;
    protected $log;
    public function main($id, $mode)
    {
        global $phpbb_container;
        try {
            // Inicializar dependências
            $this->phpbb_container = $phpbb_container;
            $this->filesystem = $phpbb_container->get('filesystem');
            $this->user = $phpbb_container->get('user');
            $this->language = $phpbb_container->get('language');
            $this->log = $phpbb_container->get('log');
            $request = $phpbb_container->get('request');
            $config = $phpbb_container->get('config');
            $template = $phpbb_container->get('template');
            $upload_handler = $phpbb_container->get('mundophpbb.custom404.upload');
            $db = $phpbb_container->get('dbal.conn');
            $debug_mode = $config['custom404_debug_mode'] ?? false;
            // Configurar logging apenas se o modo de depuração estiver ativado
            $log_dir = $this->phpbb_container->getParameter('core.root_path') . 'ext/mundophpbb/custom404/logs/';
            $log_file = $log_dir . 'debug.log';
            if ($debug_mode) {
                if (!$this->filesystem->exists($log_dir)) {
                    try {
                        $this->filesystem->mkdir($log_dir, 0755);
                        if (!$this->filesystem->exists($log_dir)) {
                            throw new \Exception('Failed to create log directory');
                        }
                    } catch (\Exception $e) {
                        $error_message = $this->language->lang('ACP_CUSTOM404_LOG_DIR_FAILED');
                        // Em vez de error_log, usar o log do phpBB se possível
                        $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CUSTOM404_ERROR_CREATING_DIR', time(), array($e->getMessage()));
                    }
                }
                ini_set('log_errors', 1);
                ini_set('error_log', $log_file);
                error_reporting(E_ALL & ~E_NOTICE);
                // Registrar idioma do usuário em modo de depuração
                error_log('ACP: User Language at Start: ' . ($this->user->lang_name ?: 'undefined'), 3, $log_file);
            }
            $this->load_language_files($debug_mode);
            // Adicionar tokens de formulário
            add_form_key('mundophpbb_custom404');
            add_form_key('mundophpbb_custom404_delete');
            if ($debug_mode) {
                error_log('Form keys generated: mundophpbb_custom404, mundophpbb_custom404_delete', 3, $log_file);
            }
            $upload_dir = $this->phpbb_container->getParameter('core.root_path') . 'ext/mundophpbb/custom404/uploads/';
            $allowed_extensions = ['png', 'jpg', 'jpeg', 'gif'];
            $max_file_size = 2 * 1024 * 1024; // 2 MB
            if (!$this->filesystem->exists($upload_dir)) {
                try {
                    $this->filesystem->mkdir($upload_dir, 0755);
                } catch (\Exception $e) {
                    $error_message = $this->language->lang('ACP_CUSTOM404_UPLOAD_DIR_FAILED');
                    if ($debug_mode) {
                        error_log("Error creating upload directory: " . $e->getMessage(), 3, $log_file);
                    }
                }
            }
            $success_message = '';
            $error_message = '';
            // Manipular exclusão de imagem
            if ($request->is_set_post('delete_image')) {
                if ($debug_mode) {
                    error_log("Delete image action triggered, delete_image_path: " . $request->variable('delete_image_path', ''), 3, $log_file);
                    error_log("Form token received: " . $request->variable('form_token', 'none'), 3, $log_file);
                }
                if (!check_form_key('mundophpbb_custom404_delete')) {
                    $error_message = $this->language->lang('FORM_INVALID');
                    if ($debug_mode) {
                        error_log("Form key validation failed for delete_image", 3, $log_file);
                    }
                } else {
                    $image_to_delete = $request->variable('delete_image_path', '');
                    if ($image_to_delete && $image_to_delete !== 'ext/mundophpbb/custom404/uploads/404_error.png') {
                        $image_full_path = $this->filesystem->realpath($this->phpbb_container->getParameter('core.root_path') . $image_to_delete);
                        if ($debug_mode) {
                            error_log("Attempting to delete image: $image_to_delete, resolved path: $image_full_path", 3, $log_file);
                        }
                        if ($image_full_path && $this->filesystem->exists($image_full_path)) {
                            if ($this->filesystem->is_writable($image_full_path)) {
                                try {
                                    $this->filesystem->remove($image_full_path);
                                    if ($config['custom404_image_path'] === $image_to_delete) {
                                        $config->set('custom404_image_path', 'ext/mundophpbb/custom404/uploads/404_error.png');
                                    }
                                    $success_message = $this->language->lang('ACP_CUSTOM404_IMAGE_DELETED');
                                    if ($debug_mode) {
                                        error_log("Image deleted successfully: $image_full_path", 3, $log_file);
                                    }
                                } catch (\Exception $e) {
                                    $error_message = $this->language->lang('ACP_CUSTOM404_DELETE_FAILED', $e->getMessage());
                                    if ($debug_mode) {
                                        error_log("Failed to delete image: " . $e->getMessage(), 3, $log_file);
                                    }
                                }
                            } else {
                                $error_message = $this->language->lang('ACP_CUSTOM404_PERMISSION_DENIED');
                                if ($debug_mode) {
                                    error_log("Permission denied when attempting to delete file: $image_full_path", 3, $log_file);
                                }
                            }
                        } else {
                            $error_message = $this->language->lang('ACP_CUSTOM404_IMAGE_NOT_FOUND');
                            if ($debug_mode) {
                                error_log("File not found or invalid path: $image_full_path", 3, $log_file);
                            }
                        }
                    } else {
                        $error_message = $this->language->lang('ACP_CUSTOM404_INVALID_IMAGE');
                        if ($debug_mode) {
                            error_log("Invalid image selected for deletion: $image_to_delete", 3, $log_file);
                        }
                    }
                }
                $request->overwrite('log_limit', null);
                $request->overwrite('log_search', null);
            }
            // Manipular upload de imagem
            if ($request->is_set_post('upload')) {
                if ($debug_mode) {
                    error_log("Upload image action triggered, form_token: " . $request->variable('form_token', 'none'), 3, $log_file);
                }
                try {
                    $uploaded_file = $request->file('custom404_image_upload');
                    $ext = strtolower(pathinfo($uploaded_file['name'], PATHINFO_EXTENSION));
                    if (!in_array($ext, $allowed_extensions)) {
                        throw new \Exception($this->language->lang('ACP_CUSTOM404_INVALID_FILE_TYPE', implode(', ', array_map('strtoupper', $allowed_extensions))));
                    }
                    $new_image_path = $upload_handler->handle_upload($uploaded_file, $upload_dir, $allowed_extensions, $max_file_size);
                    if ($new_image_path) {
                        $relative_image_path = 'ext/mundophpbb/custom404/uploads/' . basename($new_image_path);
                        $config->set('custom404_image_path', $relative_image_path);
                        $success_message = $this->language->lang('ACP_CUSTOM404_IMAGE_UPLOADED');
                    }
                } catch (\Exception $e) {
                    $error_message = $e->getMessage();
                }
            }
            // Manipular redefinição para valores padrão
            if ($request->is_set_post('reset_default')) {
                if ($debug_mode) {
                    error_log("Reset default action triggered, form_token: " . $request->variable('form_token', 'none'), 3, $log_file);
                }
                $config->set('custom404_title_key', 'CUSTOM404_DEFAULT_TITLE');
                $config->set('custom404_message_key', 'CUSTOM404_DEFAULT_MESSAGE');
                $config->set('custom404_image_alt_key', 'CUSTOM404_DEFAULT_IMAGE_ALT');
                $success_message = $this->language->lang('ACP_CUSTOM404_RESET_SUCCESS');
            }
            // Manipular submissão do formulário
            if ($request->is_set_post('submit')) {
                if ($debug_mode) {
                    error_log("Form submission triggered, form_token: " . $request->variable('form_token', 'none'), 3, $log_file);
                }
                $title = utf8_normalize_nfc($request->variable('custom404_title_key', 'CUSTOM404_DEFAULT_TITLE', true));
                $message = utf8_normalize_nfc($request->variable('custom404_message_key', 'CUSTOM404_DEFAULT_MESSAGE', true));
                if (empty($title)) {
                    $error_message = $this->language->lang('ACP_CUSTOM404_TITLE_REQUIRED');
                } elseif (empty($message)) {
                    $error_message = $this->language->lang('ACP_CUSTOM404_MESSAGE_REQUIRED');
                } elseif (strlen($title) < 3) {
                    $error_message = $this->language->lang('ACP_CUSTOM404_TITLE_TOO_SHORT');
                } elseif (strlen($message) < 3) {
                    $error_message = $this->language->lang('ACP_CUSTOM404_MESSAGE_TOO_SHORT');
                } else {
                    $config->set('custom404_title_key', $title);
                    $config->set('custom404_message_key', $message);
                    $config->set('custom404_image_alt_key', utf8_normalize_nfc($request->variable('custom404_image_alt_key', 'CUSTOM404_DEFAULT_IMAGE_ALT', true)));
                    $config->set('custom404_image_path', $request->variable('custom404_image_path', ''));
                    $config->set('custom404_theme', $request->variable('custom404_theme', 'light'));
                    $config->set('custom404_debug_mode', $request->variable('custom404_debug_mode', 0));
                    $config->set('custom404_show_image', $request->variable('custom404_show_image', 0));
                    $success_message = $this->language->lang('ACP_CUSTOM404_SAVED');
                }
            }
            // Manipular exportação de logs com formatação
            if ($request->is_set_post('export_logs')) {
                if ($debug_mode) {
                    $this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_CUSTOM404_EXPORT_LOGS', time());
                }
                $sql = 'SELECT request_url, client_ip, request_time, referrer, user_agent FROM ' . $this->phpbb_container->getParameter('core.table_prefix') . 'custom404_logs ORDER BY request_time DESC';
                $result = $db->sql_query($sql);
                
                header('Content-Type: text/csv; charset=utf-8');
                header('Content-Disposition: attachment; filename="custom404_logs_' . date('Ymd_His') . '.csv"');
                
                $csv = fopen('php://output', 'w');
                // Adicionar BOM diretamente para compatibilidade com Excel
                fwrite($csv, "\xEF\xBB\xBF");
                
                // Cabeçalho
                fputcsv($csv, ['URL Acessada', 'Data/Hora', 'Endereço IP', 'Referenciador', 'Agente do Usuário'], ',');
                
                while ($row = $db->sql_fetchrow($result)) {
                    $formatted_time = $this->user->format_date($row['request_time'], 'd/m/Y H:i');
                    fputcsv($csv, [
                        $row['request_url'],
                        $formatted_time,
                        $row['client_ip'],
                        $row['referrer'] ?: '',
                        $row['user_agent'],
                    ], ',');
                }
                $db->sql_freeresult($result);
                fclose($csv);
                
                // Parar execução para evitar HTML extra
                exit;
            }
            // Manipular exclusão de logs
            if ($request->is_set_post('delete_logs')) {
                if ($debug_mode) {
                    error_log("Delete logs action triggered, form_token: " . $request->variable('form_token', 'none'), 3, $log_file);
                }
                $sql = 'DELETE FROM ' . $this->phpbb_container->getParameter('core.table_prefix') . 'custom404_logs';
                $db->sql_query($sql);
                $affected_rows = $db->sql_affectedrows();
                if ($affected_rows > 0) {
                    $success_message = $this->language->lang('ACP_CUSTOM404_LOGS_DELETED', $affected_rows);
                    if ($debug_mode) {
                        error_log("Deleted $affected_rows log entries", 3, $log_file);
                    }
                } else {
                    $error_message = $this->language->lang('ACP_CUSTOM404_NO_LOGS_DELETED');
                }
            }
            // Manipular pesquisa de logs
            if ($request->is_set_post('search_logs')) {
                if ($debug_mode) {
                    error_log("Search logs action triggered, log_search: " . $request->variable('log_search', ''), 3, $log_file);
                }
                // A pesquisa já é tratada pela lógica existente de $log_search
            }
            // Manipular limpeza de pesquisa
            if ($request->is_set_post('clear_search')) {
                if ($debug_mode) {
                    error_log("Clear search action triggered, form_token: " . $request->variable('form_token', 'none'), 3, $log_file);
                }
                $log_search = '';
                $success_message = $this->language->lang('ACP_CUSTOM404_SEARCH_CLEARED');
            }
            // Recuperar logs com limite
            $log_limit = (int)$request->variable('log_limit', 10);
            $valid_limits = [10, 25, 50, 100];
            $log_limit = in_array($log_limit, $valid_limits, true) ? $log_limit : 10;
            $log_limit = max(1, $log_limit);
            $log_search = $request->variable('log_search', '');
            // Log para depuração
            if ($debug_mode) {
                error_log("Action: " . ($request->is_set_post('submit') ? 'submit' : ($request->is_set_post('upload') ? 'upload' : ($request->is_set_post('reset_default') ? 'reset_default' : ($request->is_set_post('delete_logs') ? 'delete_logs' : ($request->is_set_post('clear_search') ? 'clear_search' : ($request->is_set_post('search_logs') ? 'search_logs' : 'other')))))) . ", log_limit=$log_limit (type: " . gettype($log_limit) . "), log_search=$log_search", 3, $log_file);
            }
            // Montar consulta SQL com filtro de pesquisa
            $sql_where = '';
            if ($log_search) {
                $log_search = $db->sql_escape($log_search);
                $sql_where = ' WHERE request_url LIKE \'%' . $log_search . '%\' OR client_ip LIKE \'%' . $log_search . '%\' OR referrer LIKE \'%' . $log_search . '%\' OR user_agent LIKE \'%' . $log_search . '%\'';
            }
            // Contar total de logs
            $sql = 'SELECT COUNT(*) AS total FROM ' . $this->phpbb_container->getParameter('core.table_prefix') . 'custom404_logs' . $sql_where;
            $result = $db->sql_query($sql);
            $total_logs = (int)$db->sql_fetchfield('total');
            $db->sql_freeresult($result);
            // Carregar logs com limite
            $sql = 'SELECT * FROM ' . $this->phpbb_container->getParameter('core.table_prefix') . 'custom404_logs' . $sql_where . ' ORDER BY request_time DESC LIMIT ' . (int)$log_limit;
            $result = $db->sql_query($sql);
            $logs = [];
            while ($row = $db->sql_fetchrow($result)) {
                $logs[] = [
                    'REQUEST_URL' => $row['request_url'],
                    'CLIENT_IP' => $row['client_ip'],
                    'REQUEST_TIME' => $this->user->format_date($row['request_time'], 'd/M/Y, H:i'),
                    'REFERRER' => $row['referrer'],
                    'USER_AGENT' => $row['user_agent'],
                ];
            }
            $db->sql_freeresult($result);
            foreach ($logs as $log) {
                $template->assign_block_vars('logs', $log);
            }
            $template->assign_var('S_NO_LOGS', empty($logs));
            // Atribuir variáveis de pesquisa
            $template->assign_vars([
                'LOG_SEARCH' => $log_search,
                'TOTAL_LOGS' => $total_logs,
                'LOG_LIMIT' => (int)$log_limit,
            ]);
            // Preparar mensagem para edição
            $message_key = $config['custom404_message_key'] ?? 'CUSTOM404_DEFAULT_MESSAGE';
            $message = $this->language->lang($message_key);
            $uid = $bitfield = $flags = '';
            generate_text_for_storage($message, $uid, $bitfield, $flags, true, true, true);
            // Verificar disponibilidade do SCEditor
            $core_path = $this->phpbb_container->getParameter('core.root_path');
            $sceditor_available = file_exists($core_path . 'adm/style/posting_buttons.html') && file_exists($core_path . 'adm/style/posting_editor.html');
            // Carregar imagens disponíveis
            $images = [];
            if ($this->filesystem->exists($upload_dir)) {
                $files = scandir($upload_dir);
                foreach ($files as $file) {
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if (in_array($ext, $allowed_extensions) && $this->filesystem->is_readable($upload_dir . $file)) {
                        $images[] = $file;
                    }
                }
                sort($images);
            }
            $image_options = [];
            $delete_image_options = [];
            $default_image = '404_error.png';
            $default_relative_path = 'ext/mundophpbb/custom404/uploads/' . $default_image;
            $fallback_image_path = 'styles/prosilver/theme/images/no_image.png';
            $default_absolute_path = $this->filesystem->exists($upload_dir . $default_image)
                ? generate_board_url() . '/' . $default_relative_path
                : generate_board_url() . '/' . $fallback_image_path;
            $image_options[] = [
                'VALUE' => $default_relative_path,
                'SELECTED' => (empty($config['custom404_image_path']) || $config['custom404_image_path'] === $default_relative_path) ? ' selected="selected"' : '',
                'LABEL' => $this->language->lang('ACP_CUSTOM404_DEFAULT_IMAGE'),
                'ABSOLUTE_PATH' => $default_absolute_path
            ];
            foreach ($images as $image) {
                if ($image !== $default_image) {
                    $encoded_image = rawurlencode($image);
                    $relative_image_path = 'ext/mundophpbb/custom404/uploads/' . $encoded_image;
                    $absolute_image_path = generate_board_url() . '/' . $relative_image_path;
                    if ($this->filesystem->exists($upload_dir . $image)) {
                        $image_options[] = [
                            'VALUE' => $relative_image_path,
                            'SELECTED' => ($config['custom404_image_path'] === $relative_image_path) ? ' selected="selected"' : '',
                            'LABEL' => htmlspecialchars_decode($image), // Substituído htmlspecialchars por htmlspecialchars_decode apenas onde necessário
                            'ABSOLUTE_PATH' => $absolute_image_path
                        ];
                        $delete_image_options[] = [
                            'VALUE' => $relative_image_path,
                            'LABEL' => htmlspecialchars_decode($image) // Substituído htmlspecialchars por htmlspecialchars_decode
                        ];
                    }
                }
            }
            $selected_image_path = $config['custom404_image_path'] && $this->filesystem->exists($this->phpbb_container->getParameter('core.root_path') . $config['custom404_image_path'])
                ? generate_board_url() . '/' . $config['custom404_image_path']
                : $default_absolute_path;
            $extensions_string = !empty($allowed_extensions) ? implode(', ', array_map('strtoupper', $allowed_extensions)) : 'N/A';
            $max_size_mb = (int) ($max_file_size / 1024 / 1024);
            $template->assign_vars([
                'U_ACTION' => $this->u_action,
                'CUSTOM404_TITLE' => $this->language->lang($config['custom404_title_key'] ?? 'CUSTOM404_DEFAULT_TITLE'),
                'CUSTOM404_MESSAGE' => generate_text_for_edit($message, $uid, $flags)['text'],
                'CUSTOM404_IMAGE_ALT' => $this->language->lang($config['custom404_image_alt_key'] ?? 'CUSTOM404_DEFAULT_IMAGE_ALT'),
                'CUSTOM404_IMAGE_PATH' => $selected_image_path,
                'DEFAULT_IMAGE_PATH' => $default_absolute_path,
                'CUSTOM404_THEME' => $config['custom404_theme'] ?? 'light',
                'CUSTOM404_DEBUG_MODE' => $debug_mode,
                'CUSTOM404_SHOW_IMAGE' => $config['custom404_show_image'] ?? false,
                'S_BBCODE_ALLOWED' => true,
                'S_BBCODE_IMG' => true,
                'S_BBCODE_URL' => true,
                'S_BBCODE_QUOTE' => true,
                'S_BBCODE_FLASH' => false,
                'S_FORM_ENCODE' => ' enctype="multipart/form-data"',
                'S_BBCODE_EDITOR' => $sceditor_available,
                'SIG_EDIT' => false,
                'S_LINKS_ALLOWED' => true,
                'MAX_FONT_SIZE' => $config['max_post_font_size'] ?? 200,
                'ALLOWED_EXTENSIONS' => $extensions_string,
                'MAX_FILE_SIZE_MB' => $max_size_mb,
                'L_ACP_CUSTOM404_UPLOAD_INFO' => $this->language->lang('ACP_CUSTOM404_UPLOAD_INFO', $extensions_string, $max_size_mb),
                'L_ACP_CUSTOM404_UPLOAD_IMAGE' => $this->language->lang('ACP_CUSTOM404_UPLOAD_IMAGE'),
                'L_ACP_CUSTOM404_SAVE_CHANGES' => $this->language->lang('ACP_CUSTOM404_SAVE_CHANGES'),
                'L_ACP_CUSTOM404_DELETE' => $this->language->lang('ACP_CUSTOM404_DELETE'),
                'L_ACP_CUSTOM404_IMAGE_PATH_LABEL' => $this->language->lang('ACP_CUSTOM404_IMAGE_PATH_LABEL'),
                'L_ACP_CUSTOM404_IMAGE_PATH_EXPLAIN' => $this->language->lang('ACP_CUSTOM404_IMAGE_PATH_EXPLAIN'),
                'L_ACP_CUSTOM404_IMAGE_PREVIEW' => $this->language->lang('ACP_CUSTOM404_IMAGE_PREVIEW'),
                'L_ACP_CUSTOM404_IMAGE_NOT_FOUND' => $this->language->lang('ACP_CUSTOM404_IMAGE_NOT_FOUND'),
                'L_ACP_CUSTOM404_CHOOSE_FILE' => $this->language->lang('ACP_CUSTOM404_CHOOSE_FILE'),
                'L_ACP_CUSTOM404_NO_FILE_CHOSEN' => $this->language->lang('ACP_CUSTOM404_NO_FILE_CHOSEN'),
                'L_ACP_CUSTOM404_THEME_LABEL' => $this->language->lang('ACP_CUSTOM404_THEME_LABEL'),
                'L_ACP_CUSTOM404_THEME_LIGHT' => $this->language->lang('ACP_CUSTOM404_THEME_LIGHT'),
                'L_ACP_CUSTOM404_THEME_DARK' => $this->language->lang('ACP_CUSTOM404_THEME_DARK'),
                'L_ACP_CUSTOM404_DELETE_IMAGE' => $this->language->lang('ACP_CUSTOM404_DELETE_IMAGE'),
                'L_ACP_CUSTOM404_DELETE_IMAGE_EXPLAIN' => $this->language->lang('ACP_CUSTOM404_DELETE_IMAGE_EXPLAIN'),
                'L_ACP_CUSTOM404_DELETE_CONFIRM' => $this->language->lang('ACP_CUSTOM404_DELETE_CONFIRM'),
                'L_ACP_CUSTOM404_LOG_LIMIT' => $this->language->lang('ACP_CUSTOM404_LOG_LIMIT'),
                'L_ACP_CUSTOM404_LOGS' => $this->language->lang('ACP_CUSTOM404_LOGS'),
                'L_ACP_CUSTOM404_EXPORT_LOGS' => $this->language->lang('ACP_CUSTOM404_EXPORT_LOGS'),
                'L_ACP_CUSTOM404_DELETE_LOGS' => $this->language->lang('ACP_CUSTOM404_DELETE_LOGS'),
                'L_ACP_CUSTOM404_DELETE_LOGS_CONFIRM' => $this->language->lang('ACP_CUSTOM404_DELETE_LOGS_CONFIRM'),
                'L_ACP_CUSTOM404_NO_LOGS' => $this->language->lang('ACP_CUSTOM404_NO_LOGS'),
                'L_ACP_CUSTOM404_DEBUG_MODE' => $this->language->lang('ACP_CUSTOM404_DEBUG_MODE'),
                'L_ACP_CUSTOM404_RESET_DEFAULT' => $this->language->lang('ACP_CUSTOM404_RESET_DEFAULT'),
                'L_ACP_CUSTOM404_RESET_CONFIRM' => $this->language->lang('ACP_CUSTOM404_RESET_CONFIRM'),
                'L_ACP_CUSTOM404_LOG_SEARCH' => $this->language->lang('ACP_CUSTOM404_LOG_SEARCH'),
                'L_ACP_CUSTOM404_LOG_SEARCH_PLACEHOLDER' => $this->language->lang('ACP_CUSTOM404_LOG_SEARCH_PLACEHOLDER'),
                'L_ACP_CUSTOM404_TOTAL_LOGS' => $this->language->lang('ACP_CUSTOM404_TOTAL_LOGS'),
                'L_ACP_CUSTOM404_CLEAR_SEARCH' => $this->language->lang('ACP_CUSTOM404_CLEAR_SEARCH'),
                'L_ACP_CUSTOM404_SEARCH_CLEARED' => $this->language->lang('ACP_CUSTOM404_SEARCH_CLEARED'),
                'S_SUCCESS_MESSAGE' => $success_message,
                'S_ERROR_MESSAGE' => $error_message,
                'LOG_LIMIT' => (int)$log_limit,
            ]);
            // Atribuir opções de limite de logs
            $log_limit_options = [
                10 => '10',
                25 => '25',
                50 => '50',
                100 => '100',
            ];
            foreach ($log_limit_options as $value => $label) {
                $template->assign_block_vars('log_limit_options', [
                    'VALUE' => (int)$value,
                    'LABEL' => $label,
                    'SELECTED' => ((int)$value === (int)$log_limit) ? ' selected="selected"' : '',
                ]);
            }
            // Atribuir opções de tema com estilo de botão verde
            $theme_options = [
                'light' => $this->language->lang('ACP_CUSTOM404_THEME_LIGHT'),
                'dark' => $this->language->lang('ACP_CUSTOM404_THEME_DARK'),
            ];
            foreach ($theme_options as $value => $label) {
                $template->assign_block_vars('theme_options', [
                    'VALUE' => $value,
                    'LABEL' => $label,
                    'SELECTED' => ($value == ($config['custom404_theme'] ?? 'light')) ? ' checked="checked"' : '',
                    'IS_GREEN_BUTTON' => true,
                ]);
            }
            foreach ($image_options as $option) {
                $template->assign_block_vars('image_options', $option);
            }
            foreach ($delete_image_options as $option) {
                $template->assign_block_vars('delete_image_options', $option);
            }
            if ($sceditor_available) {
                $this->user->add_lang('posting');
                include_once($core_path . 'includes/functions_posting.' . $this->phpbb_container->getParameter('core.php_ext'));
            }
        } catch (\Exception $e) {
            if ($debug_mode) {
                error_log('ACP Custom 404 Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine() . "\n" . $e->getTraceAsString(), 3, $log_file);
            }
            $template->assign_vars([
                'S_ERROR_MESSAGE' => $this->language->lang('ACP_CUSTOM404_ERROR', $e->getMessage()),
            ]);
        }
    }
    protected function load_language_files($debug_mode = false)
    {
        $lang_path = $this->phpbb_container->getParameter('core.root_path') . 'ext/mundophpbb/custom404/language/';
        $log_dir = $this->phpbb_container->getParameter('core.root_path') . 'ext/mundophpbb/custom404/logs/';
        $user_lang = $this->user->lang_name ?: 'en';
        $fallback_lang = 'en';
        $primary_lang_file = $lang_path . $user_lang . '/acp_common.php';
        // Não criar diretório aqui; assumir que foi tratado no main() se debug_mode estiver ativado
        if ($debug_mode) {
            error_log('ACP Custom 404 Language Attempt: ' . $user_lang . ' | File: ' . $primary_lang_file, 3, $log_dir . 'debug.log');
            error_log('Real Lang Path: ' . (realpath($lang_path) ?: $lang_path), 3, $log_dir . 'debug.log');
            error_log('Lang Dir Exists: ' . (file_exists($lang_path . $user_lang) ? 'Yes' : 'No'), 3, $log_dir . 'debug.log');
            error_log('Lang Dir Is Dir: ' . (is_dir($lang_path . $user_lang) ? 'Yes' : 'No'), 3, $log_dir . 'debug.log');
            error_log('Primary Lang File Exists: ' . (file_exists($primary_lang_file) ? 'Yes' : 'No'), 3, $log_dir . 'debug.log');
        }
        if (file_exists($primary_lang_file) && is_file($primary_lang_file)) {
            $this->language->add_lang(['acp_common', 'common'], 'mundophpbb/custom404', $user_lang);
            if ($debug_mode) {
                error_log('ACP Custom 404 Language Loaded: ' . $user_lang, 3, $log_dir . 'debug.log');
            }
        } else {
            $this->language->add_lang(['acp_common', 'common'], 'mundophpbb/custom404', $fallback_lang);
            if ($debug_mode) {
                error_log('ACP Custom 404 Language Fallback Loaded: ' . $fallback_lang . ' | Reason: Language file or directory not found for ' . $user_lang, 3, $log_dir . 'debug.log');
            }
        }
    }
}