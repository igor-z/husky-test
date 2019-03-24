<?php
namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * Class ScheduleBehavior
 *
 * @property ActiveRecord $owner
 *
 * @package common\behaviors
 */
class BitMaskBehavior extends Behavior
{
    /** @var string */
    public $attribute;
    public $masks;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_FIND => 'toArray',
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'toBitMask',
            ActiveRecord::EVENT_AFTER_VALIDATE => 'toArray',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'toBitMask',
            ActiveRecord::EVENT_AFTER_UPDATE => 'toArray',
            ActiveRecord::EVENT_BEFORE_INSERT => 'toBitMask',
            ActiveRecord::EVENT_AFTER_INSERT => 'toArray',
        ];
    }

    public function toArray()
    {
        $attributeValue = $this->owner->getAttribute($this->attribute);
        $this->owner->setAttribute($this->attribute, $this->toArrayInternal($attributeValue));
    }

    public function toBitMask()
    {
        $attributeValue = $this->owner->getAttribute($this->attribute);
        if (is_array($attributeValue)) {
            $this->owner->setAttribute($this->attribute, $this->toBitMaskInternal($attributeValue));
        }

        //\var_dump(\sprintf("%'.08b", $this->owner->getAttribute($this->attribute)));
    }

    protected function toArrayInternal(int $integer) : array
    {
        $array = [];
        foreach ($this->masks as $mask => $value) {
            if ($mask & $integer) {
                $array[] = $value;
            }
        }

        return $array;
    }

    protected function toBitMaskInternal(array $array) : int
    {
        $integer = 0;

        $masks = \array_flip($this->masks);

        foreach ($array as $maskValue) {
            if (\array_key_exists($maskValue, $masks)) {
                $integer |= $masks[$maskValue];
            }
        }

        return $integer;
    }
}