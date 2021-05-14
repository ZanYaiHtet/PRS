<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Rewardhistory Controller
 *
 * @property \App\Model\Table\RewardhistoryTable $Rewardhistory
 *
 * @method \App\Model\Entity\Rewardhistory[] paginate($object = null, array $settings = [])
 */
class RewardhistoryController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users', 'Prizes']
        ];
        $Rewardhistory = $this->Rewardhistory->find('all')->where(['user_id' => $this->Auth->user('id'), 'Rewardhistory.del_flg' => 'not']);


        $rewardhistory = $this->paginate($Rewardhistory);

        $this->set(compact('rewardhistory'));
        $this->set('_serialize', ['rewardhistory']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Rewardhistory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $reward_tbl = $this->loadModel('Rewardhistory');
        $reward_result = $this->Rewardhistory->find()->where(['id' => $id])->first();
        $reward_result->del_flg = 'deleted';
        if ($reward_tbl->save($reward_result)) {
            $this->Flash->success(__('The reward has been deleted.'));
        } else {
            $this->Flash->error(__('The reward could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
