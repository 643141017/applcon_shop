<?php

namespace Applcon\Backend\Controllers;

use Phalcon\Mvc\Dispatcher;
use Applcon\Controllers\Controller;

/**
 * \Applcon\Backend\Controllers\ControllerBase
 *
 * @package Applcon\Backend\Controllers
 */
class ControllerBase extends Controller
{
    public function initialize()
    {
        $this->loadDefaultAssets();

        $this->view->setVars([
            'menuStruct'   => container('menuStruct'),
        ]);
    }

    /**
     * Load module assets.
     */
    protected function loadDefaultAssets()
    {
        $this->assets
            ->addCss('//fonts.googleapis.com/css?family=Open+Sans', false)
            ->addCss('core/assets/css/bootstrap.min.css')
            ->addCss('core/assets/font-awesome/css/font-awesome.css')
            ->addCss('core/assets/css/animate.css')
            ->addCss('core/assets/css/style.css')
            ->addCss('backend/assets/css/app.css')
            ;

        $this->assets
            /* Mainly scripts */
            ->addJs('core/assets/js/jquery-3.1.1.min.js')
            ->addJs('core/assets/js/bootstrap.min.js')
            ->addJs('core/assets/js/plugins/metisMenu/jquery.metisMenu.js')
            ->addJs('core/assets/js/plugins/slimscroll/jquery.slimscroll.min.js')

            /* Flot */
            ->addJs('core/assets/js/plugins/flot/jquery.flot.js')
            ->addJs('core/assets/js/plugins/flot/jquery.flot.tooltip.min.js')
            ->addJs('core/assets/js/plugins/flot/jquery.flot.spline.js')
            ->addJs('core/assets/js/plugins/flot/jquery.flot.resize.js')
            ->addJs('core/assets/js/plugins/flot/jquery.flot.pie.js')
            ->addJs('core/assets/js/plugins/flot/jquery.flot.symbol.js')
            ->addJs('core/assets/js/plugins/flot/jquery.flot.time.js')

            /* Peity */
            ->addJs('core/assets/js/plugins/peity/jquery.peity.min.js')
            ->addJs('core/assets/js/demo/peity-demo.js')

            /* Custom and plugin javascript */
            ->addJs('core/assets/js/inspinia.js')
            ->addJs('core/assets/js/plugins/pace/pace.min.js')

            /* jQuery UI */
            ->addJs('core/assets/js/plugins/jquery-ui/jquery-ui.min.js')

            /* Jvectormap */
            ->addJs('core/assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')
            ->addJs('core/assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')

            /* EayPIE */
            ->addJs('core/assets/js/plugins/easypiechart/jquery.easypiechart.js')

            /* Sparkline */
            ->addJs('core/assets/js/plugins/sparkline/jquery.sparkline.min.js')

            /* Sparkline demo data  */
            ->addJs('core/assets/js/demo/sparkline-demo.js')

            ->addJs('backend/assets/js/app.function.js')
            ->addJs('backend/assets/js/app.js')
        ;
    }

    /**
     * @param Dispatcher $dispatcher
     *
     * @return bool
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        if (!$this->auth->isAdmin()) {
            $this->flashSession->notice(t('You do not have permission to access this page'));
            $dispatcher->setReturnedValue($this->response->redirect('/', true));
            return false;
        }
    }
}
