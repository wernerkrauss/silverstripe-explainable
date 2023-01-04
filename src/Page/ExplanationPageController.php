<?php

namespace Netwerkstatt\Explainable\Page;

use Netwerkstatt\Explainable\Model\Explanation;

class ExplanationPageController extends AbbreviationPageController
{
    /**
     * @config
     */
    private static $url_handlers = ['$Item!' => 'viewItem'];

    /**
     * @config
     */
    private static $allowed_actions = ['viewItem'];

    public function viewItem()
    {
        $item = $this->getItem($this->request->param('Item'));
        if (!$item) {
            $this->httpError(404);
        }

        return $this->customise(['Item' => $item])->renderWith(['ExplanationPage_view', 'Page']);
    }

    public function getItem($slug)
    {
        return Explanation::get()->filter(['URLSlug' => $slug])->first();
    }

    public function getItems()
    {
        return Explanation::get()->sort('Title');
    }
}
