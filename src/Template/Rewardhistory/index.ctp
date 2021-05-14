<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rewardhistory[]|\Cake\Collection\CollectionInterface $rewardhistory
 */
?>
<div class="rewardhistory index large-9 medium-8 columns content">
    <h3><?= __('Reward History') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col" class="actions"><?= __('No') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Prize Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Scores') ?></th>
                <th scope="col" width="20%"><?= $this->Paginator->sort('Taken Date') ?></th>
                <th scope="col" class="actions" width="10%"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;
            foreach ($rewardhistory as $rewardhistory) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $rewardhistory->prize->prize_name  ?></td>
                    <td><?= $rewardhistory->prize->scores  ?></td>
                    <td><?= date('Y-m-d', strtotime(h($rewardhistory->created))); ?></td>
                    <td class="actions">
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rewardhistory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rewardhistory->id)]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>