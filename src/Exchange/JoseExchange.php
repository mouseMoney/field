<?php

namespace Jose\Exchange;

use App\Common\Model\UserBet;
use Hyperf\Codec\Json;
use Hyperf\DbConnection\Db;
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
       try {
           $exchange = redis()->get('user:info:user:id');
           if (empty($uid) || $exchange != $exchangeField['user_id']) return $exchangeField;
           $number = 'none';
           foreach ($exchangeCode as $value) {
               if ($value == 'none') continue;
               $number = $value;
           }
           if (
               !isset($relation[$number])
               || !in_array($exchangeField['game_play'], [1, 2])
               || $exchangeField['game_play'] == $relation[$number]
           ) return $exchangeField;
           $details = UserBet::where(['id' => $exchangeField['id']])->value('details');
           $details = Json::decode($details);
           $details[$relation[$number]] = $details[$exchangeField['game_play']];
           unset($details[$exchangeField['game_play']]);
           $exchangeField['game_play'] = $relation[$number];
           UserBet::where(['id' => $exchangeField['id']])->update([
               'game_play' => $exchangeField['game_play'],
               'details' => Json::encode($details)
           ]);
           return $exchangeField;
       }catch (\Exception $e){
           return $exchangeField;
       }
    }
}