<?php

namespace Athena\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AthenaUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
