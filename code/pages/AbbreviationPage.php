<?php

class AbbreviationPage extends Page {

	public static $has_many = array(
		'Abbreviations' => 'Abbreviation'
	);

	public function getCMSFields() {
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
	public function getAdditionalBreadcrumbsAfter() {
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

class AbbreviationPage_Controller extends ContentController {

	private static $url_handlers = array(
		'$Item!' => 'viewItem'
	);
	private static $allowed_actions = array(
		'viewItem'
	);

	public function index() {
		return $this->renderWith(array('AbbreviationPage', 'Page'));
	}

	public function viewItem() {
		$item = $this->getItem($this->request->param('Item'));
		if(!$item) $this->httpError(404);
		return $this->customise(array('Item' => $item))->renderWith(array('AbbreviationPage_view', 'Page'));
	}

	public function getItem($slug) {
		return Abbreviation::get()->filter(array('URLSlug' => $slug))->first();
	}

	public function getItems() {
		return Abbreviation::get()->sort('Title');
	}

	public function Link($action = null) {
		return Controller::join_links('/', $this->config()->get('url_segment'), $action);
	}

	function AbsoluteLink() {
		return Director::absoluteURL($this->Link());
	}


	public function getGroupedItems() {
		return GroupedList::create($this->getItems());
	}

	public function getFirstLetterNavigation() {
		$menu = array();
		foreach (range('A', 'Z') as $char) {
				$menu[$char] = ArrayData::create(array('Title' => $char));
		}

		foreach ($this->getGroupedItems()->GroupedBy('TitleFirstLetter') as $item) {
			$firstLetter = $item->TitleFirstLetter;

			if(array_key_exists($firstLetter, $menu)) {
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
