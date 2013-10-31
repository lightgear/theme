<?php namespace Lightgear\Theme;

/**
 * Extends the core FileViewFinder class
 */
class FileViewFinder extends \Illuminate\View\FileViewFinder {

    /**
     * Add a namespace hint to the finder.
     *
     * @param  string  $namespace
     * @param  string|array  $hints
     * @param  bool $prepend Prepend/append namespace hints
     * @return void
     */
    public function addNamespace($namespace, $hints, $prepend = false)
    {
        $hints = (array) $hints;

        if (isset($this->hints[$namespace]))
        {
            if ($prepend) {

                foreach ($hints as $hint) {
                    array_unshift($this->hints[$namespace], $hint);
                }

                return;

            } else {
                $hints = array_merge($this->hints[$namespace], $hints);
            }
        }

        $this->hints[$namespace] = $hints;
    }

    /**
     * Prepend a location to the finder.
     *
     * @param  string  $location
     * @return void
     */
    public function prependLocation($location)
    {
        array_unshift($this->paths, $location);
    }

}
