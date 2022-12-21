<?php

class AbbreviationPageController extends ContentController
{

    private static $url_handlers = array(
        '$Item!' => 'viewItem'
    );
    private static $allowed_actions = array(
        'viewItem'
    );

    public function index()
    {
        return $this->renderWith(array('AbbreviationPage', 'Page'));
    }

    public function viewItem()
    {
        $item = $this->getItem($this->request->param('Item'));
        if (!$item) {
            $this->httpError(404);
        }
        return $this->customise(array('Item' => $item))->renderWith(array('AbbreviationPage_view', 'Page'));
    }

    public function getItem($slug)
    {
        return Abbreviation::get()->filter(array('URLSlug' => $slug))->first();
    }

    public function getItems()
    {
        return Abbreviation::get()->sort('Title');
    }

    public function getGroupedItems()
    {
        return GroupedList::create($this->getItems());
    }

    public function getFirstLetterNavigation()
    {
        $menu = array();
        foreach (range('A', 'Z') as $char) {
            $menu[$char] = ArrayData::create(array('Title' => $char));
        }

        foreach ($this->getGroupedItems()->GroupedBy('TitleFirstLetter') as $item) {
            $firstLetter = $item->TitleFirstLetter;

            if (array_key_exists($firstLetter, $menu)) {
                $menu[$firstLetter]->setField('hasItems', true);
            } else {
                $menu[$firstLetter] = ArrayData::create(
                    array('Title' => $firstLetter, 'hasItems' => true)
                );
            }
        }

        ksort($menu);

        return ArrayList::create($menu);
    }
}

