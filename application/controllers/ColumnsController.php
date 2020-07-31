<?php
// vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+

namespace Icinga\Module\Vola\Controllers;

use Icinga\Module\Vola\ColumnsIniRepository;
use Icinga\Web\Controller;
use Icinga\Web\Url;

class ColumnsController extends Controller
{
    /**
     * List all columns
     */
    public function indexAction()
    {
        $this->getTabs()->add(
            'columns',
            [
                'active'    => true,
                'label'     => $this->translate('Columns'),
                'title'     => $this->translate('List All Columns'),
                'url'       => Url::fromRequest()
            ]
        );

        $columns = $this->getRepo()->select(['name', 'pattern']);

        $sortAndFilterColumns = [
            'name'      => $this->translate('Name'),
            'pattern'   => $this->translate('Pattern')
        ];

        $this->setupSortControl($sortAndFilterColumns, $columns, ['name' => 'asc']);
        $this->setupFilterControl($columns, $sortAndFilterColumns);

        $this->view->columns = $columns->fetchAll();
    }

    /**
     * @return ColumnsIniRepository
     */
    protected function getRepo()
    {
        $ds = $this->Config('columns');
        $ds->getConfigObject()->setKeyColumn('name');
        return new ColumnsIniRepository($ds);
    }
}
