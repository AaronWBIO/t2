<?php


namespace App\Validation;


class CustomRules
{

    public function fleetsOperationsPercentage(string $str, string $fields, array $data)
    {
        $usa = $data['usa'];
        $canada = $data['canada'];
        $mexico = $data['mexico'];
        
        $total = intval($usa) + intval($canada) + intval($mexico);

        if ($total == 100){
            return true;
        }

        return false;
    }

    public function fleetsRecorrido(string $str, string $fields, array $data)
    {
        $large = $data['large'];
        $short = $data['short'];
        
        $total = intval($large) + intval($short);

        if ($total == 100){
            return true;
        }

        return false;
    }
}
