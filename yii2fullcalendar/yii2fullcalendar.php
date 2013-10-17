<?php

 /**
 * This class is used to embed FullCalendar JQuery Plugin to my Yii2 Projects
 * @copyright Frenzel GmbH - www.frenzel.net
 * @link http://www.frenzel.net
 * @author Philipp Frenzel <philipp@frenzel.net>
 *
 */

namespace yii2fullcalendar;

use Yii;
use yii\base\Model;
use yii\base\View;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\base\Widget as elWidget;

class yii2fullcalendar extends elWidget
{

    /**
    * @var array the HTML attributes (name-value pairs) for the field container tag.
    * The values will be HTML-encoded using [[Html::encode()]].
    * If a value is null, the corresponding attribute will not be rendered.
    */
    public $options = array(
        'class' => 'fullcalendar',
    );

    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $clientOptions = array(
        'weekends' => true,
        'default' => 'month'
    );

    /**
     * @var array the HTML attributes for the widget container tag.
     */
    public $connectorRoute = false;
    
    /**
     * Initializes the widget.
     * If you override this method, make sure you call the parent implementation first.
     */
    public function init()
    {
        //checks for the element id
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        // set required options
        /*if (empty($this->connectorRoute))
        {
           echo "connectorRoute must be set!";
           exit;
        }
        $this->clientOptions['url'] = Html::url(array($this->connectorRoute));*/
        
        parent::init();
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::endTag('div')."\n";
        $this->registerPlugin();
    }

    /**
    * Registers a specific dhtmlx widget and the related events
    * @param string $name the name of the dhtmlx plugin
    */
    protected function registerPlugin()
    {
        //for the js object generation, the first letter needs to be in upper case
        $name = ucfirst($name);

        $id = $this->options['id'];
        $view = $this->getView();

        /** @var \yii\web\AssetBundle $assetClass */
        $assetClass = 'yii2fullcalendar\\CoreAsset';
        $assetClass::register($view);

        $js = array();

        $cleanOptions = Json::encode($this->clientOptions);
        $js[] = "$('#$id').fullCalendar($cleanOptions);";
        
        $view->registerJs(implode("\n", $js),View::POS_READY);
    }

}
