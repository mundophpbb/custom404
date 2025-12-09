<?php
namespace mundophpbb\custom404\migrations;

use phpbb\db\migration\migration;

/**
 * Migração para instalar a extensão Custom 404
 */
class install_custom404 extends migration
{
    /**
     * Verificar se a extensão está efetivamente instalada
     *
     * @return bool Verdadeiro se a configuração custom404_image_path existe
     */
    public function effectively_installed()
    {
        return $this->config->offsetExists('custom404_image_path');
    }

    /**
     * Definir dependências para esta migração
     *
     * @return array Lista de dependências de migração
     */
    public static function depends_on()
    {
        // Atualizado para compatibilidade com phpBB 3.3.x, se necessário
        return ['\phpbb\db\migration\data\v32x\v321'];
    }

    /**
     * Adicionar configurações e módulo ACP
     *
     * @return array Array de instruções de atualização de dados
     */
    public function update_data()
    {
        return [
            // Adicionar configurações
            ['config.add', ['custom404_title_key', 'CUSTOM404_DEFAULT_TITLE']],
            ['config.add', ['custom404_message_key', 'CUSTOM404_DEFAULT_MESSAGE']],
            ['config.add', ['custom404_image_alt_key', 'CUSTOM404_DEFAULT_IMAGE_ALT']],
            ['config.add', ['custom404_image_path', 'ext/mundophpbb/custom404/uploads/404_error.png']],
            ['config.add', ['custom404_theme', 'light']],
            ['config.add', ['custom404_debug_mode', 0]], // Adicionada configuração para debug
            // Remover configuração obsoleta
            ['config.remove', ['custom404_log_limit']],
            // Adicionar categoria ACP
            ['module.add', [
                'acp',
                'ACP_CAT_DOT_MODS',
                'ACP_CUSTOM404_CATEGORY',
            ]],
            // Adicionar módulo ACP para configurações
            ['module.add', [
                'acp',
                'ACP_CUSTOM404_CATEGORY',
                [
                    'module_basename' => '\mundophpbb\custom404\acp\main_module',
                    'module_langname' => 'ACP_CUSTOM404_SETTINGS',
                    'module_mode'     => 'settings',
                    'module_auth'     => 'ext_mundophpbb/custom404 && acl_a_board',
                ],
            ]],
        ];
    }

    /**
     * Adicionar esquema de banco de dados para registrar erros 404
     *
     * @return array Array de instruções de atualização de esquema
     */
    public function update_schema()
    {
        return [
            'add_tables' => [
                $this->table_prefix . 'custom404_logs' => [
                    'COLUMNS' => [
                        'log_id' => ['UINT', null, 'auto_increment'],
                        'request_url' => ['TEXT', ''], // Alterado para TEXT
                        'client_ip' => ['VCHAR:45', ''], // Mantido VCHAR:45 para IPv4/IPv6
                        'request_time' => ['TIMESTAMP', 0],
                        'referrer' => ['TEXT', ''], // Alterado para TEXT
                        'user_agent' => ['TEXT', ''], // Alterado para TEXT
                    ],
                    'PRIMARY_KEY' => 'log_id',
                ],
            ],
        ];
    }

    /**
     * Remover configurações e módulo ACP
     *
     * @return array Array de instruções de reversão de dados
     */
    public function revert_data()
    {
        return [
            // Remover configurações
            ['config.remove', ['custom404_title_key']],
            ['config.remove', ['custom404_message_key']],
            ['config.remove', ['custom404_image_alt_key']],
            ['config.remove', ['custom404_image_path']],
            ['config.remove', ['custom404_theme']],
            ['config.remove', ['custom404_debug_mode']], // Remover configuração de debug
            ['config.remove', ['custom404_log_limit']], // Remover configuração obsoleta
            // Remover módulo ACP
            ['module.remove', [
                'acp',
                'ACP_CUSTOM404_CATEGORY',
                [
                    'module_basename' => '\mundophpbb\custom404\acp\main_module',
                    'module_langname' => 'ACP_CUSTOM404_SETTINGS',
                    'module_mode'     => 'settings',
                ],
            ]],
            // Remover categoria ACP
            ['module.remove', [
                'acp',
                'ACP_CAT_DOT_MODS',
                'ACP_CUSTOM404_CATEGORY',
            ]],
        ];
    }

    /**
     * Remover esquema de banco de dados para logs
     *
     * @return array Array de instruções de reversão de esquema
     */
    public function revert_schema()
    {
        return [
            'drop_tables' => [
                $this->table_prefix . 'custom404_logs',
            ],
        ];
    }
}