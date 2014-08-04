<?php
// src/Schuma/UserBundle/SchumaUserBundle.php

namespace Schuma\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class SchumaUserBundle extends Bundle{

    public function getParent(){
        return 'FOSUserBundle';
    }
}
