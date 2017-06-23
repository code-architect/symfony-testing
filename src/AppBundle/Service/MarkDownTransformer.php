<?php


namespace AppBundle\Service;


class MarkDownTransformer
{

    public function parse($str)
    {
        return strtoupper($str);
    }


}