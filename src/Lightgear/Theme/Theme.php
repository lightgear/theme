<?php namespace Lightgear\Theme;

use App;

class Theme {

    protected $config;

    protected $finder;

    protected $asset;

    protected $active;

    public function __construct($app)
    {
        $this->config = $app['config'];
        $this->finder = $app['view.finder'];
        $this->asset = $app['asset'];
    }

    /**
     * Initialize the theme instance
     * 
     * @return void
     */
    public function init()
    {
        $this->setActive($this->config->get('theme::active'));
        $this->overrideViews();
        $this->addAssetsPath();
        $this->loadInfo();
        $this->registerAssets();
    }

    /**
     * Set the active theme
     *
     * @param string $theme The theme name
     */
    public function setActive($theme)
    {
        $this->active = $theme;
    }

    /**
     * Get the full path to the active theme
     *
     * @return string The path
     */
    public function activeThemePath()
    {
        return base_path() .
               $this->config->get('theme::themes_dir') . '/' .
               $this->active;
    }

    /**
     * Register theme assets
     *
     * @return void
     */
    public function registerAssets()
    {
        // styles
        if (isset($this->info['styles'])) {
            $this->asset->registerStyles(
                $this->info['styles']['paths'],
                $this->info['styles']['package'],
                isset($this->info['styles']['group']) ? $this->info['styles']['group'] : ''
            );
        }

        // scripts
        if (isset($this->info['scripts'])) {
            $this->asset->registerScripts(
                $this->info['scripts']['paths'],
                $this->info['scripts']['package'],
                isset($this->info['scripts']['group']) ? $this->info['scripts']['group'] : ''
            );
        }
    }

    protected function addAssetsPath()
    {
        $this->asset->addPath($this->config->get('theme::themes_dir'));
    }

    /**
     * Set the vieww override paths for simple
     * and namespaced (vendors, workbench) views
     *
     * @return void
     */
    protected function overrideViews()
    {
        // add theme hints to existing namespaces
        foreach ($this->finder->getHints() as $namespace => $hints) {
            $this->finder->addNamespace($namespace, $this->activeThemePath() . '/views/' . $namespace, true);
        }

        // add theme views path
        $this->finder->prependLocation($this->activeThemePath() . '/views');
    }

    /**
     * Load info file from the active theme
     *
     * @return array The theme info array
     */
    protected function loadInfo()
    {
        $this->info = include $this->activeThemePath() . '/info.php';
    }
}
