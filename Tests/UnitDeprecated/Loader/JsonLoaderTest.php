<?php

namespace MASK\Mask\Tests\UnitDeprecated\Loader;

use MASK\Mask\Enumeration\FieldType;
use MASK\Mask\Loader\JsonLoader;
use MASK\Mask\Tests\Unit\ConfigurationLoader\FakeConfigurationLoader;
use MASK\Mask\Tests\Unit\PackageManagerTrait;
use TYPO3\TestingFramework\Core\Unit\UnitTestCase;

class JsonLoaderTest extends UnitTestCase
{
    use PackageManagerTrait;

    /**
     * @test
     */
    public function legacyRteFormatCompatibilityLayerWorks(): void
    {
        $this->registerPackageManager();

        $jsonLoader = new JsonLoader(
            [
                'json' => 'EXT:mask/Tests/UnitDeprecated/Fixtures/Configuration/legacyRte.json',
            ]
        );

        $jsonLoader->setConfigurationLoader(new FakeConfigurationLoader());

        $tableDefinitionCollection = $jsonLoader->load();
        self::assertTrue($tableDefinitionCollection->loadField('tt_content', 'tx_mask_rte')->type->equals(FieldType::RICHTEXT), 'Field tx_mask_rte is not a richtext.');
    }
}
