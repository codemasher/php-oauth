<?php
/**
 * @filesource   cli_functions.php
 * @created      01.08.2019
 * @author       smiley <smiley@chillerlan.net>
 * @copyright    2019 smiley
 * @license      MIT
 */

namespace chillerlan\OAuthCLI;

use chillerlan\Database\Database;

function createDB(Database $db, string $tableProviders, string $tableTokens){
	$db->connect();

	$db->drop->table($tableProviders)->ifExists()->query();

	$db->create
		->table($tableProviders)
		->ifNotExists()
		->primaryKey('provider_id')
		->field('provider_id', 'VARCHAR', 8, null, 'ascii_general_ci')
		->varchar('name', 30, null, false)
		->tinytext('class', null, false)
		->query();

	$providers = \chillerlan\OAuth\Providers\getProviders();

	$db->insert
		->into($tableProviders, 'IGNORE')
		->values([['provider_id' => '?', 'name' => '?', 'class' => '?']])
		->callback($providers, function(array $val, string $id):array{
			return [$id, $val['name'], $val['fqcn']];
		});

	$db->drop->table($tableTokens)->ifExists()->query();

	$db->create
		->table($tableTokens)
		->ifNotExists()
		->primaryKey('label')
		->varchar('label', 40, null, false)
		->int('user_id', 10, null, false)
		->field('provider_id', 'VARCHAR', 8, null, 'ascii_general_ci')
		->text('token', null, true)
		->text('state')
		->tinyint('refreshable', 1, 0, false)
		->int('expires', 10, -9001, false)
		->query();

}


