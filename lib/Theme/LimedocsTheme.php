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

class LimedocsTheme extends Theme {

    /**
     * {@inheritdoc}
     */
    public function validateThemeCode($theme_code)
    {
        return (bool) preg_match('@^([a-z0-9\-_]+)/([a-z0-9\-_]+)@i', $theme_code);
    }


    /**
     * Parse the tmTheme file
     */
    public function configure()
    {
        $manifest = $this->getPath() . '/theme.json';
        $css_file = $this->getPath() . '/theme.css';

        if (false === file_exists($manifest) || false === is_readable($manifest)) {
            throw new \RuntimeException('Theme manifest (theme.json) does not exist or is not readable.');
        }

        if (false === file_exists($css_file) || false === is_readable($css_file)) {
            throw new \RuntimeException('Theme style (theme.css) does not exist or is not readable.');
        }


        $manifestInfos = json_decode(file_get_contents($manifest), true);

        if (!$manifestInfos) {
            throw new \RuntimeException('Theme manifest (theme.json) contains invalid JSON data.');
        }

        if (!empty($manifestInfos['infos'])) {
            $this->setInfos($manifestInfos['infos']);
        }

        if (!empty($manifestInfos['external_stylesheets'])) {
            $this->setExternalStylesheets($manifestInfos['external_stylesheets']);
        }

        $this->setStyle(file_get_contents($css_file));
    }


}