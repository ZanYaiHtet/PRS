<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Event\Event;

/**
 * Surveys Controller
 *
 * @property \App\Model\Table\SurveysTable $Surveys
 *
 * @method \App\Model\Entity\Survey[] paginate($object = null, array $settings = [])
 */
class SurveysController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Products', 'Categories', 'Admins']
        ];
        $surveys = $this->paginate($this->Surveys->find('all')->where(['Surveys.del_flg' => 'not']));
        $this->set(compact('surveys'));
        $this->set('_serialize', ['surveys']);
    }

    /**
     * View method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $surveyID = $id;
        $this->loadModel('Surveys');
        $this->loadModel('Questions');
        $this->loadModel('Options');
        if ($this->request->is('post')) {
            return $this->redirect(['action' => 'index']);
        }
        $survey = $this->Surveys->find()->select(['id', 'title' => 'name', 'description', 'category_id', 'product_id'])->where(['id' => $surveyID, 'del_flg' => 'not'])->toArray();

        $questions = $this->Questions->find()->select(['id', 'type', 'description'])->where(['survey_id' => $surveyID, 'del_flg' => 'not']);

        $options = $this->Options->find()->select(['id', 'question_id', 'description'])->where(['survey_id' => $surveyID, 'del_flg' => 'not']);

        $this->set(compact('survey', 'questions', 'options'));
        // $this->set('_serialize', ['answer']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Questions');
        $this->loadModel('Options');
        $this->loadModel('Products');
        $this->loadModel('Categories');

        $survey = $this->Surveys->newEntity();
        $question = $this->Questions->newEntity();
        $Option = $this->Options->newEntity();

        // time zone
        $currDateTime = Time::now();
        $currDateTime->timezone = 'Asia/Yangon';

        if ($this->request->is('post')) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());

            $totalCard = $this->request->getData('card_array');
            $admin_id = $this->Auth->user('id');
            $survey->admin_id = $admin_id;
            $survey->del_flg = 'not';
            $survey->created = $currDateTime;
            $survey->modified = $currDateTime;

            $cards = json_decode($totalCard, true);

            // return debug($cards);

            if ($SResult = $this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                // save question
                if (!empty($cards)) {
                    foreach ($cards as $card) {
                        $question->type = $card['type'];
                        $question->description = $card['question'];
                        $question->survey_id = $SResult->id;
                        $question->admin_id = $admin_id;
                        $question->created = $currDateTime;
                        $question->modified = $currDateTime;

                        if ($QResult = $this->Questions->save($question)) {
                            // $this->Flash->success(__('The question has been saved.'));

                            // save option
                            $options = $card['options'];
                            if (!empty($options)) {
                                foreach ($options as $optionL) {
                                    $Option->description = $optionL;
                                    $Option->survey_id = $SResult->id;
                                    $Option->question_id = $QResult->id;
                                    $Option->admin_id = $admin_id;
                                    $Option->created = $currDateTime;
                                    $Option->modified = $currDateTime;

                                    if ($this->Options->save($Option)) {
                                        // $this->Flash->success(__('The options have been saved.'));
                                    } else {
                                        $this->Flash->error(__('The options could not be saved. Please, try again.'));
                                    }
                                    $Option = $this->Options->newEntity();
                                }
                            }
                            $question = $this->Questions->newEntity();
                        } else {
                            $this->Flash->error(__('The question could not be saved. Please, try again.'));
                        }
                    }
                }
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }

        $products = $this->Surveys->Products->find('list', ['limit' => 200])->where(['del_flg' => 'not']);
        $categories = $this->Surveys->Categories->find('list', ['limit' => 200])->where(['del_flg' => 'not']);
        $admins = $this->Surveys->Admins->find('list', ['limit' => 200])->where(['del_flg' => 'not']);

        $my_products = $this->Products->find('all')->where(['del_flg' => 'not']);
        $my_categories = $this->Categories->find('all')->where(['del_flg' => 'not']);

        $this->set(compact('survey', 'products', 'categories', 'admins', 'my_products', 'my_categories'));
        $this->set('_serialize', ['survey']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    /*     public function edit($id = null)
    {
        $survey = $this->Surveys->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $survey = $this->Surveys->patchEntity($survey, $this->request->getData());
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The survey could not be saved. Please, try again.'));
        }
        $products = $this->Surveys->Products->find('list', ['limit' => 200]);
        $categories = $this->Surveys->Categories->find('list', ['limit' => 200]);
        $admins = $this->Surveys->Admins->find('list', ['limit' => 200]);
        $this->set(compact('survey', 'products', 'categories', 'admins'));
        $this->set('_serialize', ['survey']);
    } */

    /**
     * Delete method
     *
     * @param string|null $id Survey id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $survey = $this->Surveys->get($id);

        // answered? don't delete
        $query = $this->Surveys->Answers->find('all')->where(['survey_id' => $id])->select('id');
        $data = $query->toArray();
        $survey_id = implode(' ', $data);

        if (!empty($survey_id))
            $this->Flash->error(__('This survey is being answered, so that could not be deleted.'));
        else {
            $survey->del_flg = 'deleted';
            if ($this->Surveys->save($survey)) {
                $this->Flash->success(__('The survey has been deleted.'));
            } else {
                $this->Flash->error(__('The survey could not be deleted. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'index']);
    }

    public function publish($id = null)
    {
        // $this->request->allowMethod(['patch', 'post', 'put']);
        $survey = $this->Surveys->get($id);
        $survey->public = 'Y';
        if ($this->Surveys->save($survey)) {
            $this->Flash->success(__('The survey has been published.'));
        } else {
            $this->Flash->error(__('The survey could not be publish. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function search()
    {
        $this->request->allowMethod('ajax');

        $keyword = $this->request->getQuery('keyword');

        $this->paginate = [
            'contain' => ['Products', 'Categories', 'Admins']
        ];

        $surveys = $this->paginate($this->Surveys->find('all')
            ->where(
                [
                    ['OR' => [
                        ['Surveys.name LIKE' => '%' . $keyword . '%'],
                        ['Surveys.description LIKE' => '%' . $keyword . '%']
                    ]],
                    ['AND' => ['Surveys.del_flg' => 'not']]
                ]
            )
            ->order(['Surveys.name' => 'ASC'])
            ->limit(20));

        $this->set(compact('surveys'));
        $this->set('_serialize', ['surveys']);
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        if ($this->Auth->user())
            $this->Auth->allow(['publish', 'delete', 'add', 'index', 'view', 'search']);
    }
}
