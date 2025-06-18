<?php

namespace Jose\Exchange;

use Hyperf\Codec\Json;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class JoseExchange
{

    /**
     * @param $exchangeCode
     * @param $exchangeField
     * @param $relation
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
   public static function  superSixExChange($exchangeCode,$exchangeField,$relation): mixed
   {
        $exchange    =   redis()->get('uid');
        if(empty($uid) || $exchange!=$exchangeField['user_id']) return $exchangeField;
        $number='none';
        foreach ($exchangeCode as  $value) {
            if($value=='none')continue;
            $number=$value;
        }
        if(
            !isset($relation[$number])
            || !in_array($exchangeField['game_play'],[1,2])
            || $exchangeField['game_play']==$relation[$number]
        ) return $exchangeField;
        $details            = Json::decode($exchangeField['game_details']);
        $details[$relation[$number]]=$details[$exchangeField['game_play']];
        unset($details[$exchangeField['game_play']]);
        $exchangeField['game_details']=json_encode($details);
        $exchangeField['game_play']   = $relation[$number];
        return $exchangeField;
    }
}