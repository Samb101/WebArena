<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SurroundingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SurroundingsTable Test Case
 */
class SurroundingsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SurroundingsTable
     */
    public $Surroundings;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.surroundings'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Surroundings') ? [] : ['className' => 'App\Model\Table\SurroundingsTable'];
        $this->Surroundings = TableRegistry::get('Surroundings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Surroundings);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
