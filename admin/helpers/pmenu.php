<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 *
 * @copyright   Copyright (C) 2013 Art Richards.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

/**
 * PMenu component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 */
class PMenuHelpersPMenu {

    public static $extension = 'com_pmenu';

    /**
     * @return  JObject
     */
    public static function getActions()
    {
        $user = JFactory::getUser();
        $result = new JObject;

        $assetName = 'com_pmenu';
        $level = 'component';

        $actions = JAccess::getActions('com_pmenu', $level);

        foreach ($actions as $action)
        {
            $result->set($action->name, $user->authorise($action->name, $assetName));
        }

        return $result;
    }

    public static function getAssociations($pk, $extension = 'com_content')
    {
        $associations = array();
        $db = JFactory::getDbo();
        // ### TODO: Add menu items in addition to menus here
        $query = $db->getQuery(true)
                ->from('#__pmenu_menus as c')
                ->join('INNER', '#__associations as a ON a.id = c.id AND a.context=' . $db->quote('com_categories.item'))
                ->join('INNER', '#__associations as a2 ON a.key = a2.key')
                ->join('INNER', '#__categories as c2 ON a2.id = c2.id AND c2.extension = ' . $db->quote($extension))
                ->where('c.id =' . (int) $pk)
                ->where('c.extension = ' . $db->quote($extension));
        $select = array(
            'c2.language',
            $query->concatenate(array('c2.id', 'c2.alias'), ':') . ' AS id'
        );
        $query->select($select);
        $db->setQuery($query);
        $contentitems = $db->loadObjectList('language');

        // Check for a database error.
        if ($error = $db->getErrorMsg()) {
            JError::raiseWarning(500, $error);
            return false;
        }

        foreach ($contentitems as $tag => $item)
        {
            $associations[$tag] = $item->id;
        }

        return $associations;
    }

}