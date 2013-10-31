<?php namespace Lightgear\Theme;

use App;

class Theme {

    protected $config;

    protected $finder;

    protected $active;

    public function __construct($app)
    {
        $this->config = $app['config'];
        $this->finder = $app['view.finder'];
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
        return base_path() . '/' . 
               $this->config->get('theme::themes_dir') . '/' .
               $this->active;
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
    
}
