<?php

namespace Syntro\SilverstripeElementalImage\Element;

use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\Assets\Image as SSImage;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TabSet;
use SilverStripe\Forms\Tab;
use SilverStripe\Forms\FieldList;
use DNADesign\Elemental\Models\BaseElement;
use Syntro\SilverstripeElementalElementals\Traits\TranslatableConfigArrays;

/**
 * An image allows the placement of an image in the pageflow
 *
 * @author Matthias Leutenegger <hello@syntro.ch>
 */
class Image extends BaseElement
{
    use TranslatableConfigArrays;

    /**
     * Defines the database table name
     * @config
     *  @var string
     */
    private static $table_name = 'ElementImage';

    /**
    * @config
     * @var string
     */
    private static $icon = 'font-icon-block-file';

    /**
     * Singular name for CMS
     * @config
     *  @var string
     */
    private static $singular_name = 'Image';

    /**
     * Plural name for CMS
     * @config
     *  @var string
     */
    private static $plural_name = 'Images';

    /**
    * @config
     * @var bool
     */
    private static $inline_editable = true;

    /**
     * @config
     * @var bool
     */
    private static $allow_title_customization = false;

    /**
     * Display a show title button
     *
     * @config
     * @var boolean
     */
    private static $displays_title_in_template = false;

    /**
     * available aspect options
     *
     * @config
     * @var array
     */
    private static $aspectratio_options = [
        '1x1' => '1x1',
        '4x3' => '4x3',
        '16x9' => '16x9',
        '21x9' => '21x9',
    ];

    /**
     * Database fields
     * @config
     * @var array
     */
    private static $db = [
        'AspectRatio' => 'Varchar',
    ];

    /**
     * Has_one relationship
     * @config
     * @var array
     */
    private static $has_one = [
        'Image' => SSImage::class,
    ];

    /**
     * Relationship version ownership
     * @config
     * @var array
     */
    private static $owns = [
        'Image'
    ];

    /**
     * CMS Fields
     * @return FieldList
     */
    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->removeByName([
            'AspectRatio'
        ]);
        $fields->addFieldToTab(
            'Root.Main',
            $uploadfield = UploadField::create(
                'Image',
                'Image'
            )
        );
        $uploadfield
            ->setFolderName('Uploads/Elements/Image');
        return $fields;
    }


    /**
     * getType
     *
     * @return string
     */
    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Image');
    }

    /**
     * @return array
     */
    protected function provideBlockSchema()
    {
        $blockSchema = parent::provideBlockSchema();
        $blockSchema['content'] = static::getTranslatedConfigArrayOption('aspectratio_options', $this->Spacing);
        /** @var SSImage|null */
        $image = $this->Image();
        if ($image && $image->exists() && $image->getIsImage()) {
            $blockSchema['fileURL'] = $image->CMSThumbnail()->getURL();
            $blockSchema['fileTitle'] = $image->getTitle();
        }
        return $blockSchema;
    }
}
