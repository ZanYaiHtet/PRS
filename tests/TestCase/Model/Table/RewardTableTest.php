<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RewardTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RewardTable Test Case
 */
class RewardTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RewardTable
     */
    public $Reward;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.reward',
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
        $config = TableRegistry::exists('Reward') ? [] : ['className' => RewardTable::class];
        $this->Reward = TableRegistry::get('Reward', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Reward);

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
