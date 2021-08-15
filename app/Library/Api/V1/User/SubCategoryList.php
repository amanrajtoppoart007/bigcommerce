<?php


namespace App\Library\Api\V1\User;


class SubCategoryList
{
    public $subCategories;

    public function __construct($subCategories)
    {
        $this->subCategories = $subCategories;
    }

    public function execute()
    {
        $data = [];
        if (!empty($this->subCategories)) {
            $i = 0;
            foreach ($this->subCategories as $subCategory) {
                $data[$i]['id'] = $subCategory['id'];
                $data[$i]['name'] = $subCategory['name'];
                $data[$i]['description'] = $subCategory['description'];
                $data[$i]['category'] = $subCategory['category']['name'];
                if (isset($subCategory['photo']['thumbnail'])) {
                    $data[$i]['thumb_link'] = $subCategory['photo']['thumbnail'] ? $subCategory['photo']['thumbnail'] : null;
                } else {
                    $data[$i]['thumb_link'] = null;
                }
                $i++;
            }
        }
        return $data;
    }
}

