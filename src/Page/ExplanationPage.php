<?php

namespace Netwerkstatt\Explainable\Page;

use Page;


use Netwerkstatt\Explainable\Model\Explanation;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridField;

class ExplanationPage extends Page
{

    private static string $table_name = 'ExplanationPage';

    private static $has_many = ['Explanations' => Explanation::class];


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $conf = GridFieldConfig_RecordEditor::create();
        $grid = GridField::create('Explanations', $this->fieldLabel('Explanations'), $this->Explanations(), $conf);
        $tabTitle = $this->fieldLabel('Explanations');
        $fields->addFieldsToTab('Root.' . $tabTitle, $grid);

        return $fields;
    }
}
