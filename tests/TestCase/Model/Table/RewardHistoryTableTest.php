<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RewardhistoryTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RewardhistoryTable Test Case
 */
class RewardhistoryTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RewardhistoryTable
     */
    public $Rewardhistory;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rewardhistory',
        'app.users',
        'app.admins',
        'app.companies',
        'app.options',
        'app.products',
        'app.categories',
        'app.answers',
        'app.surveys',
        'app.questions',
        'app.scores',
        'app.prizes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Rewardhistory') ? [] : ['className' => RewardhistoryTable::class];
        $this->Rewardhistory = TableRegistry::get('Rewardhistory', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rewardhistory);

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
