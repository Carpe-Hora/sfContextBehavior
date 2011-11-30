<?php
/*
 *	$Id: VersionableBehaviorTest.php 1460 2010-01-17 22:36:48Z francois $
 * This file is part of the Propel package.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @license    MIT License
 */

$_SERVER['PROPEL_DIR'] = dirname(__FILE__) . '/../../../../plugins/sfPropelORMPlugin/lib/vendor/propel/';
$propel_dir = isset($_SERVER['PROPEL_DIR']) ? $_SERVER['PROPEL_DIR'] : dirname(__FILE__) . '/../../../../../plugins/sfPropelORMPlugin/lib/vendor/propel/';
$behavior_dir = file_exists(__DIR__ . '/../src/')
                    ? __DIR__ . '/../src'
                    : $propel_dir . '/generator/lib/behavior/sf_context';

require_once $propel_dir . '/runtime/lib/Propel.php';
require_once $propel_dir . '/generator/lib/util/PropelQuickBuilder.php';
require_once $propel_dir . '/generator/lib/util/PropelPHPParser.php';
require_once $behavior_dir . '/sfContextBehavior.php';

/**
 * Test for sfContextBehavior
 *
 * @author     Julien Muetton
 * @version    $Revision$
 * @package    generator.behavior.sf_context
 */
class sfContextBehaviorTest extends PHPUnit_Framework_TestCase
{
	public function setUp()
	{
  	if (!class_exists('sfContextBehaviorTest1')) {
      $schema = <<<EOF
<database name="sf_context_behavior_test_1">
  <table name="sf_context_behavior_test_1">
    <column name="id" type="INTEGER" primaryKey="true" autoincrement="true" />
    <column name="name" type="VARCHAR" size="255" />
    <behavior name="sf_context" />
  </table>
</database>
EOF;
			PropelQuickBuilder::buildSchema($schema);
    }
  	if (!class_exists('sfContextBehaviorTest2')) {
      $schema = <<<EOF
<database name="sf_context_behavior_test_2">
  <behavior name="sf_context" />
  <table name="sf_context_behavior_test_2">
    <column name="id" type="INTEGER" primaryKey="true" autoincrement="true" />
    <column name="name" type="VARCHAR" size="255" />
  </table>
  <table name="sf_context_behavior_test_3">
    <column name="id" type="INTEGER" primaryKey="true" autoincrement="true" />
    <column name="name" type="VARCHAR" size="255" />
  </table>
</database>
EOF;
			PropelQuickBuilder::buildSchema($schema);
    }
  }

  public function testApplyOnAllTables()
  {
    $this->assertTrue(method_exists('sfContextBehaviorTest1', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest2', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest3', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest1Peer', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest2Peer', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest3Peer', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest1Query', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest2Query', 'getApplicationContext'));
    $this->assertTrue(method_exists('sfContextBehaviorTest3Query', 'getApplicationContext'));
  }
}

