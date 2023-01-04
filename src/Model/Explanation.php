<?php

namespace Netwerkstatt\Explainable\Model;

use SilverStripe\View\SSViewer;

class Explanation extends Abbreviation
{


    /**
     * @config
     */
    private static $table_name = 'Explanation';

    /**
     * @config
     */
    private static $singular_name = 'Explanation';

    /**
     * @config
     */
    private static $plural_name = 'Explanations';


    public function forTemplate()
    {
        $template = \SilverStripe\View\SSViewer::create(self::class);
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
    public static function parse_shortcode($arguments, $content, $parser, $shortcode)
    {
        if (empty($arguments['id'])) {
            return;
        }

        if (array_key_exists('id', $arguments) && $arguments['id']) {
            $explanation = Explanation::get()->byID($arguments['id']);
        }

        if (!$explanation instanceof \SilverStripe\ORM\DataObject) {
            return;
        }

        if (array_key_exists('title', $arguments) && $arguments['title']) {
            $explanation->Title = $arguments['title'];
        }

        $template = \SilverStripe\View\SSViewer::create('ExplanationShortcode');
        return $template->process($explanation);
    }
}
