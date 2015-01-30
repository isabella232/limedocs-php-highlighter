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

use Symfony\Component\DependencyInjection\ContainerBuilder;

class Theme implements ThemeInterface {

    protected $code;
    protected $path;

    protected $infos = [];
    protected $properties = [];

    /**
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;


    public function __construct($theme_code)
    {
        if (false === is_string($theme_code) || !$this->validateThemeCode($theme_code)) {
            throw new \DomainException('Invalid $theme_code provided. Should be something like "vendor/theme.tmTheme"');
        }

        $this->setCode($theme_code);

        if (false === $this->exists()) {
            throw new \DomainException("Theme \"{$theme_code}\" does not exist.");
        }
    }

    /**
     * Parse the file
     */
    public function configure()
    {
        $manifest = $this->getPath() . '/theme.json';

        if (false === file_exists($manifest) || false === is_readable($manifest)) {
            throw new \RuntimeException('Theme manifest (theme.json) does not exist or is not readable.');
        }

        $manifestInfos = json_decode(file_get_contents($manifest), true);

        if (!$manifestInfos) {
            throw new \RuntimeException('Theme manifest (theme.json) contains invalid JSON data.');
        }

        if (!empty($manifestInfos['infos'])) {
            $this->setInfos($manifestInfos['infos']);
        }

        $this->getContainer()->setParameter('theme_manifest', $manifestInfos);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validateThemeCode($theme_code)
    {
        return (bool) preg_match('@^([a-z0-9\-_]+)/([a-z0-9\-_]+)@i', $theme_code);
    }

    /**
     * @return ContainerBuilder
     */
    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer(ContainerBuilder $container)
    {
        $this->container = $container;
        return $this;
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


}