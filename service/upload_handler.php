<?php
/**
 * Serviço de manipulação de upload para a extensão Custom 404
 *
 * @package mundophpbb\custom404\service
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 */
namespace mundophpbb\custom404\service;

class upload_handler
{
    /** @var \phpbb\filesystem\filesystem */
    protected $filesystem;

    /** @var \phpbb\language\language */
    protected $language;

    /** @var \phpbb\config\config */
    protected $config;

    /**
     * Construtor
     *
     * @param \phpbb\filesystem\filesystem $filesystem
     * @param \phpbb\language\language $language
     * @param \phpbb\config\config $config
     */
    public function __construct(
        \phpbb\filesystem\filesystem $filesystem,
        \phpbb\language\language $language,
        \phpbb\config\config $config
    ) {
        $this->filesystem = $filesystem;
        $this->language = $language;
        $this->config = $config;
    }

    /**
     * Manipular upload de arquivo
     *
     * @param array $file Dados do arquivo enviado de $request->file()
     * @param string $upload_dir Diretório para salvar o arquivo enviado
     * @param array $allowed_extensions Array de extensões de arquivo permitidas
     * @param int $max_file_size Tamanho máximo do arquivo em bytes
     * @return string|null Caminho do arquivo enviado ou null se nenhum arquivo foi enviado
     * @throws \Exception Se o upload falhar ou ocorrerem erros de validação
     */
    public function handle_upload(array $file, string $upload_dir, array $allowed_extensions, int $max_file_size): ?string
    {
        // Verificar se um arquivo foi enviado
        if (empty($file['name'])) {
            return null;
        }

        // Validar extensão do arquivo
        $file_ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($file_ext, $allowed_extensions)) {
            throw new \Exception($this->language->lang('ACP_CUSTOM404_INVALID_FILE_TYPE', implode(', ', array_map('strtoupper', $allowed_extensions))));
        }

        // Validar tamanho do arquivo
        if ($file['size'] > $max_file_size) {
            throw new \Exception($this->language->lang('ACP_CUSTOM404_FILE_TOO_LARGE'));
        }

        // Gerar nome de arquivo único
        $new_filename = uniqid() . '.' . $file_ext;
        $destination = rtrim($upload_dir, '/') . '/' . $new_filename;

        // Garantir que o diretório de upload exista
        if (!$this->filesystem->exists($upload_dir)) {
            $this->filesystem->mkdir($upload_dir, 0777);
        }

        // Obter o nome do arquivo original e sanitizá-lo
        $new_filename = basename($file['name']);
        $destination = $upload_dir . '/' . $new_filename;

        // Verificar se o arquivo já existe para evitar sobrescrição
        $counter = 1;
        $info = pathinfo($new_filename);
        $base_name = $info['filename'];
        $extension = isset($info['extension']) ? '.' . $info['extension'] : '';

        while ($this->filesystem->exists($destination)) {
            $new_filename = $base_name . '_' . $counter . $extension;
            $destination = $upload_dir . '/' . $new_filename;
            $counter++;
        }

        // Mover o arquivo enviado
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            throw new \Exception($this->language->lang('ACP_CUSTOM404_UPLOAD_FAILED'));
        }

        // Retornar o caminho relativo para armazenamento na configuração
        return 'ext/mundophpbb/custom404/uploads/' . $new_filename;
    }
}