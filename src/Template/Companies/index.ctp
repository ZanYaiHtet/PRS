<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company[]|\Cake\Collection\CollectionInterface $companies
 */
?>

<div class="companies index large-9 medium-8 columns content">
    <h3><?= __('Companies') ?></h3>
    <?= $this->Html->link(__('New Company'), ['action' => 'add'], ['class' => 'waves-effect waves-light btn right indigo']) ?>

    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                <!-- <th scope="col"><?= $this->Paginator->sort('website') ?></th> -->
                <th scope="col" width="30%"><?= $this->Paginator->sort('address') ?></th>
                <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
                <th scope="col" width="10%"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col" class="actions" width="15%"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $var = 1; ?>
            <?php foreach ($companies as $company) : ?>
                <tr>
                    <td><?= $this->Number->format($var++) ?></td>
                    <td><?= h($company->name) ?></td>
                    <!-- <td><?= h($company->website) ?></td> -->
                    <td><?= h($company->address) ?></td>
                    <td><?= h($company->phone) ?></td>
                    <td><?= date('Y-m-d', strtotime(h($company->created))); ?></td>

                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $company->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $company->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $company->id], ['confirm' => __('Are you sure to delete # {0}?', $company->name)]) ?>
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