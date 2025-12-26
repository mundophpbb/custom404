<?php
namespace mundophpbb\custom404;

class ext extends \phpbb\extension\base
{
    public function is_enableable()
    {
        $config = $this->container->get('config');
        return phpbb_version_compare($config['version'], '3.3.0', '>=') && PHP_VERSION_ID >= 70103;
    }

    public function enable_step($old_state)
    {
        if ($old_state === false)
        {
            $this->container->get('cache')->purge();
        }

        return parent::enable_step($old_state);
    }
}