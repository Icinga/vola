<?php
// vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+

namespace Icinga\Module\Vola\Controllers;

use Icinga\Exception\NotFoundError;
use Icinga\Module\Vola\ColumnsIniRepository;
use Icinga\Module\Vola\Forms\ColumnForm;
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
     * Create a column
     */
    public function newAction()
    {
        $form = $this->prepareForm()->add();
        $form->handleRequest();
        $this->renderForm($form, $this->translate('New Column'));
    }

    /**
     * Update a column
     */
    public function updateAction()
    {
        $form = $this->prepareForm()->edit($this->params->getRequired('name'));

        try {
            $form->handleRequest();
        } catch (NotFoundError $_) {
            $this->httpNotFound($this->translate('Column not found'));
        }

        $this->renderForm($form, $this->translate('Update Column'));
    }

    /**
     * Remove a column
     */
    public function removeAction()
    {
        $form = $this->prepareForm()->remove($this->params->getRequired('name'));

        try {
            $form->handleRequest();
        } catch (NotFoundError $_) {
            $this->httpNotFound($this->translate('Column not found'));
        }

        $this->renderForm($form, $this->translate('Remove Column'));
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

    /**
     * Assert permission and return a prepared ColumnForm
     *
     * @return ColumnForm
     */
    protected function prepareForm()
    {
        $this->assertPermission('config/modules');

        return (new ColumnForm())
            ->setRepository($this->getRepo())
            ->setRedirectUrl(Url::fromPath('vola/columns'));
    }
}
