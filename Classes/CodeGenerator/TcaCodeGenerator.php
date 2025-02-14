<?php

declare(strict_types=1);

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace MASK\Mask\CodeGenerator;

use MASK\Mask\Definition\PaletteDefinition;
use MASK\Mask\Definition\TableDefinition;
use MASK\Mask\Definition\TableDefinitionCollection;
use MASK\Mask\Definition\TcaFieldDefinition;
use MASK\Mask\Enumeration\FieldType;
use MASK\Mask\Utility\AffixUtility;
use MASK\Mask\Utility\DateUtility;
use TYPO3\CMS\Core\Information\Typo3Version;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;

/**
 * Generates all the TCA needed for mask content elements and backend layout fields.
 *
 * @internal
 */
class TcaCodeGenerator
{
    /**
     * @var TableDefinitionCollection
     */
    protected $tableDefinitionCollection;

    public function __construct(TableDefinitionCollection $tableDefinitionCollection)
    {
        $this->tableDefinitionCollection = $tableDefinitionCollection;
    }

    /**
     * Generates and sets the correct tca for all the inline fields
     */
    public function setInlineTca(TableDefinitionCollection $tableDefinitionCollection = null): void
    {
        $this->tableDefinitionCollection = $tableDefinitionCollection ?? $this->tableDefinitionCollection;
        foreach ($this->tableDefinitionCollection as $tableDefinition) {
            $table = $tableDefinition->table;
            if (!AffixUtility::hasMaskPrefix($table)) {
                continue;
            }
            // Ignore table with missing tca
            if (empty($tableDefinition->tca)) {
                continue;
            }
            // Enhance boilerplate table tca with user settings
            $GLOBALS['TCA'][$table] = $this->generateTableTca($tableDefinition);
            ExtensionManagementUtility::addTCAcolumns($table, $this->generateFieldsTca($table));
        }
    }

    /**
     * Generates the TCA for a new custom table.
     */
    public function generateTableTca(TableDefinition $tableDefinition): array
    {
        $table = $tableDefinition->table;
        // Generate Table TCA
        $processedTca = $this->processTableTca($tableDefinition);
        $parentTable = $this->tableDefinitionCollection->getTableByField($table);

        if ($parentTable === '') {
            throw new \InvalidArgumentException(sprintf('No parent table found for field "%s".', $table), 1629495345);
        }

        // Adjust TCA-Template
        $tableTca = self::getTcaTemplate();
        $appendLanguageTab = ',--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language';
        $appendAccessTab = ',--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;;access';

        $tableTca['ctrl']['title'] = $table;
        $tableTca['ctrl']['label'] = $processedTca['label'];
        $tableTca['ctrl']['iconfile'] = 'EXT:mask/Resources/Public/Icons/Extension.svg';

        // Hide table in list view
        $tableTca['ctrl']['hideTable'] = true;
        $tableTca['types']['1']['showitem'] = $processedTca['showitem'] . $appendLanguageTab . $appendAccessTab;

        $tableTca['columns']['l10n_parent']['config']['foreign_table'] = $table;
        $tableTca['columns']['l10n_parent']['config']['foreign_table_where'] = "AND $table.pid=###CURRENT_PID### AND $table.sys_language_uid IN (-1, 0)";

        $tableTca['columns']['parentid']['config']['foreign_table'] = $parentTable;
        $tableTca['columns']['parentid']['config']['foreign_table_where'] = "AND $parentTable.pid=###CURRENT_PID### AND $parentTable.sys_language_uid IN (-1, ###REC_FIELD_sys_language_uid###)";

        // Add palettes
        foreach ($tableDefinition->palettes as $palette) {
            $tableTca['palettes'][$palette->key] = $this->generatePalettesTca($palette, $table);
        }

        $field = $this->tableDefinitionCollection->getTable($parentTable)->tca->getField($table);
        // Set label for inline if defined
        if ($field->inlineLabel !== '' && $tableDefinition->tca->hasField($field->inlineLabel)) {
            $tableTca['ctrl']['label'] = $field->inlineLabel;
        }

        // Set icon for inline
        if ($field->inlineIcon !== '') {
            $tableTca['ctrl']['iconfile'] = $field->inlineIcon;
        }
        return $tableTca;
    }

