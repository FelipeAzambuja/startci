<?php

/**
 * Database language strings.
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014-2019 British Columbia Institute of Technology
 * Copyright (c) 2019-2020 CodeIgniter Foundation
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package    CodeIgniter
 * @author     CodeIgniter Dev Team
 * @copyright  2019-2020 CodeIgniter Foundation
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://codeigniter.com
 * @since      Version 4.0.0
 * @filesource
 *
 * @codeCoverageIgnore
 */
return [
	'invalidEvent'         => '{0} nie jest prawidłowym wywołaniem wywołania modelu.',
	'invalidArgument'      => 'Musisz podać poprawną {0}.',
	'invalidAllowedFields' => 'Dozwolone pola muszą być określone dla modelu: {0}',
	'emptyDataset'         => 'Brak danych do {0}.',
	'failGetFieldData'                 => 'Failed to get field data from database.',
	'failGetIndexData'                 => 'Failed to get index data from database.',
	'failGetForeignKeyData'            => 'Failed to get foreign key data from database.',
	'parseStringFail'                  => 'Parsing key string failed.',
	'featureUnavailable'               => 'This feature is not available for the database you are using.',
	'tableNotFound'                    => 'Table `{0}` was not found in the current database.',
	'noPrimaryKey'                     => '`{0}` model class does not specify a Primary Key.',
	'noDateFormat'                     => '`{0}` model class does not have a valid dateFormat.',
	'fieldNotExists'                   => 'Field `{0}` not found.',
	'forEmptyInputGiven'               => 'Empty statement is given for the field `{0}`',
	'forFindColumnHaveMultipleColumns' => 'Only single column allowed in Column name.',
];
