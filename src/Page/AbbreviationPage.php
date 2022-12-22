<?php

namespace Netwerkstatt\Explainable\Page;

use Page;




use Netwerkstatt\Explainable\Model\Abbreviation;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Control\Controller;

class AbbreviationPage extends Page
{

    private static string $table_name = 'AbbreviationPage';

    public static $has_many = ['Abbreviations' => Abbreviation::class];

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
        $slug = $currentController->getRequest()->param('Item');
        $item = ($slug && $currentController->hasMethod('getItem')) ? $currentController->getItem($slug) : false;
        if ($slug && $item) {
            $pages->push($item);
        }

        return $pages;
    }
}