    /**
     * Generates and sets the tca for all content elements.
     */
    public function setElementsTca(): void
    {
        if (!$this->tableDefinitionCollection->hasTable('tt_content')) {
            return;
        }

        $defaultTabs = ',--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended';
        $prependTabs = '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,';
        $defaultPalette = '--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,';

        // Add gridelements fields, to make mask work with gridelements out of the box
        $gridelements = '';
        if (ExtensionManagementUtility::isLoaded('gridelements')) {
            $gridelements = ', tx_gridelements_container, tx_gridelements_columns';
        }

        // Add new group in CType selectbox
        ExtensionManagementUtility::addTcaSelectItemGroup(
            'tt_content',
            'CType',
            'mask',
            'LLL:EXT:mask/Resources/Private/Language/locallang_mask.xlf:new_content_element_tab',
            'after:default'
        );

        $tt_content = $this->tableDefinitionCollection->getTable('tt_content');

        foreach ($tt_content->palettes as $palette) {
            $GLOBALS['TCA']['tt_content']['palettes'][$palette->key] = $this->generatePalettesTca($palette, 'tt_content');
        }

        foreach ($tt_content->elements as $element) {
            if ($element->hidden) {
                continue;
            }

            $cTypeKey = AffixUtility::addMaskCTypePrefix($element->key);

            // Optional shortLabel
            $label = $element->shortLabel ?: $element->label;

            // Add new entry in CType selectbox
            ExtensionManagementUtility::addTcaSelectItem(
                'tt_content',
                'CType',
                [
                    $label,
                    $cTypeKey,
                    'mask-ce-' . $element->key,
                    'mask'
                ]
            );

            // Add all the fields that should be shown
            [$prependTabs, $fields] = $this->generateShowItem($prependTabs, $element->key, 'tt_content');

            $GLOBALS['TCA']['tt_content']['ctrl']['typeicon_classes'][$cTypeKey] = 'mask-ce-' . $element->key;
            $GLOBALS['TCA']['tt_content']['types'][$cTypeKey]['columnsOverrides']['bodytext']['config']['enableRichtext'] = 1;
            $GLOBALS['TCA']['tt_content']['types'][$cTypeKey]['showitem'] = $prependTabs . $defaultPalette . $fields . $defaultTabs . $gridelements;
        }
    }

    /**
     * Returns the palettes of a page layout for the given key.
     */
    public function getPagePalettes(string $elementKey): array
    {
        $palettes = [];
        $pages = $this->tableDefinitionCollection->getTable('pages');
        $element = $pages->elements->getElement($elementKey);
        foreach ($element->columns as $column) {
            if ($this->tableDefinitionCollection->getFieldType($column, 'pages')->equals(FieldType::PALETTE)) {
                $palettes[$column] = $this->generatePalettesTca($pages->palettes->getPalette($column), 'pages');
            }
        }
        return $palettes;
    }

    /**
     * Generates the showitem string for pages
     */
    public function getPageShowItem(string $layoutKey): string
    {
        $prependTabs = '--div--;Content-Fields,';
        [$prependTabs, $fields] = $this->generateShowItem($prependTabs, $layoutKey, 'pages');

        return ',' . $prependTabs . $fields;
    }

