<?php

class ShortCodeAddNewExtension extends Extension {

	private static $add_new_shortcodes = array('Abbreviation', 'Explanation');

	/**
	 * add "Add new" button to a shortcode dropdown
	 * @param $form
	 */
	public function updateShortcodeForm(Form $form) {
		$fields = $form->Fields();

		$shortCodeName = $fields->dataFieldByName('ShortcodeType')->Value();

		if (in_array($shortCodeName, Config::inst()->get('ShortCodeAddNewExtension', 'add_new_shortcodes'))) {
			$idField = $fields->dataFieldByName('id');

			$getter = function() use ($shortCodeName) {
				return $shortCodeName::get()->map()->toArray();
			};
			$idField->useAddNew($shortCodeName, $getter);

			$form->setFields($fields);
		}

	}
}
