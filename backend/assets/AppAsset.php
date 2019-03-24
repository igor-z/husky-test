<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot/dist';
    public $baseUrl = '@web/dist';
    public $css = [
    ];
    public $js = [
        'bundle.js',
    ];
    public $depends = [];
}
