<?php

use src\Page;

class ExplanationPage extends Page
{

    public static $has_many = array(
        'Explanations' => 'Explanation'
    );


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

