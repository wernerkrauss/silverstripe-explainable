<?php

namespace Netwerkstatt\Explainable\Page;

use Netwerkstatt\Explainable\Page\AbbreviationPage;
use Netwerkstatt\Explainable\Model\Abbreviation;
use SilverStripe\ORM\GroupedList;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\CMS\Controllers\ContentController;

class AbbreviationPageController extends ContentController
{

    private static $url_handlers = ['$Item!' => 'viewItem'];

    private static $allowed_actions = ['viewItem'];

    public function index()
    {
        return $this->renderWith([AbbreviationPage::class, 'Page']);
    }

    public function viewItem()
    {
        $item = $this->getItem($this->request->param('Item'));
        if (!$item) {
            $this->httpError(404);
        }

        return $this->customise(['Item' => $item])->renderWith(['AbbreviationPage_view', 'Page']);
    }

    public function getItem($slug)
    {
        return Abbreviation::get()->filter(['URLSlug' => $slug])->first();
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
        $menu = [];
        foreach (range('A', 'Z') as $char) {
            $menu[$char] = ArrayData::create(['Title' => $char]);
        }

        foreach ($this->getGroupedItems()->GroupedBy('TitleFirstLetter') as $item) {
            $firstLetter = $item->TitleFirstLetter;

            if (array_key_exists($firstLetter, $menu)) {
                $menu[$firstLetter]->setField('hasItems', true);
            } else {
                $menu[$firstLetter] = ArrayData::create(
                    ['Title' => $firstLetter, 'hasItems' => true]
                );
            }
        }

        ksort($menu);

        return ArrayList::create($menu);
    }
}
