<?php

namespace Jose\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Jose\Annotation\Jose;

#[Aspect]
class ExchangeAspect extends AbstractAspect
{
    public array $annotations=[
        Jose::class
    ];
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        //转换。。。
         $result      = $proceedingJoinPoint->process();
         $exchangeId  = redis()->get('uid');
         foreach ($result as $item){
             if($item['user_id']==$exchangeId){
                 unset($item['user_id']);
             }
         }
         return $result;
    }

}