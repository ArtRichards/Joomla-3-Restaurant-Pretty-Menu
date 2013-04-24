<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

class PMenuHelpersView {

    static function load($viewName, $layoutName = 'default', $viewFormat = 'html', $vars = null)
    {
        // Get the application
        $app = JFactory::getApplication();

        $app->input->set('view', $viewName);

        // Register the layout paths for the view
        $paths = new SplPriorityQueue;
        $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');

        $viewClass = 'PMenuViews' . ucfirst($viewName) . ucfirst($viewFormat);
        $modelClass = 'PMenuModels' . ucfirst($viewName);

        if (false === class_exists($modelClass)) {
            $modelClass = 'PMenuModelsDefault';
        }

        $view = new $viewClass(new $modelClass, $paths);


        $view->setLayout($layoutName);

        if (isset($vars)) {
            foreach ($vars as $varName => $var)
            {
                $view->$varName = $var;
            }
        }


        $val = "In View Helper --Path, Paths, viewName, layoutname, view";               //### DEBUG
        $obj = array(JPATH_COMPONENT . '/views/' . strtolower($viewName) . '/tmpl', $paths, $viewName, $layoutName, $view);                       //### DEBUG
        file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG


        return $view;
    }

    function getHtml($view, $layout, $item, $data)
    {
        $objectView = PMenuHelpersView::load($view, $layout, 'phtml');
        $objectView->$item = $data;

        ob_start();
        echo $objectView->render();
        $html = ob_get_contents();
        ob_clean();

        return $html;
    }

}
