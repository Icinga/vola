<?php
// vola: Icinga Director random import | (c) 2020 Icinga GmbH | GPLv2+

namespace Icinga\Module\Vola\ProvidedHook\Director;

use Icinga\Application\Config;
use Icinga\Module\Director\Hook\ImportSourceHook;
use Icinga\Module\Director\Web\Form\QuickForm;
use Icinga\Module\Vola\ColumnsIniRepository;
use Icinga\Module\Vola\MtRandGenerator;
use ReverseRegex\Generator\Scope;
use ReverseRegex\Lexer;
use ReverseRegex\Parser;

class ImportSource extends ImportSourceHook
{
    public function getName()
    {
        return mt('vola', 'Random (Vola)');
    }

    public function fetchData()
    {
        $columns = $this->getColumns();

        foreach ($columns as &$pattern) {
            $pattern = (new Parser(new Lexer($pattern), new Scope(), new Scope()))->parse()->getResult();
        }

        /** @var Scope[] $columns */

        $data = [];
        $generator = new MtRandGenerator();

        for ($i = mt_rand((int) $this->getSetting('rows_min'), (int) $this->getSetting('rows_max')); $i > 0; --$i) {
            $row = [];

            foreach ($columns as $name => $pattern) {
                $pattern->generate($row[$name], $generator);
            }

            $data[] = (object) $row;
        }

        return $data;
    }

    public function listColumns()
    {
        return array_keys($this->getColumns());
    }

    public static function addSettingsFormFields(QuickForm $form)
    {
        // TODO: make number elements

        $form->addElement('text', 'rows_min', [
            'label'         => $form->translate('At least x rows'),
            'description'   => $form->translate('Minimum amount of rows to import'),
            'required'      => true
        ]);

        $form->addElement('text', 'rows_max', [
            'label'         => $form->translate('At most y rows'),
            'description'   => $form->translate('Maximum amount of rows to import'),
            'required'      => true
        ]);

        return $form;
    }

    /**
     * @return string[]
     */
    protected function getColumns()
    {
        $ds = Config::module('vola', 'columns');
        $ds->getConfigObject()->setKeyColumn('name');
        return (new ColumnsIniRepository($ds))->select(['name', 'pattern'])->fetchPairs();
    }
}
