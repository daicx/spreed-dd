<?php

declare(strict_types=1);
/**
 * @copyright Copyright (c) 2021, Gary Kim <gary@garykim.dev>
 *
 * @author Gary Kim <gary@garykim.dev>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

namespace OCA\Talk\Migration;

use Closure;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\DBAL\Types\Types;
use OCP\DB\ISchemaWrapper;
use OCP\Migration\IOutput;
use OCP\Migration\SimpleMigrationStep;


class Version12000Date20210610232111 extends SimpleMigrationStep {
	/**
	 * @param IOutput $output
	 * @param Closure $schemaClosure The `\Closure` returns a `ISchemaWrapper`
	 * @param array $options
	 * @return null|ISchemaWrapper
	 * @throws SchemaException
	 */
	public function changeSchema(IOutput $output, Closure $schemaClosure, array $options): ?ISchemaWrapper {
		/** @var ISchemaWrapper $schema */
		$schema = $schemaClosure();

		if ($schema->hasTable('talk_attendees')) {
			$table = $schema->getTable('talk_attendees');
			if ($table->hasColumn('access_token')) {
				$table->addColumn('access_token', Types::STRING, [
					'notnull' => true,
					'default' => ''
				]);
			}

			if ($table->hasColumn('joined')) {
				$table->addColumn('joined', Types::BOOLEAN, [
					'notnull' => true,
					'default' => false,
				]);
			}
		}

		if ($schema->hasTable('talk_rooms')) {
			$table = $schema->getTable('talk_rooms');
			if ($table->hasColumn('server_url')) {
				$table->addColumn('server_url', Types::STRING, [
					'notnull' => true,
					'default' => '',
				]);
			}
		}

		return $schema;
	}
}