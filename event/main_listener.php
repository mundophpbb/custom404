<?php
namespace mundophpbb\custom404\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Listener de eventos para manipular erros 404 e logs
 */
class main_listener implements EventSubscriberInterface
{
    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\language\language */
    protected $language;

    /** @var \phpbb\template\twig\twig */
    protected $template;

    /** @var \phpbb\config\config */
    protected $config;

    /** @var \phpbb\filesystem\filesystem */
    protected $filesystem;

    /** @var \phpbb\request\request */
    protected $request;

    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var string */
    protected $root_path;

    /** @var string */
    protected $table_prefix;

    /** @var bool */
    protected $is_apprequest = false;

    /**
     * Construtor
     *
     * @param \phpbb\user $user
     * @param \phpbb\language\language $language
     * @param \phpbb\template\twig\twig $template
     * @param \phpbb\config\config $config
     * @param \phpbb\filesystem\filesystem $filesystem
     * @param \phpbb\request\request $request
     * @param \phpbb\db\driver\driver_interface $db
     * @param string $root_path
     * @param string $table_prefix
     */
    public function __construct(
        \phpbb\user $user,
        \phpbb\language\language $language,
        \phpbb\template\twig\twig $template,
        \phpbb\config\config $config,
        \phpbb\filesystem\filesystem $filesystem,
        \phpbb\request\request $request,
        \phpbb\db\driver\driver_interface $db,
        $root_path,
        $table_prefix
    ) {
        $this->user = $user;
        $this->language = $language;
        $this->template = $template;
        $this->config = $config;
        $this->filesystem = $filesystem;
        $this->request = $request;
        $this->db = $db;
        $this->root_path = $root_path;
        $this->table_prefix = $table_prefix;
    }

    /**
     * Definir eventos a serem ouvidos
     *
     * @return array Array de eventos inscritos
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST   => [['set_apprequest', 960]],
            KernelEvents::EXCEPTION => [['maybe_set_404', 960]],
            'core.user_setup_after' => [['load_language', 200]],
        ];
    }

    /**
     * Marcar a requisição como uma requisição de aplicativo
     *
     * @param GetResponseEvent $event
     */
    public function set_apprequest(GetResponseEvent $event)
    {
        $this->is_apprequest = true;
    }

    /**
     * Carregar arquivos de idioma
     *
     * @param mixed $event
     */
    public function load_language($event)
    {
        $this->load_language_files();
    }

