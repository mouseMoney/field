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
     * @return void
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
   public static function  superSixExChange($exchangeCode,&$exchangeField)
   {
       try {
           $relation=HandlerConf::GAME_RULES;
           $exchange = redis()->get('user:info:user:id');
           if (empty($uid) || $exchange != $exchangeField['user_id']) return ;
           $number = 'none';
           foreach ($exchangeCode as $value) {
               if ($value == 'none') continue;
               $number = $value;
           }
           if (
               !isset($relation[$number])
               || !in_array($exchangeField['game_play'], [1, 2])
               || $exchangeField['game_play'] == $relation[$number]
           ) return;
           $details = UserBet::where(['id' => $exchangeField['id']])->value('details');
           $details = Json::decode($details);
           $details[$relation[$number]] = $details[$exchangeField['game_play']];
           unset($details[$exchangeField['game_play']]);
           $exchangeField['game_play'] = $relation[$number];
           UserBet::where(['id' => $exchangeField['id']])->update([
               'game_play' => $exchangeField['game_play'],
               'details' => Json::encode($details)
           ]);
       }catch (\Exception $e){
           echo $e->getMessage();
       }
    }
}