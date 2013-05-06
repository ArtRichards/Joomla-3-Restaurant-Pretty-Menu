<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class PMenuViewsStatisticsHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
   
    //retrieve task list from model
    $model = new PMenuModelsStatistics();
    $this->stats = $model->getStats();

    $this->addToolbar();

    //display
    return parent::render();
  } 

    /**
     * Add the page title and toolbar.
     *
     * @since   1.6
     */
    protected function addToolbar()
    {
        $canDo  = PMenuHelpersPMenu::getActions();

        // Get the toolbar object instance
        $bar = JToolBar::getInstance('toolbar');

        JToolbarHelper::title(JText::_('COM_PMENU_STATISTICS'));
               
        if ($canDo->get('core.admin'))
        {
            JToolbarHelper::preferences('com_pmenu');
        }
    }
}