    /**
     * Manipular erros 404 e registrá-los
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function maybe_set_404(GetResponseForExceptionEvent $event)
    {
        if ($this->is_apprequest && $event->getException() instanceof NotFoundHttpException) {
            $this->load_language_files();

            // Registrar o erro 404 no banco de dados
            $log_data = [
                'request_url' => substr($this->request->server('REQUEST_URI', ''), 0, 255),
                'client_ip' => substr($this->request->server('REMOTE_ADDR', ''), 0, 45),
                'request_time' => time(),
                'referrer' => substr($this->request->server('HTTP_REFERER', ''), 0, 255),
                'user_agent' => substr($this->request->server('HTTP_USER_AGENT', ''), 0, 255),
            ];
            $sql = 'INSERT INTO ' . $this->table_prefix . 'custom404_logs ' . $this->db->sql_build_array('INSERT', $log_data);
            $this->db->sql_query($sql);

            // Registrar no arquivo de log
            $log_dir = $this->root_path . 'ext/mundophpbb/custom404/logs/';
            $log_file = $log_dir . '404_errors.log';
            if ($this->filesystem && !$this->filesystem->exists($log_dir)) {
                $this->filesystem->mkdir($log_dir, 0755);
            }
            $log_message = sprintf(
                "[%s] URL: %s | IP: %s | Referrer: %s | User Agent: %s\n",
                date('Y-m-d H:i:s', $log_data['request_time']),
                $log_data['request_url'],
                $log_data['client_ip'],
                $log_data['referrer'],
                $log_data['user_agent']
            );
            error_log($log_message, 3, $log_file);

            // Preparar mensagem para exibição
            $message_key = $this->config['custom404_message_key'] ?? 'CUSTOM404_DEFAULT_MESSAGE';
            $message = $this->language->lang($message_key);
            $uid = $bitfield = $flags = '';
            generate_text_for_storage($message, $uid, $bitfield, $flags, true, true, true);
            $message = generate_text_for_display($message, $uid, $bitfield, $flags);

            // Manipular caminho da imagem
            $default_image_path = 'ext/mundophpbb/custom404/uploads/404_error.png';
            $fallback_image_path = 'styles/prosilver/theme/images/no_image.png';
            $image_path = !empty($this->config['custom404_image_path'])
                ? $this->config['custom404_image_path']
                : $default_image_path;
            $full_image_path = $this->root_path . $image_path;
            if (!is_file($full_image_path)) {
                $image_path = is_file($this->root_path . $default_image_path) ? $default_image_path : $fallback_image_path;
            }
            $absolute_image_path = generate_board_url() . '/' . $image_path;

            // Determinar qual template usar com base no tema
            $theme = $this->config['custom404_theme'] ?? 'light';
            $template_file = ($theme === 'dark') ? '@mundophpbb_custom404/custom404_dark.html' : '@mundophpbb_custom404/custom404_light.html';

            // Atribuir variáveis ao template
            $this->template->assign_vars([
                'CUSTOM404_TITLE'       => $this->language->lang($this->config['custom404_title_key'] ?? 'CUSTOM404_DEFAULT_TITLE'),
                'CUSTOM404_MESSAGE'     => $message,
                'CUSTOM404_IMAGE_ALT'   => $this->language->lang($this->config['custom404_image_alt_key'] ?? 'CUSTOM404_DEFAULT_IMAGE_ALT'),
                'CUSTOM404_IMAGE_PATH'  => $absolute_image_path,
                'CUSTOM404_SHOW_IMAGE'  => $this->config['custom404_show_image'] ?? false, // ADICIONADO: Passa o valor do toggle para o template
                'T_THEME_PATH'          => generate_board_url() . '/styles/prosilver/theme/',
            ]);

            // Renderizar a página 404
            page_header($this->language->lang($this->config['custom404_title_key'] ?? 'CUSTOM404_DEFAULT_TITLE'), false);
            $this->template->set_filenames(['body' => $template_file]);

            header('HTTP/1.1 404 Not Found', true, 404);
            header('Content-Type: text/html; charset=UTF-8');
            header('Cache-Control: no-cache, must-revalidate, max-age=0');

            page_footer(false);

            $event->setResponse(new \Symfony\Component\HttpFoundation\Response(
                $this->template->assign_display('body'),
                404,
                ['Content-Type' => 'text/html; charset=UTF-8']
            ));
        }
    }

    /**
     * Carregar arquivos de idioma com base no idioma do usuário
     */
    protected function load_language_files()
    {
        static $language_loaded = false;
        if ($language_loaded) {
            return;
        }

        $lang_path = $this->root_path . 'ext/mundophpbb/custom404/language/';
        $log_dir = $this->root_path . 'ext/mundophpbb/custom404/logs/';
        $user_lang = $this->user->lang_name ?: 'en';
        $fallback_lang = 'en';
        $primary_lang_file = $lang_path . $user_lang . '/acp_common.php';

        if ($this->filesystem && !$this->filesystem->exists($log_dir)) {
            $this->filesystem->mkdir($log_dir, 0755);
        }
        error_log('Custom 404 Language: ' . $user_lang . ' | File: ' . $primary_lang_file, 3, $log_dir . 'debug.log');

        if (is_file($primary_lang_file)) {
            $this->language->add_lang(['acp_common', 'common'], 'mundophpbb/custom404', $user_lang);
        } else {
            $this->language->add_lang(['acp_common', 'common'], 'mundophpbb/custom404', $fallback_lang);
        }

        $this->language->add_lang(['common', 'acp/common']);
        $language_loaded = true;
    }
}