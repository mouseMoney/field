<?php

namespace Jose\Annotation;

use Attribute;
use Hyperf\Di\Annotation\AbstractAnnotation;


#[Attribute(Attribute::TARGET_METHOD)]
class Jose extends AbstractAnnotation
{
    public function __construct(public $name){}
}