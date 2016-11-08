<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FightersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FightersTable Test Case
 */
class FightersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FightersTable
     */
    public $Fighters;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fighters',
        'app.players',
        'app.guilds',
        'app.messages',
        'app.tools'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Fighters') ? [] : ['className' => 'App\Model\Table\FightersTable'];
        $this->Fighters = TableRegistry::get('Fighters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fighters);

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

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
