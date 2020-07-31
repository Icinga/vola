<?php
// vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+

namespace Icinga\Module\Vola\Forms;

use Icinga\Data\Filter\Filter;
use Icinga\Forms\RepositoryForm;

/**
 * Create, update and delete columns
 */
class ColumnForm extends RepositoryForm
{
    protected function createInsertElements(array $formData)
    {
        $this->addElement(
            'text',
            'name',
            [
                'label'         => $this->translate('Name'),
                'description'   => $this->translate('The column name'),
                'required'      => true
            ]
        );

        $this->createUpdateElements($formData);
        $this->setSubmitLabel($this->translate('Create'));
    }

    protected function createUpdateElements(array $formData)
    {
        $this->addElement(
            'text',
            'pattern',
            [
                'label'         => $this->translate('Pattern'),
                'description'   => sprintf(
                    $this->translate('The pattern of valid column values as regex, e.g. %s'),
                    '[a-z]{10}\\.example\\.com'
                ),
                'required'      => true
            ]
        );

        $this->setSubmitLabel($this->translate('Save'));
    }

    protected function createDeleteElements(array $formData)
    {
        $this->setSubmitLabel($this->translate('Yes'));
        $this->setAttrib('class', 'icinga-controls');
    }

    protected function createFilter()
    {
        return Filter::where('name', $this->getIdentifier());
    }

    protected function getInsertMessage($success)
    {
        return $success
            ? $this->translate('Column created')
            : $this->translate('Failed to create column');
    }

    protected function getUpdateMessage($success)
    {
        return $success
            ? $this->translate('Column updated')
            : $this->translate('Failed to update column');
    }

    protected function getDeleteMessage($success)
    {
        return $success
            ? $this->translate('Column removed')
            : $this->translate('Failed to remove column');
    }
}
