<?php
/**
 * This file is part of Limedocs
 *
 * Copyright (C) Matthias ETIENNE <matthias@etienne.in>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Lime\Highlighter\Theme;

abstract class Theme implements ThemeInterface {

    protected $code;
    protected $path;

    protected $infos = [];
    protected $properties = [];

    protected $externalStylesheets = [];
    protected $style;

    final public function __construct($theme_code)
    {
        if (false === is_string($theme_code) || !$this->validateThemeCode($theme_code)) {
            throw new \DomainException('Invalid $theme_code provided. Should be something like "vendor/theme.tmTheme"');
        }

        $this->setCode($theme_code);

        if (false === $this->exists()) {
            throw new \DomainException("Theme \"{$theme_code}\" does not exist.");
        }

        $this->configure();
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        return $this->code;
    }

    protected function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    public function getPath()
    {
        return __DIR__ . '/../../themes/' . $this->getCode();
    }

    public function exists()
    {
        return file_exists($this->getPath());
    }

    /**
     * Return informations about a theme
     *
     * @return array
     */
    public function getInfos()
    {
        return $this->infos;
    }

    protected function setInfos($infos)
    {
        $this->infos = array_merge($this->infos, $infos);
        return $this;
    }

    /**
     * Return the properties of the theme (colors, fonts etc)
     *
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    protected function setProperties($properties)
    {
        $this->properties = array_merge($this->properties, $properties);
        return $this;
    }

    public function getExternalStylesheets() {
        return $this->externalStylesheets;
    }

    public function setExternalStylesheets($stylesheets) {
        $this->externalStylesheets = $stylesheets;
        return $this;
    }

    public function getStyle()
    {
        return $this->style;
    }

    public function setStyle($style)
    {
        $this->style = $style;
        return $this;
    }


}