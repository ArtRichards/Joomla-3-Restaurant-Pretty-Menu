<?php 

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class PMenuControllersDefault extends JControllerBase
{
  public function execute()
  {

    // Get the application
    $app = $this->getApplication();
 
    // ### SECURITY CHECK
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
    $document     = JFactory::getDocument();
 
    $viewName     = $app->input->getWord('view', 'restaurant');
    $viewFormat   = $document->getType();
    $layoutName   = $app->input->getWord('layout', 'menu');

    $app->input->set('view', $viewName);
 
 
    $viewClass  = 'PMenuViews' . ucfirst($viewName) . ucfirst($viewFormat);
    $modelClass = 'PMenuModels' . ucfirst($viewName);
    //Is this legal, man?  ### TODO: check security
    
    

    if (false === class_exists($modelClass))
    {
      $modelClass = 'PMenuModelsDefault';
    }
    // Register the layout paths _for the view_
    $paths = new SplPriorityQueue();
    $paths->insert(JPATH_COMPONENT . '/views/' . $viewName . '/tmpl', 'normal');

    $view = new $viewClass(new $modelClass, $paths);
    
    $val= "Inside default controller:  View, layout name";               //### DEBUG
    $obj = array($view, $layoutName);              //### DEBUG
    file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG


    $view->setPaths($paths);
    $view->setLayout($layoutName);

    $val= "Inside default controller:  View with layout";               //### DEBUG
    $obj = array($view);              //### DEBUG
    file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

    
    // Render our view.
    echo $view->render();
 
    return true;
  }

}