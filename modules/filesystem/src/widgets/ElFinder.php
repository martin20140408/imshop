<?php

namespace im\filesystem\widgets;

use yii\base\Widget;
use Yii;

class ElFinder extends Widget
{
    public $language;

    public $filter;

    public $callbackFunction;

    public $path;// work with PathController

    public $containerOptions = [];

    public $frameOptions = [];

    public $controller = 'elfinder';

    public static function getManagerUrl($controller, $params = [])
    {
        $params[0] = '/'.$controller."/manager";
        return Yii::$app->urlManager->createUrl($params);
    }

    public static function ckeditorOptions($controller, $options = []){
        if(is_array($controller)){
            $id = $controller[0];
            unset($controller[0]);
            $params = $controller;
        }else{
            $id = $controller;
            $params = [];
        }
        return ArrayHelper::merge([
            'filebrowserBrowseUrl' => self::getManagerUrl($id, $params),
            'filebrowserImageBrowseUrl' => self::getManagerUrl($id, ArrayHelper::merge($params, ['filter'=>'image'])),
            'filebrowserFlashBrowseUrl' => self::getManagerUrl($id, ArrayHelper::merge($params, ['filter'=>'flash'])),
        ], $options);
    }
    public function init()
    {
        if(empty($this->language))
            $this->language = self::getSupportedLanguage(Yii::$app->language);
        $managerOptions = [];
        if(!empty($this->filter))
            $managerOptions['filter'] = $this->filter;
        if(!empty($this->callbackFunction))
            $managerOptions['callback'] = $this->id;
        if(!empty($this->language))
            $managerOptions['lang'] = $this->language;
        if(!empty($this->path))
            $managerOptions['path'] = $this->path;
        $this->frameOptions['src'] = $this->getManagerUrl($this->controller, $managerOptions);
        if(!isset($this->frameOptions['style'])){
            $this->frameOptions['style'] = "width: 100%; height: 100%; border: 0;";
        }
    }
    static function getSupportedLanguage($language)
    {
        $supportedLanguages = array('bg', 'jp', 'sk', 'cs', 'ko', 'th', 'de', 'lv', 'tr', 'el', 'nl', 'uk',
            'es', 'no', 'vi', 'fr', 'pl', 'zh_CN', 'hr', 'pt_BR', 'zh_TW', 'hu', 'ro', 'it', 'ru', 'en');
        if(!in_array($language, $supportedLanguages)){
            if (strpos($language, '-')){
                $language = str_replace('-', '_', $language);
                if(!in_array($language, $supportedLanguages)) {
                    $language = substr($language, 0, strpos($language, '_'));
                    if (!in_array($language, $supportedLanguages))
                        $language = false;
                }
            } else {
                $language = false;
            }
        }
        return $language;
    }

    public function run()
    {
        $container = 'div';
        if(isset($this->containerOptions['tag'])){
            $container = $this->containerOptions['tag'];
            unset($this->containerOptions['tag']);
        }
        echo Html::tag($container, Html::tag('iframe','', $this->frameOptions), $this->containerOptions);
        if(!empty($this->callbackFunction)){
            AssetsCallBack::register($this->getView());
            $this->getView()->registerJs("mihaildev.elFinder.register(".Json::encode($this->id).",".Json::encode($this->callbackFunction).");");
        }
    }
} 