    /**
     * Generates the showitem string for the given
     */
    protected function generateShowItem(string $prependTabs, string $elementKey, string $table): array
    {
        $element = $this->tableDefinitionCollection->getTable($table)->elements->getElement($elementKey);
        $fieldArray = [];
        foreach ($element->columns as $index => $fieldKey) {
            $fieldType = $this->tableDefinitionCollection->getFieldType($fieldKey, $table);
            // Check if this field is of type tab
            if ($fieldType->equals(FieldType::TAB)) {
                $label = $this->tableDefinitionCollection->getLabel($elementKey, $fieldKey, $table);
                // If a tab is in the first position then change the name of the general tab
                if ($index === 0) {
                    $prependTabs = '--div--;' . $label . ',';
                } else {
                    // Otherwise just add new tab
                    $fieldArray[] = '--div--;' . $label;
                }
            } elseif ($fieldType->equals(FieldType::PALETTE)) {
                $fieldArray[] = '--palette--;;' . $fieldKey;
            } else {
                $fieldArray[] = $fieldKey;
            }
        }
        $fields = implode(',', $fieldArray);

        return [$prependTabs, $fields];
    }

    /**
     * Generates the TCA needed for palettes.
     */
    protected function generatePalettesTca(PaletteDefinition $palette, string $table): array
    {
        $showitem = [];
        foreach ($palette->showitem as $item) {
            if ($this->tableDefinitionCollection->getFieldType($item, $table)->equals(FieldType::LINEBREAK)) {
                $showitem[] = '--linebreak--';
            } else {
                $showitem[] = $item;
            }
        }

        $description = $palette->description;
        if ($description === '') {
            $paletteField = $this->tableDefinitionCollection->loadField($table, $palette->key);
            if ($paletteField instanceof TcaFieldDefinition) {
                $description = $paletteField->description;
            }
        }

        return [
            'label' => $palette->label,
            'description' => $description,
            'showitem' => implode(',', $showitem)
        ];
    }

