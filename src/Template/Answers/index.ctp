<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Survey[]|\Cake\Collection\CollectionInterface $surveys
 */
?>
<div class="surveys index large-9 medium-8 columns content">
    <h3><?= __('Surveys History') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <th scope="col" width="50%"><?= $this->Paginator->sort('description') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('category_id') ?></th> -->
                <th scope="col" width="15%"><?= $this->Paginator->sort('answered date') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $page = $this->Paginator->counter(['format' => __('{{page}}')]);
            $no = 1;
            if ($page > 2)
                $no = $page * 20 - 19;
            else if ($page == 2)
                $no = $page * 10 + 1; ?>
            <?php foreach ($answers as $answer) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= h($answer->survey->name) ?></td>
                    <td><?= h($answer->survey->description) ?></td>
                    <td><?= h($answer->created->i18nFormat('yyyy-MM-dd')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $answer->survey->id]) ?>
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