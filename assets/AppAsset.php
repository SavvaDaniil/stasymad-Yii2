<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'dist/css/bootstrap.min.css',
        'main.css',
        'main_mobile.css'
    ];
    public $js = [
        "https://code.jquery.com/jquery-3.2.1.min.js",
        "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js",
        "/dist/js/bootstrap.min.js",
        /*
        "video.js/dist/video-js.css",
        "video.js/dist/video.js"
        */
    ];
    public $depends = [
        
    ];
}
