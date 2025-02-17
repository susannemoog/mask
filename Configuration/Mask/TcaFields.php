<?php

use MASK\Mask\Enumeration\FieldType;

return [
    'config.default' => [
        'collision' => true,
        'other' => [
            'type' => 'variable',
            'rows' => 5,
            'label' => 'tx_mask.field.string.default',
            'description' => 'tx_mask.field.string.default.description',
            'code' => 'default',
            'documentation' => 'ColumnsConfig/Type/inputDefault.html#default',
        ],
        'check' => [
            'type' => 'number',
            'min' => 0,
            'max' => 31,
            'code' => 'default',
            'label' => 'tx_mask.field.string.default',
            'description' => 'tx_mask.field.check.default.description',
            'documentation' => 'ColumnsConfig/Type/checkDefault.html#default'
        ]
    ],
    'config.placeholder' => [
        'type' => 'variable',
        'types' => [
            FieldType::TEXT => 'textarea',
            FieldType::RICHTEXT => 'textarea',
        ],
        'rows' => 5,
        'label' => 'tx_mask.field.string.placeholder',
        'description' => 'tx_mask.field.string.placeholder.description',
        'code' => 'placeholder',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#placeholder',
    ],
    'config.size' => [
        'collision' => true,
        'other' => [
            'type' => 'number',
            'label' => 'tx_mask.field.string.size',
            'description' => 'tx_mask.field.string.size.description',
            'code' => 'size',
            'documentation' => 'ColumnsConfig/Type/inputDefault.html#size',
            'min' => 10,
            'max' => 50,
            'step' => 5
        ],
        'select' => [
            'type' => 'number',
            'min' => 1,
            'label' => 'tx_mask.field.select.size',
            'description' => 'tx_mask.field.select.size.description',
            'code' => 'size',
            'documentation' => 'ColumnsConfig/Type/selectSingle.html#size'
        ],
        'group' => [
            'type' => 'number',
            'min' => 1,
            'label' => 'tx_mask.field.select.size',
            'description' => 'tx_mask.field.select.size.description',
            'code' => 'size',
            'documentation' => 'ColumnsConfig/Type/selectSingle.html#size'
        ]
    ],
    'config.max' => [
        'type' => 'number',
        'label' => 'tx_mask.field.float.max',
        'description' => 'tx_mask.field.float.max.description',
        'code' => 'max',
        'min' => 0,
        'max' => 512,
        'step' => 10,
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#max'
    ],
    'config.is_in' => [
        'type' => 'text',
        'label' => 'tx_mask.field.string.is_in',
        'description' => 'tx_mask.field.string.is_in.description',
        'code' => 'is_in',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#is-in'
    ],
    // This is for timestamp only to define the date format
    'config.eval' => [
        'type' => 'radio',
        'label' => 'tx_mask.field.timestamp_eval',
        'description' => 'tx_mask.field.timestamp.eval',
        'code' => 'eval',
        'items' => [
            'date' => 'tx_mask.field.date_selection',
            'datetime' => 'tx_mask.field.datetime_selection',
            'time' => 'tx_mask.field.time_selection',
            'timesec' => 'tx_mask.field.timesec_selection'
        ],
        'documentation' => 'ColumnsConfig/Type/inputDateTime.html#eval'
    ],
    // This is for slug only to define slug config
    'config.eval.slug' => [
        'type' => 'radio',
        'label' => 'tx_mask.field.slug_eval',
        'description' => 'tx_mask.field.slug_eval.description',
        'code' => 'eval',
        'items' => [
            'unique' => 'tx_mask.field.slug_unique',
            'uniqueInSite' => 'tx_mask.field.slug_unique_in_site',
            'uniqueInPid' => 'tx_mask.field.slug_unique_in_pid',
        ],
        'documentation' => 'ColumnsConfig/Type/Slug.html#eval'
    ],
    'config.generatorOptions.fields' => [
        'type' => 'text',
        'label' => 'tx_mask.field.slug.generatorOptions.fields',
        'description' => 'tx_mask.field.slug.generatorOptions.fields.description',
        'code' => 'generatorOptions.fields',
        'documentation' => 'ColumnsConfig/Type/Slug.html#generatoroptions'
    ],
    'config.generatorOptions.fieldSeparator' => [
        'type' => 'text',
        'label' => 'tx_mask.field.slug.generatorOptions.fieldSeparator',
        'description' => 'tx_mask.field.slug.generatorOptions.fieldSeparator.description',
        'code' => 'generatorOptions.fieldSeparator',
        'documentation' => 'ColumnsConfig/Type/Slug.html#generatoroptions'
    ],
    'config.generatorOptions.prefixParentPageSlug' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.slug.generatorOptions.prefixParentPageSlug',
        'description' => 'tx_mask.field.slug.generatorOptions.prefixParentPageSlug.description',
        'code' => 'generatorOptions.prefixParentPageSlug',
        'documentation' => 'ColumnsConfig/Type/Slug.html#generatoroptions'
    ],
    'config.generatorOptions.replacements' => [
        'type' => 'textarea',
        'rows' => 5,
        'label' => 'tx_mask.field.slug.generatorOptions.replacements',
        'description' => 'tx_mask.field.slug.generatorOptions.replacements.description',
        'code' => 'generatorOptions.replacements',
        'documentation' => 'ColumnsConfig/Type/Slug.html#generatoroptions'
    ],
    'config.prependSlash' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.slug.prependSlash',
        'description' => 'tx_mask.field.slug.prependSlash.description',
        'code' => 'prependSlash',
        'documentation' => 'ColumnsConfig/Type/Slug.html#prependslash'
    ],
    'config.fallbackCharacter' => [
        'type' => 'text',
        'label' => 'tx_mask.field.slug.fallbackCharacter',
        'description' => 'tx_mask.field.slug.fallbackCharacter.description',
        'code' => 'fallbackCharacter',
        'documentation' => 'ColumnsConfig/Type/Slug.html#fallbackcharacter'
    ],
    'config.eval.required' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.required',
        'description' => 'tx_mask.field.required.description',
        'code' => 'required',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=required#eval'
    ],
    'config.eval.trim' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.trim',
        'description' => 'tx_mask.field.trim.description',
        'code' => 'trim',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=trim#eval'
    ],
    'config.eval.alpha' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.alpha.label',
        'description' => 'tx_mask.field.alpha',
        'code' => 'alpha',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=alpha#eval'
    ],
    'config.eval.num' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.num.label',
        'description' => 'tx_mask.field.num',
        'code' => 'num',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#eval'
    ],
    'config.eval.alphanum' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.alphanum.label',
        'description' => 'tx_mask.field.alphanum',
        'code' => 'alphanum',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=alphanum#eval'
    ],
    'config.eval.alphanum_x' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.alphanum_x.label',
        'description' => 'tx_mask.field.alphanum_x',
        'code' => 'alphanum_x',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=alphanum_x#eval'
    ],
    'config.eval.domainname' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.domainname.label',
        'description' => 'tx_mask.field.domainname',
        'code' => 'domainname',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=domainname#eval'
    ],
    'config.eval.email' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.email.label',
        'description' => 'tx_mask.field.email',
        'code' => 'email',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=email#eval'
    ],
    'config.eval.lower' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.lower.label',
        'description' => 'tx_mask.field.lower',
        'code' => 'lower',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=lower#eval'
    ],
    'config.eval.upper' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.upper.label',
        'description' => 'tx_mask.field.upper',
        'code' => 'upper',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=upper#eval'
    ],
    'config.eval.unique' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.unique.label',
        'description' => 'tx_mask.field.unique',
        'code' => 'unique',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=unique#eval'
    ],
    'config.eval.uniqueInPid' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.uniqueInPid.label',
        'description' => 'tx_mask.field.uniqueInPid',
        'code' => 'uniqueInPid',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=uniqueInPid#eval'
    ],
    'config.eval.nospace' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.nospace.label',
        'description' => 'tx_mask.field.nospace',
        'code' => 'nospace',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=nospace#eval'
    ],
    'config.eval.md5' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.md5.label',
        'description' => 'tx_mask.field.md5',
        'code' => 'md5',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=md5#eval'
    ],
    'config.eval.null' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.null.label',
        'description' => 'tx_mask.field.null',
        'code' => 'null',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=null#eval'
    ],
    'config.eval.password' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.password.label',
        'description' => 'tx_mask.field.password',
        'code' => 'password',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=password#eval'
    ],
    'config.mode' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.string.mode.label',
        'description' => 'tx_mask.field.string.mode',
        'code' => 'mode',
        'dependsOn' => 'config.eval.null',
        'valueOn' => 'useOrOverridePlaceholder',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#mode'
    ],
    'config.autocomplete' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.string.autocomplete.label',
        'description' => 'tx_mask.field.string.autocomplete',
        'code' => 'autocomplete',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#autocomplete'
    ],
    'config.behaviour.allowLanguageSynchronization' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.allowLanguageSynchronization',
        'description' => 'tx_mask.allowLanguageSynchronization.description',
        'code' => 'allowLanguageSynchronization',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#allowlanguagesynchronization'
    ],
    'config.range.lower' => [
        'type' => 'variable',
        'label' => 'tx_mask.field.float.range.lower',
        'code' => 'range.lower',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#range'
    ],
    'config.range.upper' => [
        'type' => 'variable',
        'label' => 'tx_mask.field.float.range.upper',
        'code' => 'range.upper',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html#range'
    ],
    'config.slider.step' => [
        'type' => 'number',
        'label' => 'tx_mask.config.slider.step',
        'description' => 'tx_mask.config.slider.step.description',
        'code' => 'slider.step',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=step#slider',
    ],
    'config.slider.width' => [
        'type' => 'number',
        'label' => 'tx_mask.config.slider.width',
        'description' => 'tx_mask.config.slider.width.description',
        'min' => 200,
        'step' => 50,
        'code' => 'slider.width',
        'documentation' => 'ColumnsConfig/Type/inputDefault.html?highlight=width#slider',
    ],
    'config.fieldControl.linkPopup.options.allowedExtensions' => [
        'type' => 'text',
        'label' => 'tx_mask.field.link.wizard.allowed_extensions',
        'description' => 'tx_mask.field.link.wizard.allowed_extensions.description',
        'code' => 'allowedExtensions',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=allowedExtensions#linkpopup',
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions' => [
        'type' => 'plainText',
        'label' => 'tx_mask.blindLinkOptions',
        'description' => 'tx_mask.blindLinkOptions.description',
        'code' => 'blindLinkOptions',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions.file' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.link.file',
        'code' => 'file',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
        'invert' => true
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions.mail' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.link.mail',
        'code' => 'mail',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
        'invert' => true
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions.page' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.link.page',
        'code' => 'page',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
        'invert' => true
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions.folder' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.link.folder',
        'code' => 'folder',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
        'invert' => true
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions.url' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.link.url',
        'code' => 'url',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
        'invert' => true
    ],
    'config.fieldControl.linkPopup.options.blindLinkOptions.telephone' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.link.telephone',
        'code' => 'telephone',
        'documentation' => 'ColumnsConfig/Type/inputLink.html?highlight=blindLinkOptions#linkpopup',
        'invert' => true
    ],
    'config.cols' => [
        'collision' => true,
        'check' => [
            'type' => 'text',
            'label' => 'tx_mask.content.check.columns',
            'description' => 'tx_mask.content.check.columns.description',
            'code' => 'cols',
            'documentation' => 'ColumnsConfig/Type/checkDefault.html#cols'
        ],
        'other' => [
            'type' => 'number',
            'label' => 'tx_mask.field.text.cols',
            'description' => 'tx_mask.field.text.cols.description',
            'code' => 'cols',
            'min' => 10,
            'max' => 50,
            'step' => 5,
            'documentation' => 'ColumnsConfig/Type/textDefault.html#cols'
        ]
    ],
    'config.rows' => [
        'type' => 'number',
        'label' => 'tx_mask.field.text.rows',
        'description' => 'tx_mask.field.text.rows.description',
        'code' => 'rows',
        'min' => 2,
        'max' => 20,
        'step' => 2,
        'documentation' => 'ColumnsConfig/Type/textDefault.html#rows'
    ],
    'config.format' => [
        'type' => 'radio',
        'label' => 'tx_mask.field.text.format',
        'code' => 'format',
        'items' => [
            '' => 'tx_mask.field.text.format.none',
            'html' => 'tx_mask.field.text.format.html',
            'typoscript' => 'tx_mask.field.text.format.typoscript',
            'javascript' => 'tx_mask.field.text.format.javascript',
            'css' => 'tx_mask.field.text.format.css',
            'xml' => 'tx_mask.field.text.format.xml',
            'php' => 'tx_mask.field.text.format.php'
        ],
        'documentation' => 'ColumnsConfig/Type/textT3editor.html#format'
    ],
    'config.wrap' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.text.wrap',
        'code' => 'wrap',
        'valueOff' => 'off',
        'valueOn' => 'virtual',
        'documentation' => 'ColumnsConfig/Type/textDefault.html#wrap'
    ],
    'config.fixedFont' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.config.fixedFont',
        'description' => 'tx_mask.config.fixedFont.description',
        'code' => 'fixedFont',
        'documentation' => 'ColumnsConfig/Type/textDefault.html#fixedfont'
    ],
    'config.enableTabulator' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.config.enableTabulator',
        'description' => 'tx_mask.config.enableTabulator.description',
        'code' => 'enableTabulator',
        'documentation' => 'ColumnsConfig/Type/textDefault.html#enabletabulator'
    ],
    'config.richtextConfiguration' => [
        'type' => 'radio',
        'label' => 'tx_mask.config.richtextConfiguration',
        'code' => 'richtextConfiguration',
        'documentation' => 'ColumnsConfig/Type/textDefault.html#richtextconfiguration'
    ],
    'config.items' => [
        'collision' => true,
        'check' => [
            'type' => 'textarea',
            'rows' => 10,
            'label' => 'tx_mask.content.check.items',
            'description' => 'tx_mask.content.check.items.description',
            'placeholder' => 'tx_mask.content.check.items.placeholder',
            'code' => 'items',
            'documentation' => 'ColumnsConfig/Type/checkDefault.html#items'
        ],
        'radio' => [
            'type' => 'textarea',
            'rows' => 10,
            'code' => 'items',
            'label' => 'tx_mask.content.check.items',
            'description' => 'tx_mask.field.radio.items',
            'placeholder' => 'tx_mask.content.radio.items.placeholder',
            'documentation' => 'ColumnsConfig/Type/Radio.html#items'
        ],
        'select' => [
            'type' => 'textarea',
            'rows' => 10,
            'code' => 'items',
            'label' => 'tx_mask.content.check.items',
            'description' => 'tx_mask.field.select.items',
            'placeholder' => 'tx_mask.content.select.items.placeholder',
            'documentation' => 'ColumnsConfig/Type/selectSingle.html#items'
        ]
    ],
    'config.renderType' => [
        'collision' => true,
        'select' => [
            'type' => 'select',
            'label' => 'tx_mask.field.check.renderType',
            'description' => 'tx_mask.field.check.renderType.description',
            'code' => 'renderType',
            'items' => [
                'selectSingle' => 'tx_mask.field.select.renderType.selectSingle',
                'selectSingleBox' => 'tx_mask.field.select.renderType.selectSingleBox',
                'selectCheckBox' => 'tx_mask.field.select.renderType.selectCheckBox',
                'selectMultipleSideBySide' => 'tx_mask.field.select.renderType.selectMultipleSideBySide',
            ],
            'documentation' => 'ColumnsConfig/Type/Select.html'
        ],
        'check' => [
            'type' => 'radio',
            'label' => 'tx_mask.field.check.renderType',
            'description' => 'tx_mask.field.check.renderType.description',
            'code' => 'renderType',
            'items' => [
                '' => 'tx_mask.field.check',
                'checkboxToggle' => 'tx_mask.field.check.renderType.checkboxToggle',
                'checkboxLabeledToggle' => 'tx_mask.field.check.renderType.checkboxLabeledToggle'
            ],
            'documentation' => 'ColumnsConfig/Type/Check.html'
        ]
    ],
    'config.foreign_table' => [
        'type' => 'text',
        'label' => 'tx_mask.field.select.foreign_table',
        'description' => 'tx_mask.field.select.foreign_table.description',
        'code' => 'foreign_table',
        'documentation' => 'ColumnsConfig/Type/selectSingle.html#foreign-table'
    ],
    'config.foreign_table_where' => [
        'type' => 'text',
        'label' => 'tx_mask.field.select.foreign_table_where',
        'description' => 'tx_mask.field.select.foreign_table_where.description',
        'code' => 'foreign_table_where',
        'documentation' => 'ColumnsConfig/Type/selectSingle.html#foreign-table-where'
    ],
    'config.fileFolder' => [
        'type' => 'text',
        'label' => 'tx_mask.field.select.file_folder',
        'description' => 'tx_mask.field.select.file_folder.description',
        'code' => 'fileFolder',
        'documentation' => 'ColumnsConfig/Type/selectSingle.html#filefolder'
    ],
    'config.fileFolder_extList' => [
        'type' => 'text',
        'label' => 'tx_mask.field.select.file_folder_ext_list',
        'description' => 'tx_mask.field.select.file_folder_ext_list.description',
        'code' => 'fileFolder_extList',
        'documentation' => 'ColumnsConfig/Type/selectSingle.html#filefolder-extlist'
    ],
    'config.fileFolder_recursions' => [
        'type' => 'number',
        'min' => 0,
        'max' => 99,
        'label' => 'tx_mask.field.select.file_folder_recursions',
        'description' => 'tx_mask.field.select.file_folder_recursions.description',
        'code' => 'fileFolder_recursions',
        'documentation' => 'ColumnsConfig/Type/selectSingle.html#filefolder-recursions'
    ],
    'config.autoSizeMax' => [
        'type' => 'number',
        'min' => 1,
        'label' => 'tx_mask.field.select.autosizemax',
        'description' => 'tx_mask.field.select.autosizemax.description',
        'code' => 'autoSizeMax',
        'documentation' => 'ColumnsConfig/Type/selectSingleBox.html?#autosizemax'
    ],
    'config.minitems' => [
        'type' => 'number',
        'min' => 1,
        'label' => 'tx_mask.field.select.minitems',
        'description' => 'tx_mask.field.select.minitems.description',
        'code' => 'minitems',
        'documentation' => 'ColumnsConfig/Type/selectSingleBox.html#minitems'
    ],
    'config.maxitems' => [
        'type' => 'number',
        'min' => 1,
        'label' => 'tx_mask.field.select.maxitems',
        'description' => 'tx_mask.field.select.maxitems.description',
        'code' => 'maxitems',
        'documentation' => 'ColumnsConfig/Type/selectSingleBox.html#maxitems'
    ],
    'config.internal_type' => [
        'type' => 'radio',
        'label' => 'tx_mask.field.group.internal_type',
        'description' => 'tx_mask.field.group.internal_type.description',
        'code' => 'internal_type',
        'items' => [
            'db' => 'tx_mask.field.group.internalType.db',
            'folder' => 'tx_mask.field.group.internalType.folder'
        ],
        'documentation' => 'ColumnsConfig/Type/Group.html#internal-type'
    ],
    'config.allowed' => [
        'type' => 'text',
        'label' => 'tx_mask.field.group.allowed',
        'description' => 'tx_mask.field.group.allowed.description',
        'code' => 'allowed',
        'documentation' => 'ColumnsConfig/Type/Group.html#allowed'
    ],
    'config.fieldControl.editPopup.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.editPopup',
        'description' => 'tx_mask.group.editPopup.description',
        'code' => 'editPopup',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldcontrol-editpopup'
    ],
    'config.fieldControl.addRecord.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.addRecord',
        'description' => 'tx_mask.group.addRecord.description',
        'code' => 'addRecord',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldcontrol-addrecord'
    ],
    'config.fieldControl.listModule.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.listModule',
        'description' => 'tx_mask.group.listModule.description',
        'code' => 'listModule',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldcontrol-listmodule'
    ],
    'config.fieldControl.elementBrowser.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.elementBrowser',
        'description' => 'tx_mask.group.elementBrowser.description',
        'code' => 'elementBrowser',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldcontrol-elementbrowser',
    ],
    'config.fieldControl.insertClipboard.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.insertClipboard',
        'description' => 'tx_mask.group.insertClipboard.description',
        'code' => 'insertClipboard',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldcontrol-insertclipboard'
    ],
    'config.fieldControl' => [
        'type' => 'plainText',
        'label' => 'tx_mask.fieldControl',
        'description' => 'tx_mask.fieldControl.description',
        'code' => 'fieldControl',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldcontrol',
    ],
    'config.fieldWizard.recordsOverview.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.recordsOverview',
        'description' => 'tx_mask.group.recordsOverview.description',
        'code' => 'recordsOverview',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldwizard-recordsoverview'
    ],
    'config.fieldWizard.tableList.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.tableList',
        'description' => 'tx_mask.group.tableList.description',
        'code' => 'tableList',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldwizard-tablelist'
    ],
    'config.fieldWizard.selectIcons.disabled' => [
        'type' => 'checkbox',
        'invert' => true,
        'label' => 'tx_mask.group.selectIcons',
        'description' => 'tx_mask.group.selectIcons.description',
        'code' => 'selectIcons',
        'documentation' => 'ColumnsConfig/Type/selectSingle.html#selecticons'
    ],
    'config.fieldWizard' => [
        'type' => 'plainText',
        'label' => 'tx_mask.fieldWizard',
        'description' => 'tx_mask.fieldWizard.description',
        'code' => 'fieldWizard',
        'documentation' => 'ColumnsConfig/Type/Group.html#fieldwizard',
    ],
    'config.multiple' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.group.multiple',
        'description' => 'tx_mask.group.multiple.description',
        'code' => 'multiple',
        'documentation' => 'ColumnsConfig/Type/Group.html#multiple'
    ],
    'config.appearance.collapseAll' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.collapse_all.label',
        'description' => 'tx_mask.field.inline.collapse_all',
        'code' => 'collapseAll',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=collapseall#appearance'
    ],
    'config.appearance.expandSingle' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.expand_single.label',
        'description' => 'tx_mask.field.inline.expand_single',
        'code' => 'expandSingle',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=expandsingle#appearance'
    ],
    'config.appearance.useSortable' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.use_sortable.label',
        'description' => 'tx_mask.field.inline.use_sortable',
        'code' => 'useSortable',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=usesortable#appearance'
    ],
    'config.appearance.fileUploadAllowed' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.file_upload_allowed.label',
        'description' => 'tx_mask.field.inline.file_upload_allowed',
        'code' => 'fileUploadAllowed',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=fileuploadallowed#appearance'
    ],
    'config.appearance.showSynchronizationLink' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.show_synchronization_link',
        'description' => 'tx_mask.field.inline.show_synchronization_link_description',
        'dependsOn' => 'config.appearance.showPossibleLocalizationRecords',
        'code' => 'showSynchronizationLink',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=showsynchronizationlink#appearance'
    ],
    'config.appearance.showPossibleLocalizationRecords' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.show_possible_localization_records',
        'description' => 'tx_mask.field.inline.show_possible_localization_records.description',
        'code' => 'showPossibleLocalizationRecords',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=showpossiblelocalizationrecords#appearance'
    ],
    'config.appearance.showAllLocalizationLink' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.inline.show_all_localization_link',
        'description' => 'tx_mask.field.inline.show_all_localization_link.description',
        'dependsOn' => 'config.appearance.showPossibleLocalizationRecords',
        'code' => 'showAllLocalizationLink',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=showalllocalizationlink#appearance'
    ],
    'config.appearance.newRecordLinkTitle' => [
        'type' => 'text',
        'label' => 'tx_mask.field.inline.new_record_link_title.label',
        'description' => 'tx_mask.field.inline.new_record_link_title',
        'code' => 'newRecordLinkTitle',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=newrecordlinktitle#appearance'
    ],
    'config.appearance.levelLinksPosition' => [
        'type' => 'select',
        'items' => [
            'top' => 'tx_mask.field.inline.level_links_position.top',
            'bottom' => 'tx_mask.field.inline.level_links_position.bottom',
            'both' => 'tx_mask.field.inline.level_links_position.both',
            'none' => 'tx_mask.field.inline.level_links_position.none',
        ],
        'label' => 'tx_mask.field.inline.level_links_position.label',
        'description' => 'tx_mask.field.inline.level_links_position',
        'code' => 'levelLinksPosition',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=levellinksposition#appearance'
    ],
    'ctrl.label' => [
        'type' => 'text',
        'label' => 'tx_mask.all.label',
        'description' => 'tx_mask.field.inline.inline_label',
        'code' => 'label',
        'documentation' => 'Ctrl/Index.html#label'
    ],
    'ctrl.iconfile' => [
        'type' => 'text',
        'label' => 'tx_mask.field.inline.inline_icon.label',
        'description' => 'tx_mask.field.inline.inline_icon',
        'code' => 'iconfile',
        'documentation' => 'Ctrl/Index.html#iconfile'
    ],
    'cTypes' => [
        'type' => 'cTypes',
        'label' => 'tx_mask.allowed_content',
        'description' => 'tx_mask.allowed_content.description',
        'code' => 'cTypes'
    ],
    'allowedFileExtensions' => [
        'type' => 'text',
        'label' => 'tx_mask.field.inline.allowed_file_extensions',
        'description' => 'tx_mask.field.inline.elementBrowserAllowed.description',
        'code' => 'allowedFileExtensions',
        'documentation' => 'ColumnsConfig/Type/Inline.html?highlight=elementbrowserallowed#appearance'
    ],
    'imageoverlayPalette' => [
        'type' => 'checkbox',
        'label' => 'tx_mask.field.imageoverlayPalette',
        'description' => 'tx_mask.field.imageoverlayPalette.description',
        'code' => 'imageoverlayPalette',
        'documentation' => 'ColumnsConfig/Type/Inline.html#file-abstraction-layer'
    ],
    'l10n_mode' => [
        'type' => 'radio',
        'label' => 'tx_mask.field.inline.localization_mode',
        'code' => 'l10n_mode',
        'documentation' => 'Columns/Index.html#l10n-mode',
        'items' => [
            '' => 'tx_mask.field.inline.l10n_mode.default',
            'exclude' => 'tx_mask.field.inline.l10n_mode.exclude',
            'prefixLangTitle' => 'tx_mask.field.inline.l10n_mode.prefixLangTitle'
        ],
    ],
];
