<?php
namespace App\Helpers;

class RequestHelper {
    public static function sanitize(array $datas, array $ignores=[]): array {
        $result = [];
        foreach($datas as $key => $value) {
            if(in_array($key, $ignores)){
                $result[$key] = $value;
                continue;
            }
            if(is_array($value)) {
                $items = [];
                foreach($value as $subKey => $subValue) {
                    if(is_array($subValue)) {
                        $subItems = [];
                        foreach($subValue as $subSubKey => $subSubValue) {
                            if(in_array("*{$subSubKey}", $ignores)){
                                $subItems[$subSubKey] = $subSubValue;
                                continue;
                            }
                            $subItems[$subSubKey] = strip_tags($subSubValue);
                        }
                        $items[$subKey] = $subItems;
                        continue;
                    }
                    $items[$subKey] = strip_tags($subValue);
                }
                $result[$key] = $items;
                continue;
            }
            $result[$key] = strip_tags($value);
        }

        return $result;
    }
}