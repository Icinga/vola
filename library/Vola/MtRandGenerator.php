<?php
// vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+

namespace Icinga\Module\Vola;

use Icinga\Exception\NotImplementedError;
use PHPStats\Generator\GeneratorInterface;

class MtRandGenerator implements GeneratorInterface
{
    public function generate($min = 0, $max = null)
    {
        return mt_rand($min, $max);
    }

    public function seed($seed = null)
    {
        throw new NotImplementedError('%s', __METHOD__);
    }

    public function max()
    {
        return mt_getrandmax();
    }
}
