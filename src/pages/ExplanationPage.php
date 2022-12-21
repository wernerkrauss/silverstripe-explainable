<?php

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

class ExplanationPage_Controller extends AbbreviationPage_Controller
{
    private static $url_handlers = array(
        '$Item!' => 'viewItem'
    );
    private static $allowed_actions = array(
        'viewItem'
    );

    public function viewItem()
    {
        $item = $this->getItem($this->request->param('Item'));
        if (!$item) {
            $this->httpError(404);
        }
        return $this->customise(array('Item' => $item))->renderWith(array('ExplanationPage_view', 'Page'));
    }

    public function getItem($slug)
    {
        return Explanation::get()->filter(array('URLSlug' => $slug))->first();
    }

    public function getItems()
    {
        return Explanation::get()->sort('Title');
    }
}
