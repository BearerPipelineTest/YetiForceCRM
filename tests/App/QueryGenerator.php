<?php
/**
 * QueryGenerator test file.
 *
 * @package   Tests
 *
 * @copyright YetiForce Sp. z o.o
 * @license   YetiForce Public License 4.0 (licenses/LicenseEN.txt or yetiforce.com)
 * @author    Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */

namespace Tests\App;

/**
 * QueryGenerator test class.
 */
class QueryGenerator extends \Tests\Base
{
	/**
	 * Advanced conditions test.
	 */
	public function testAdvancedConditions()
	{
		$moduleName = 'Accounts';
		$accountModel = \Tests\Base\C_RecordActions::createAccountRecord();
		$contactId = \Tests\Base\C_RecordActions::createContactRecord()->getId();
		$queryGenerator = new \App\QueryGenerator($moduleName);
		$queryGenerator->initForDefaultCustomView();
		$queryGenerator->setAdvancedConditions(['relationId' => '0', 'relationColumns' => ['1']]);
		$searchParams = \App\Condition::validSearchParams($moduleName, [[['relationColumn_1', 'a', $contactId]]]);
		$transformedSearchParams = $queryGenerator->parseBaseSearchParamsToCondition($searchParams);
		$this->assertEquals([
			'and' => [
				[
					'field_name' => 'relationColumn_1',
					'module_name' => false,
					'source_field_name' => false,
					'comparator' => 'a',
					'value' => $contactId,
				],
			],
		], $transformedSearchParams);
		$queryGenerator->parseAdvFilter($transformedSearchParams);
		$row = $queryGenerator->createQuery()->one() ?? [];
		$this->assertEquals($accountModel->get('accountname'), $row['accountname']);

		$relationId = 9;
		$documentModel = \Tests\Base\C_RecordActions::createDocumentsRecord();
		\Vtiger_Relation_Model::getInstanceById($relationId)->addRelation($row['id'], $documentModel->getId());

		$queryGenerator = new \App\QueryGenerator($moduleName);
		$queryGenerator->initForDefaultCustomView();
		$queryGenerator->setAdvancedConditions(['relationId' => '0', 'relationColumns' => [$relationId]]);
		$searchParams = \App\Condition::validSearchParams($moduleName, [[['relationColumn_' . $relationId, 'a', $documentModel->getId()]]]);
		$transformedSearchParams = $queryGenerator->parseBaseSearchParamsToCondition($searchParams);
		$this->assertEquals([
			'and' => [
				[
					'field_name' => 'relationColumn_' . $relationId,
					'module_name' => false,
					'source_field_name' => false,
					'comparator' => 'a',
					'value' => $documentModel->getId(),
				],
			],
		], $transformedSearchParams);
		$queryGenerator->parseAdvFilter($transformedSearchParams);
		$row = $queryGenerator->createQuery()->one() ?? [];
		$this->assertEquals($accountModel->get('accountname'), $row['accountname']);

		$queryGenerator = new \App\QueryGenerator($moduleName);
		$queryGenerator->initForDefaultCustomView();
		$queryGenerator->setAdvancedConditions([
			'relationId' => $relationId,
			'relationConditions' => ['condition' => 'AND', 'rules' => [['fieldname' => 'notes_title:Documents', 'operator' => 'e', 'value' => $documentModel->get('notes_title')]]],
		]);
		$row = $queryGenerator->createQuery()->one() ?? [];
		$this->assertEquals($accountModel->get('accountname'), $row['accountname']);
	}
}
