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

use CFPropertyList\CFPropertyList;

class TextmateTheme extends Theme implements ThemeInterface {

    /**
     * {@inheritdoc}
     */
    public function validateThemeCode($theme_code)
    {
        return (bool) preg_match('@^([a-z0-9\-_]+)/([a-z0-9\-_]+)\.tmTheme$@i', $theme_code);
    }


    /**
     * Parse the tmTheme file
     */
    public function configure()
    {
        $plist = new CFPropertyList($this->getPath());
        $infos = $plist->toArray();

        if (!empty($infos['name'])) {
            $this->setInfos(['name' => $infos['name']]);
        }

        if (!empty($infos['comment'])) {
            $this->setInfos(['comment' => $infos['comment']]);
        }

        $props = [];

        foreach ($infos['settings'] as $setting) {
            $scopes = $this->getScopes($setting);
            $this->setSettingsForScopes($scopes, $setting['settings'], $props);
        }

        $this->setProperties($props);
    }

    protected function setSettingsForScopes($scopes, $settings, &$props)
    {
        foreach ($scopes as $scope)
        {
            if (false === isset($props[$scope])) {
                $props[$scope] = [];
            }
            $props[$scope] = array_merge($props[$scope], $settings);
        }
    }

    protected function getScopes($setting)
    {
        if (empty($setting['scope'])) {
            return ['global']; // default scope
        }
        return array_map('trim', explode(',', $setting['scope']));
    }

}