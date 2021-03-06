<?php

declare(strict_types=1);

/**
 * This file is part of Code Generator for Magento.
 * (c) 2017. Rostyslav Tymoshenko <krifollk@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Krifollk\CodeGenerator\Model\Generator\Crud\Controller\Adminhtml;

use Krifollk\CodeGenerator\Api\GeneratorResultInterface;

use Krifollk\CodeGenerator\Model\Generator\Crud\UiComponent\ListingGenerator;
use Krifollk\CodeGenerator\Model\GeneratorResult;
use Krifollk\CodeGenerator\Model\ModuleNameEntity;

/**
 * Class SaveActionGenerator
 *
 * @package Krifollk\CodeGenerator\Model\Generator\Crud\Controller\Adminhtml
 */
class SaveActionGenerator extends AbstractAction
{
    /**
     * @inheritdoc
     */
    protected function requiredArguments(): array
    {
        return array_merge(
            parent::requiredArguments(),
            ['entityRepository', 'entity', 'dataPersistorEntityKey', 'entityInterface']
        );
    }

    /**
     * @inheritdoc
     * @throws \RuntimeException
     */
    protected function internalGenerate(
        ModuleNameEntity $moduleNameEntity,
        array $additionalArguments = []
    ): GeneratorResultInterface {
        $entityName = $additionalArguments['entityName'];
        $dataPersistorEntityKey = $additionalArguments['dataPersistorEntityKey'];
        $entityRepository = $additionalArguments['entityRepository'];
        $entityInterface = $additionalArguments['entityInterface'];
        $requestFieldName = ListingGenerator::REQUEST_FIELD_NAME;
        $entityFactory = sprintf('%sFactory', $additionalArguments['entity']);

        return new GeneratorResult(
            $this->codeTemplateEngine->render('crud/controller/adminhtml/save', [
                    'namespace'        => $this->generateNamespace($moduleNameEntity, $entityName),
                    'entityRepository' => $entityRepository,
                    'entityFactory'    => $entityFactory,
                    'idFieldName'      => $requestFieldName,
                    'dataPersistorKey' => $dataPersistorEntityKey,
                    'entityInterface'  => $entityInterface
                ]
            ),
            $this->generateFilePath($moduleNameEntity, $entityName, 'Save'),
            $this->generateEntityName($moduleNameEntity, $entityName, 'Save')
        );
    }
}
