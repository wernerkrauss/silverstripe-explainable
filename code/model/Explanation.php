<?php

class Explanation extends Abbreviation implements Shortcodable {


    private static $singular_name = 'Explanation';

    private static $plural_name = 'Explanations';


	public function forTemplate() {
		$template = new SSViewer('Explanation');
		return $template->process($this);
	}

	/**
	 * Parse the shortcode and render as a string, probably with a template
	 * @param array $arguments the list of attributes of the shortcode
	 * @param string $content the shortcode content
	 * @param ShortcodeParser $parser the ShortcodeParser instance
	 * @param string $shortcode the raw shortcode being parsed
	 * @return String
	 **/
	public static function parse_shortcode($arguments, $content, $parser, $shortcode) {
		if (empty($arguments['id'])) {
			return;
		}

		if (array_key_exists('id', $arguments) && $arguments['id']) {
			$explanation = Explanation::get()->byID($arguments['id']);
		}

		if (!$explanation) {
			return;
		}

		if(array_key_exists('title', $arguments) && $arguments['title']) {
			$explanation->Title = $arguments['title'];
		}

		$template = new SSViewer('ExplanationShortcode');
		return $template->process($explanation);	}

	/**
	 * returns a list of fields for editing the shortcode's attributes
	 * @return Fieldlist
	 **/
	public static function shortcode_attribute_fields() {
		//@todo use addnew field to add a new abbr. on the fly
	}
}
