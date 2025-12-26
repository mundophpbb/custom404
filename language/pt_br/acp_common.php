<?php
/**
 * ACP Language File for Custom 404 Page Extension (Portuguese - Brazil)
 *
 * @package mundophpbb\custom404\language\pt
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */

if (!defined('IN_PHPBB')) {
    exit;
}

if (empty($lang) || !is_array($lang)) {
    $lang = [];
}

$lang = array_merge($lang, [
    // Interface do Módulo ACP
    'ACP_CUSTOM404_CATEGORY'            => 'Erro 404 Personalizado',
    'ACP_CUSTOM404_SETTINGS'            => 'Configurações',
    'ACP_CUSTOM404_TITLE'               => 'Página 404 Personalizada',
    'ACP_CUSTOM404_TITLE_LABEL'         => 'Título da Página 404',
    'ACP_CUSTOM404_MESSAGE_LABEL'       => 'Mensagem da Página 404',
    'ACP_CUSTOM404_BBCODE_INFO'         => 'Use BBCode como [b]negrito[/b], [i]itálico[/i], [url]link[/url] ou [img]imagem[/img] para formatar a mensagem.',
    'ACP_CUSTOM404_SAVED'               => 'Configurações salvas com sucesso!',
    'ACP_CUSTOM404_RESET_DEFAULT'       => 'Redefinir para o Padrão',
    'ACP_CUSTOM404_RESET_CONFIRM'       => 'Tem certeza de que deseja redefinir o título, mensagem e texto alternativo da imagem para os valores padrão?',
    'ACP_CUSTOM404_RESET_SUCCESS'       => 'Configurações redefinidas para os valores padrão com sucesso!',

    // Configurações de Imagem
    'ACP_CUSTOM404_SHOW_IMAGE'          => 'Exibir Imagem na Página 404',
    'ACP_CUSTOM404_SHOW_IMAGE_ON'       => 'Ativado',
    'ACP_CUSTOM404_SHOW_IMAGE_OFF'      => 'Desativado',
    'ACP_CUSTOM404_IMAGE_ALT_LABEL'     => 'Texto Alternativo da Imagem',
    'ACP_CUSTOM404_IMAGE_PATH_LABEL'    => 'Imagem da Página 404',
    'ACP_CUSTOM404_IMAGE_PATH_EXPLAIN'  => 'Selecione uma imagem do diretório de uploads da extensão.',
    'ACP_CUSTOM404_IMAGE_PREVIEW'       => 'Pré-visualização da Imagem',
    'ACP_CUSTOM404_IMAGE_UPLOAD'        => 'Carregar Nova Imagem',
    'ACP_CUSTOM404_UPLOAD_INFO'         => 'Formatos permitidos: %s. Tamanho máximo: %d MB.',
    'ACP_CUSTOM404_DEFAULT_IMAGE'       => 'Imagem Padrão (404_error.png)',
    'ACP_CUSTOM404_CHOOSE_FILE'         => 'Escolher Arquivo',
    'ACP_CUSTOM404_NO_FILE_CHOSEN'      => 'Nenhum Arquivo Escolhido',
    'ACP_CUSTOM404_IMAGE_UPLOADED'      => 'Imagem carregada com sucesso!',
    'ACP_CUSTOM404_INVALID_FILE_TYPE'   => 'Tipo de arquivo inválido. Apenas %s são permitidos.',
    'ACP_CUSTOM404_FILE_TOO_LARGE'      => 'O arquivo excede o tamanho máximo permitido de %d MB.',
    'ACP_CUSTOM404_UPLOAD_FAILED'        => 'Falha ao carregar a imagem. Tente novamente.',
    'ACP_CUSTOM404_DELETE_IMAGE'        => 'Excluir Imagem',
    'ACP_CUSTOM404_DELETE_IMAGE_EXPLAIN' => 'Selecione uma imagem para excluir do diretório de uploads da extensão.',
    'ACP_CUSTOM404_DELETE'              => 'Excluir',
    'ACP_CUSTOM404_DELETE_CONFIRM'      => 'Você tem certeza de que deseja excluir esta imagem?',
    'ACP_CUSTOM404_SELECT_IMAGE'        => 'Selecionar Imagem',
    'ACP_CUSTOM404_IMAGE_DELETED'       => 'Imagem excluída com sucesso!',
    'ACP_CUSTOM404_IMAGE_NOT_FOUND'     => 'Imagem não encontrada.',
    'ACP_CUSTOM404_INVALID_IMAGE'       => 'Imagem inválida selecionada.',
    'ACP_CUSTOM404_PERMISSION_DENIED'   => 'Permissão negada para excluir a imagem. Verifique as permissões do arquivo.',
    'ACP_CUSTOM404_LOG_DIR_FAILED'      => 'Falha ao criar o diretório de logs. Verifique as permissões do servidor.',
    'ACP_CUSTOM404_UPLOAD_DIR_FAILED'   => 'Falha ao criar o diretório de uploads. Verifique as permissões do servidor.',
    'ACP_CUSTOM404_DELETE_FAILED'       => 'Falha ao excluir a imagem: %s',
    'ACP_CUSTOM404_NO_IMAGE_SELECTED'   => 'Nenhuma imagem selecionada para exclusão.',
    'ACP_CUSTOM404_OK'                  => 'OK',

    // Tema e Modo de Depuração
    'ACP_CUSTOM404_THEME_LABEL'         => 'Tema da Página 404',
    'ACP_CUSTOM404_THEME_LIGHT'         => 'Claro',
    'ACP_CUSTOM404_THEME_DARK'          => 'Escuro',
    'ACP_CUSTOM404_DEBUG_MODE'          => 'Modo de Depuração',
    'ACP_CUSTOM404_DEBUG_EXPLAIN'       => 'Habilita o modo de depuração para exibir informações adicionais de log, facilitando o diagnóstico de erros 404 e problemas de configuração. Use apenas para fins de desenvolvimento ou resolução de problemas.',
    'ACP_CUSTOM404_DEBUG_MODE_ON'       => 'Desativar Modo de Depuração',
    'ACP_CUSTOM404_DEBUG_MODE_OFF'      => 'Ativar Modo de Depuração',

    // Logging de Erros 404
    'ACP_CUSTOM404_LOGS'                => 'Registros de Erros 404',
    'ACP_CUSTOM404_URL'                 => 'URL Solicitada',
    'ACP_CUSTOM404_IP_ADDRESS'          => 'IP do Cliente',
    'ACP_CUSTOM404_REQUEST_TIME'        => 'Data/Hora da Solicitação',
    'ACP_CUSTOM404_REFERRER'            => 'Origem',
    'ACP_CUSTOM404_USER_AGENT'          => 'Agente do Usuário',
    'ACP_CUSTOM404_NO_LOGS'             => 'Nenhum registro de erro 404 encontrado.',
    'ACP_CUSTOM404_EXPORT_LOGS'         => 'Exportar Registros como CSV',
    'ACP_CUSTOM404_LOG_LIMIT'           => 'Número de Registros a Exibir',
    'ACP_CUSTOM404_DELETE_LOGS'         => 'Excluir Todos os Registros',
    'ACP_CUSTOM404_DELETE_LOGS_CONFIRM' => 'Você tem certeza de que deseja excluir todos os registros de erros 404 mais antigos que 30 dias?',
    'ACP_CUSTOM404_LOGS_DELETED'        => 'Registros de erros 404 excluídos com sucesso! (%d registros removidos)',
    'ACP_CUSTOM404_LOG_SEARCH'          => 'Pesquisar Registros',
    'ACP_CUSTOM404_LOG_SEARCH_PLACEHOLDER' => 'Digite uma URL, IP, origem ou agente do usuário',
    'ACP_CUSTOM404_TOTAL_LOGS'          => 'Total de Registros',
    'ACP_CUSTOM404_CLEAR_SEARCH'        => 'Limpar Pesquisa',
    'ACP_CUSTOM404_NO_LOGS_DELETED'     => 'Nenhum log foi excluído, pois não há registros mais antigos que 30 dias.',
    'ACP_CUSTOM404_SEARCH_CLEARED'      => 'Pesquisa de logs limpa com sucesso.',
    'ACP_CUSTOM404_PAGINATION_ERROR'    => 'Erro ao gerar a paginação dos registros. Por favor, tente novamente ou contate o suporte.',

    // Ajuda para BBCode
    'BBCODE_B_HELP'                     => 'Negrito: [b]texto[/b]',
    'BBCODE_I_HELP'                     => 'Itálico: [i]texto[/i]',
    'BBCODE_U_HELP'                     => 'Sublinhado: [u]texto[/u]',
    'BBCODE_URL_HELP'                   => 'Link: [url=http://exemplo.com]texto[/url] ou [url]http://exemplo.com[/url]',
    'BBCODE_IMG_HELP'                   => 'Imagem: [img]http://exemplo.com/imagem.jpg[/img]',
    'BBCODE_QUOTE_HELP'                 => 'Citação: [quote]texto[/quote]',
    'BBCODE_INSTRUCTIONS'               => 'Use BBCode para formatar a mensagem, como [b]negrito[/b], [url]link[/url] ou [img]imagem[/img].',

    // Valores Padrão da Página 404
    'CUSTOM404_DEFAULT_TITLE'           => '404 - Página Não Encontrada',
    'CUSTOM404_DEFAULT_MESSAGE'         => 'Ops, a página que você está buscando não existe!',
    'CUSTOM404_DEFAULT_IMAGE_ALT'       => 'Imagem de Erro 404',

    // Validação de Formulário
    'FORM_INVALID'                      => 'Formulário inválido. Por favor, tente novamente.',
    'FORM_TOKEN_MISSING'                => 'Erro: Token do formulário não encontrado.',
    'ACP_CUSTOM404_TITLE_REQUIRED'      => 'O título não pode estar vazio.',
    'ACP_CUSTOM404_MESSAGE_REQUIRED'    => 'A mensagem não pode estar vazia.',
    'ACP_CUSTOM404_TITLE_TOO_SHORT'     => 'O título deve ter pelo menos 3 caracteres.',
    'ACP_CUSTOM404_MESSAGE_TOO_SHORT'   => 'A mensagem deve ter pelo menos 3 caracteres.',

    // Botões e Interface Geral
    'ACP_CUSTOM404_UPLOAD_IMAGE'        => 'Enviar Imagem',
    'ACP_CUSTOM404_SAVE_CHANGES'        => 'Salvar Alterações',
    'L_BACK_TO_INDEX'                   => 'Voltar ao Início',
    'L_CANCEL'                          => 'Cancelar',
]);