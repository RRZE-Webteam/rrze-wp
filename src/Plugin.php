<?php

namespace RRZE\WP;

defined('ABSPATH') || exit;

class Plugin
{
    /**
     * The full path and filename of the plugin.
     * 
     * @var string
     */
    protected $plugin_file;

    /**
     * The basename of the plugin.
     * 
     * @var string
     */
    protected $basename;

    /**
     * The filesystem directory path (with trailing slash) for the plugin.
     * 
     * @var string
     */
    protected $directory;

    /**
     * The URL directory path (with trailing slash) for the plugin.
     * 
     * @var string
     */
    protected $url;

    /**
     * The version of the plugin.
     * 
     * @var string
     */
    protected $version;

    /**
     * @param string $plugin_file The full path and filename of the plugin.
     */
    public function __construct(string $plugin_file)
    {
        $this->plugin_file = $plugin_file;
    }

    /**
     * Execute on loaded hook.
     */
    public function loaded()
    {
        $this->setBasename()
            ->setDirectory()
            ->setUrl()
            ->setVersion();
    }

    /**
     * Get the full path and filename of the plugin.
     * 
     * @return string The full path and filename.
     */
    public function getFile()
    {
        return $this->plugin_file;
    }

    /**
     * Get the basename of the plugin.
     * 
     * @return string The basename.
     */
    public function getBasename()
    {
        return $this->basename;
    }

    /**
     * Set the basename of the plugin.
     * 
     * @return object This Plugin object.
     */
    public function setBasename()
    {
        $this->basename = plugin_basename($this->plugin_file);
        return $this;
    }

    /**
     * Get the filesystem directory path (with trailing slash) for the plugin.
     * 
     * @return string The filesystem directory path.
     */
    public function getDirectory()
    {
        return $this->directory;
    }

    /**
     * Set the filesystem directory path (with trailing slash) for the plugin.
     * 
     * @return object This Plugin object.
     */
    public function setDirectory()
    {
        $this->directory = rtrim(plugin_dir_path($this->plugin_file), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        return $this;
    }

    /**
     * Get the filesystem directory path (with trailing slash) for the plugin.
     * 
     * @param string $path The path name.
     * @return string The filesystem directory path.
     */
    public function getPath(string $path = '')
    {
        return $this->directory . ltrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Get the URL directory path (with trailing slash) for the plugin.
     * 
     * @param string $path The path name.
     * @return string The URL directory path.
     */
    public function getUrl(string $path = '')
    {
        return $this->url . ltrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Set the URL directory path (with trailing slash) for the plugin.
     * 
     * @return object This Plugin object.
     */
    public function setUrl()
    {
        $this->url = rtrim(plugin_dir_url($this->plugin_file), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        return $this;
    }

    /**
     * Get the slug of the plugin.
     * 
     * @return string The slug.
     */
    public function getSlug()
    {
        return sanitize_title(dirname($this->basename));
    }

    /**
     * Get the version of the plugin.
     * 
     * @return string The version.
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set the version of the plugin.
     * 
     * @return object This Plugin object.
     */
    public function setVersion()
    {
        $headers = array('Version' => 'Version');
        $file_data = get_file_data($this->plugin_file, $headers, 'plugin');
        if (isset($file_data['Version'])) {
            $this->version = $file_data['Version'];
        };
        return $this;
    }

    /**
     * Method overloading.
     */
    public function __call(string $name, array $arguments)
    {
        if (!method_exists($this, $name)) {
            $message = sprintf(__('Call to undefined method %1$s::%2$s', 'rrze-greetings'), __CLASS__, $name);
            do_action(
                'rrze.log.error',
                $message,
                array(
                    'class' => __CLASS__,
                    'method' => $name,
                    'arguments' => $arguments
                )
            );
            if (defined('WP_DEBUG') && WP_DEBUG) {
                throw new \Exception($message);
            }
        }
    }
}
