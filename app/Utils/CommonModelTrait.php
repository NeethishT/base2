<?php
namespace App\Utils;


trait CommonModelTrait
{
    public static function getGroupedValues(string $fieldName){
        $data = Self::groupBy($fieldName)->orderBy($fieldName)->get([$fieldName])->map(function ($value, $key) use ($fieldName) {
            return $value[$fieldName];
        })->filter(function ($item) {
            return empty($item) === false ? true : false;
        })->toArray();
        return array_combine($data, $data);
    }
}
