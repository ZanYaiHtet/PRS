<?php

?>
<div class="surveys index large-9 medium-8 columns content">
    <h3><?= __('Prize List') ?></h3>

    <?= $this->Html->link("New Prize", array('controller' => 'Prizes', 'action' => 'prizeadd'), array('class' => 'btn indigo right')) ?>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= __('No') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Scores') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Prize Name') ?></th>
                <th scope="col"><?= $this->Paginator->sort('Created') ?></th>
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
            <?php foreach ($prizes as $key => $prize) :  ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= h($prize->scores) ?></td>
                    <td><?= h($prize->prize_name) ?></td>
                    <td><?= date('Y-m-d', strtotime(h($prize->created))); ?></td>


                    <td class="actions">


                        <a href="<?= $this->Url->build(['controller' => 'Prizes', 'action' => 'edit', $prize->id]); ?>" title="Update Record">Edit</a>
                        <span title="Delete Record" class="link"><?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $prize->id], ['confirm' => __('Are you sure you want to delete # {0}?', $prize->id)]) ?> </span>


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