    /**
     * Generates the TCA for fields
     */
    public function generateFieldsTca(string $table): array
    {
        // Early return if page does not exist.
        if (!$this->tableDefinitionCollection->hasTable($table)) {
            return [];
        }

        $additionalTca = [];
        foreach ($this->tableDefinitionCollection->getTable($table)->tca as $field) {
            // Ignore core fields
            if ($field->isCoreField) {
                continue;
            }

            if (!$field->type) {
                $field->type = $this->tableDefinitionCollection->getFieldType($field->fullKey, $table);
            }

            // Inline: Ignore empty inline fields
            if ($field->type && $field->type->isParentField() && !$this->tableDefinitionCollection->hasTable($field->fullKey)) {
                continue;
            }

            // Ignore grouping elements
            if ($field->type->isGroupingField()) {
                continue;
            }

            $additionalTca[$field->fullKey] = [];

            // File: Add file config.
            if ($field->type->equals(FieldType::FILE)) {
                if ($field->imageoverlayPalette) {
                    $customSettingOverride = [
                        'overrideChildTca' => [
                            'types' => [
                                '0' => [
                                    'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                                ],
                                File::FILETYPE_TEXT => [
                                    'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                                ],
                                File::FILETYPE_IMAGE => [
                                    'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                                ],
                                File::FILETYPE_AUDIO => [
                                    'showitem' => '
                                --palette--;;audioOverlayPalette,
                                --palette--;;filePalette'
                                ],
                                File::FILETYPE_VIDEO => [
                                    'showitem' => '
                                --palette--;;videoOverlayPalette,
                                --palette--;;filePalette'
                                ],
                                File::FILETYPE_APPLICATION => [
                                    'showitem' => '
                                --palette--;;imageoverlayPalette,
                                --palette--;;filePalette'
                                ]
                            ],
                        ],
                    ];
                }

                $customSettingOverride['appearance'] = $field->realTca['config']['appearance'] ?? [];
                $customSettingOverride['appearance']['fileUploadAllowed'] = (bool)($customSettingOverride['appearance']['fileUploadAllowed'] ?? true);
                $customSettingOverride['appearance']['useSortable'] = (bool)($customSettingOverride['appearance']['useSortable'] ?? false);
                if ($field->allowedFileExtensions === '') {
                    $field->allowedFileExtensions = $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext'];
                }
                $additionalTca[$field->fullKey]['config'] = ExtensionManagementUtility::getFileFieldTCAConfig($field->fullKey, $customSettingOverride, $field->allowedFileExtensions);
                unset($customSettingOverride);
            }

            // Inline (Repeating): Fill missing foreign_table in tca config.
            if (($field->realTca['config']['foreign_table'] ?? '') === '--inlinetable--') {
                $field->realTca['config']['foreign_table'] = $field->fullKey;
            }

            // Convert Date and Datetime default and ranges to timestamp
            $dbType = $field->realTca['config']['dbType'] ?? '';
            if (in_array($dbType, ['date', 'datetime'])) {
                $default = $field->realTca['config']['default'] ?? false;
                if ($default) {
                    $field->realTca['config']['default'] = DateUtility::convertStringToTimestampByDbType($dbType, $default);
                }
                $upper = $field->realTca['config']['range']['upper'] ?? false;
                if ($upper) {
                    $field->realTca['config']['range']['upper'] = DateUtility::convertStringToTimestampByDbType($dbType, $upper);
                }
                $lower = $field->realTca['config']['range']['lower'] ?? false;
                if ($lower) {
                    $field->realTca['config']['range']['lower'] = DateUtility::convertStringToTimestampByDbType($dbType, $lower);
                }
            }

            // Text: Set correct rendertype if format (code highlighting) is set.
            if ($field->realTca['config']['format'] ?? false) {
                $field->realTca['config']['renderType'] = 't3editor';
            }

            // RTE: Add softref
            if ($field->type->equals(FieldType::RICHTEXT)) {
                $field->realTca['config']['softref'] = 'typolink_tag,email[subst],url';
            }

            // Content: Set foreign_field and default CType in select if restricted.
            if ($field->type->equals(FieldType::CONTENT)) {
                $parentField = AffixUtility::addMaskParentSuffix($field->fullKey);
                $field->realTca['config']['foreign_field'] = $parentField;
                if ($table === 'tt_content') {
                    $additionalTca[$parentField] = [
                        'config' => [
                            'type' => 'passthrough'
                        ]
                    ];
                }
                if (!empty($field->cTypes)) {
                    $field->realTca['config']['overrideChildTca']['columns']['CType']['config']['default'] = reset($field->cTypes);
                }
            }

            // Exlcude all fields for editors by default
            $field->realTca['exclude'] = 1;

            // Merge user inputs with file array (for file type overrides)
            ArrayUtility::mergeRecursiveWithOverrule($additionalTca[$field->fullKey], $field->realTca);
        }
        return $additionalTca;
    }

    /**
     * Generates TCA columns overrides for labels and descriptions.
     */
    public function generateTCAColumnsOverrides(string $table): array
    {
        if (!$this->tableDefinitionCollection->hasTable($table)) {
            return [];
        }

        $TCAColumnsOverrides = [];
        $tableDefinition = $this->tableDefinitionCollection->getTable($table);

        // Go through all root fields defined in elements and find possible overrides.
        foreach ($tableDefinition->elements as $element) {
            $cType = AffixUtility::addMaskCTypePrefix($element->key);
            foreach ($element->columns as $index => $fieldName) {
                $fieldDefinition = $this->tableDefinitionCollection->loadField($table, $fieldName);
                if (!$fieldDefinition instanceof TcaFieldDefinition) {
                    continue;
                }

                // As this is called very early, TCA for core fields might not be loaded yet. So ignore them.
                if (!$fieldDefinition->isCoreField && $fieldDefinition->type->equals(FieldType::PALETTE)) {
                    foreach ($this->tableDefinitionCollection->loadInlineFields($fieldName, $element->key) as $paletteField) {
                        $label = $paletteField->getLabel($element->key);
                        if ($label !== '') {
                            $TCAColumnsOverrides[$table]['types'][$cType]['columnsOverrides'][$paletteField->fullKey]['label'] = $label;
                        }
                        $description = $paletteField->getDescription($element->key);
                        if ($description !== '') {
                            $TCAColumnsOverrides[$table]['types'][$cType]['columnsOverrides'][$paletteField->fullKey]['description'] = $description;
                        }
                    }
                } else {
                    $label = $element->labels[$index] ?? '';
                    if ($label !== '') {
                        $TCAColumnsOverrides[$table]['types'][$cType]['columnsOverrides'][$fieldDefinition->fullKey]['label'] = $label;
                    }

                    $description = $element->descriptions[$index] ?? '';
                    if ($description !== '') {
                        $TCAColumnsOverrides[$table]['types'][$cType]['columnsOverrides'][$fieldDefinition->fullKey]['description'] = $description;
                    }
                }
            }
        }

        return $TCAColumnsOverrides;
    }

    /**
     * Processes the TCA for Inline-Tables
     */
    public function processTableTca(TableDefinition $tableDefinition): array
    {
        $generalTab = '--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general';
        $fields = [];
        $firstField = true;
        foreach ($tableDefinition->tca as $field) {
            // check if this field is of type tab
            $fieldType = $this->tableDefinitionCollection->getFieldType($field->fullKey, $tableDefinition->table);
            if ($fieldType->equals(FieldType::TAB)) {
                // if a tab is in the first position then change the name of the general tab
                if ($firstField) {
                    $generalTab = '--div--;' . $field->label;
                } else {
                    // otherwise just add new tab
                    $fields[] = '--div--;' . $field->label;
                }
            } elseif ($fieldType->equals(FieldType::PALETTE)) {
                if ($firstField && empty($tableDefinition->palettes->getPalette($field->fullKey)->showitem)) {
                    $firstField = false;
                    continue;
                }
                $fields[] = '--palette--;;' . $field->fullKey;
            } elseif (!$field->inPalette) {
                $fields[] = $field->fullKey;
            }
            $firstField = false;
        }

        // take first field for inline label
        $labelField = '';
        if (!empty($fields)) {
            $labelField = $this->getFirstNoneTabField($fields);
            // If first field is palette, get label of first field in this palette.
            if (strpos($labelField, '--palette--;;') === 0) {
                $palette = str_replace('--palette--;;', '', $labelField);
                $labelField = $tableDefinition->palettes->getPalette($palette)->showitem[0];
            }
        }

        return [
            'label' => $labelField,
            'showitem' => $generalTab . ',' . implode(',', $fields),
        ];
    }

    /**
     * Add search fields to find mask elements or pages
     */
    public function addSearchFields(string $table): void
    {
        if (!$this->tableDefinitionCollection->hasTable($table)) {
            return;
        }

        $tca = $this->tableDefinitionCollection->getTable($table)->tca;
        $searchFields = [];

        foreach ($tca as $field) {
            $fieldType = $this->tableDefinitionCollection->getFieldType($field->fullKey, $table);
            if ($fieldType->isSearchable()) {
                $searchFields[] = $field->key;
            }
        }

        if ($searchFields) {
            $GLOBALS['TCA'][$table]['ctrl']['searchFields'] .= ',' . implode(',', $searchFields);
        }
    }

    /**
     * Searches an array of strings and returns the first string, that is not a tab
     * @todo Move test cases to processTableTca and set protected.
     */
    public function getFirstNoneTabField(array $fields): string
    {
        if (!empty($fields)) {
            $potentialFirst = array_shift($fields);
            if (!is_string($potentialFirst) || strpos($potentialFirst, '--div--') !== false) {
                return $this->getFirstNoneTabField($fields);
            }
            return $potentialFirst;
        }
        return '';
    }

    protected static function getTcaTemplate(): array
    {
        if ((new Typo3Version())->getMajorVersion() === 11) {
            $sys_language_uid = [
                'type' => 'language'
            ];
        } else {
            $sys_language_uid = [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ],
                ],
                'default' => 0,
            ];
        }

        return [
            'ctrl' => [
                'sortby' => 'sorting',
                'tstamp' => 'tstamp',
                'crdate' => 'crdate',
                'cruser_id' => 'cruser_id',
                'editlock' => 'editlock',
                'versioningWS' => true,
                'origUid' => 't3_origuid',
                'languageField' => 'sys_language_uid',
                'transOrigPointerField' => 'l10n_parent',
                'translationSource' => 'l10n_source',
                'transOrigDiffSourceField' => 'l10n_diffsource',
                'delete' => 'deleted',
                'enablecolumns' => [
                    'disabled' => 'hidden',
                    'starttime' => 'starttime',
                    'endtime' => 'endtime',
                    'fe_group' => 'fe_group'
                ],
            ],
            'palettes' => [
                'language' => [
                    'showitem' => '
                        sys_language_uid;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:sys_language_uid_formlabel,l18n_parent
                    ',
                ],
                'hidden' => [
                    'showitem' => '
                        hidden;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:field.default.hidden
                    ',
                ],
                'access' => [
                    'label' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access',
                    'showitem' => '
                        starttime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:starttime_formlabel,
                        endtime;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:endtime_formlabel,
                        --linebreak--,
                        fe_group;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:fe_group_formlabel,
                        --linebreak--,editlock
                    ',
                ],
            ],
            'columns' => [
                'editlock' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:editlock',
                    'config' => [
                        'type' => 'check',
                        'renderType' => 'checkboxToggle',
                        'items' => [
                            [
                                0 => '',
                                1 => '',
                            ]
                        ],
                    ]
                ],
                'sys_language_uid' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
                    'config' => $sys_language_uid
                ],
                'l10n_parent' => [
                    'displayCond' => 'FIELD:sys_language_uid:>:0',
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectSingle',
                        'items' => [
                            [
                                '',
                                0
                            ]
                        ],
                        'default' => 0
                    ]
                ],
                'l10n_diffsource' => [
                    'config' => [
                        'type' => 'passthrough'
                    ],
                ],
                'hidden' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
                    'config' => [
                        'type' => 'check',
                        'renderType' => 'checkboxToggle',
                        'items' => [
                            [
                                0 => '',
                                1 => '',
                                'invertStateDisplay' => true
                            ]
                        ],
                    ]
                ],
                'starttime' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
                    'config' => [
                        'type' => 'input',
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                        'default' => 0
                    ],
                    'l10n_mode' => 'exclude',
                    'l10n_display' => 'defaultAsReadonly'
                ],
                'endtime' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
                    'config' => [
                        'type' => 'input',
                        'renderType' => 'inputDateTime',
                        'eval' => 'datetime,int',
                        'default' => 0,
                        'range' => [
                            'upper' => mktime(0, 0, 0, 1, 1, 2038)
                        ]
                    ],
                    'l10n_mode' => 'exclude',
                    'l10n_display' => 'defaultAsReadonly'
                ],
                'fe_group' => [
                    'exclude' => true,
                    'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.fe_group',
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectMultipleSideBySide',
                        'size' => 5,
                        'maxitems' => 20,
                        'items' => [
                            [
                                'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hide_at_login',
                                -1
                            ],
                            [
                                'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.any_login',
                                -2
                            ],
                            [
                                'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.usergroups',
                                '--div--'
                            ]
                        ],
                        'exclusiveKeys' => '-1,-2',
                        'foreign_table' => 'fe_groups',
                    ]
                ],
                'parentid' => [
                    'config' => [
                        'type' => 'select',
                        'renderType' => 'selectSingle',
                        'items' => [
                            ['', 0],
                        ],
                        'default' => 0
                    ],
                ],
                'parenttable' => [
                    'config' => [
                        'type' => 'passthrough',
                    ],
                ],
                'sorting' => [
                    'config' => [
                        'type' => 'passthrough',
                    ],
                ],
            ],
        ];
    }
}
