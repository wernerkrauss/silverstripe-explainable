<?php

namespace Netwerkstatt\Explainable\Page;


use Netwerkstatt\Explainable\Model\Explanation;



class ExplanationPageController extends AbbreviationPageController
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
