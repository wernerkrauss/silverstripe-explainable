<?php

use src\Page;

class AbbreviationPage extends Page
{

    public static $has_many = array(
        'Abbreviations' => 'Abbreviation'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $conf = GridFieldConfig_RecordEditor::create();
        $grid = GridField::create('Abbreviations', $this->fieldLabel('Abbreviations'), $this->Abbreviations(), $conf);
        $tabTitle = $this->fieldLabel('Abbreviations');
        $fields->addFieldsToTab('Root.' . $tabTitle, $grid);

        return $fields;
    }

    /**
     * If you add <% loop $AdditionalBreadcrumbsAfter %> to your BreadcrumbsTemplate you can
     * @return ArrayList
     */
    public function getAdditionalBreadcrumbsAfter()
    {
        $pages = ArrayList::create();
        $currentController = Controller::curr();
        $slug = $currentController->request->param('Item');
        $item = ($slug && $currentController->hasMethod('getItem')) ? $currentController->getItem($slug) : false;
        if ($slug && $item) {
            $pages->push($item);
        }
        return $pages;
    }
}

