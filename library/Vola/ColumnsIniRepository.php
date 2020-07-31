<?php
// vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+

namespace Icinga\Module\Vola;

use Icinga\Repository\IniRepository;

class ColumnsIniRepository extends IniRepository
{
    protected $queryColumns = ['column' => ['name', 'pattern']];

    protected $configs = ['column' => ['keyColumn' => 'name']];
}
