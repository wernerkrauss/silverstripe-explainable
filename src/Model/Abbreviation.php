<?php

namespace Netwerkstatt\Explainable\Model;


use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;


class Abbreviation extends DataObject
{

    private static $db = [
        'Title' => 'Varchar(255)',
        'Description' => 'Varchar(255)',
        'URLSlug' => 'Varchar(255)',
        'Explanation' => 'HTMLText'
    ];

    private static $has_one = [
        'Page' => 'Page'
    ];

    private static $singular_name = 'Abbreviation';

    private static $plural_name = 'Abbreviations';

    private static $summary_fields = ['Title', 'Description'];

    private static $searchable_fields = ['Title', 'Description'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('URLSlug');
        return $fields;
    }

    /**
     * Taken from https://github.com/NightJar/ssrigging-slug/blob/master/code/Slug.php
     */
    public function Slug($regen = false)
    {
        $existing = $this->URLSlug;
        return $existing && !$regen ? $existing : URLSegmentFilter::create()->filter($this->Title);
    }

    /**
     * Taken from https://github.com/NightJar/ssrigging-slug/blob/master/code/Slug.php
     */
    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if ($this->isChanged('URLSlug') || !$this->URLSlug || $this->isChanged($this->Title)) {
            $this->URLSlug = $this->Slug();
            $class = $this->class;
            $filter = ['URLSlug' => $this->URLSlug];
            if ($parent = $this->parentRel) {
                $filter[$parent] = $this->$parent;
            }
            $count = 1;
            while ($exists = $class::get()->filter($filter)->exclude('ID', $this->ID)->exists()) {
                $this->URLSlug = $this->URLSlug . $count++;
                $filter['URLSlug'] = $this->URLSlug;
            }
        }
    }

    public function Link()
    {
        return Controller::join_links($this->Page()->Link(), $this->URLSlug);
    }

    public function AbsoluteLink()
    {
        return Director::absoluteURL($this->Link());
    }

    public function forTemplate()
    {
        $template = new SSViewer(__CLASS__);
        return $template->process($this);
    }


    /**
     * Used for Breadcrumbs
     *
     * @return DBField
     */
    public function getMenuTitle()
    {
        return $this->dbObject('Title');
    }

    /**
     * Returns the first letter of the module title, used for grouping.
     * @return string
     */
    public function getTitleFirstLetter()
    {
        return strtoupper($this->Title[0]);
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
            $abbreviation = Abbreviation::get()->byID($arguments['id']);
        }

        if (!$abbreviation) {
            return;
        }

        if (array_key_exists('title', $arguments) && $arguments['title']) {
            $abbreviation->Title = $arguments['title'];
        }

        $template = new SSViewer('AbbreviationShortcode');
        return $template->process($abbreviation);
    }

}
