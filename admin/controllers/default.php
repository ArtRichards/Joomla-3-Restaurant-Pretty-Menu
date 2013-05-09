<?php

defined('_JEXEC') or die('Restricted access');

class PMenuControllersDefault extends JControllerBase {

    public function execute()
    {

        // Get the application
        $app = $this->getApplication();
        
        $params = JComponentHelper::getParams('com_prettymenu');
        if ($params->get('required_account') == 1) 
        {
            $user = JFactory::getUser();
            if ($user->get('guest'))
            {
                $app->redirect('index.php',JText::_('COM_LENDR_ACCOUNT_REQUIRED_MSG'));
            }
        }
 
        // Get the document object.
        $document = JFactory::getDocument();

        $viewName = $app->input->getWord('view', 'menus');
        $viewFormat = $document->getType();
        $layoutName = $app->input->getWord('layout', 'default');

        $app->input->set('view', $viewName);

        // Register the layout paths for the view
        $paths = new SplPriorityQueue;
        $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');

        $viewClass = 'PMenuViews' . ucfirst($viewName) . ucfirst($viewFormat);
        $modelClass = 'PMenuModels' . ucfirst($viewName);

        $view = new $viewClass(new $modelClass, $paths);

        $view->setLayout($layoutName);

        // Render our view.
        echo $view->render();

        return true;
    }

}