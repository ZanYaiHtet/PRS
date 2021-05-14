<table>
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col"><?= $this->Paginator->sort('name') ?></th>
            <th scope="col"><?= $this->Paginator->sort('email') ?></th>
            <th scope="col"><?= $this->Paginator->sort('gender') ?></th>
            <th scope="col"><?= $this->Paginator->sort('phone') ?></th>
            <th scope="col"><?= $this->Paginator->sort('Date of Birth') ?></th>
            <th scope="col"><?= $this->Paginator->sort('type') ?></th>
            <!-- <th scope="col"><?= $this->Paginator->sort('reward') ?></th> -->
            <th scope="col" class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>

        <?php $no = 1;
        foreach ($users as $user) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= h($user->name) ?></td>
                <td><?= h($user->email) ?></td>
                <td class="capitalize"> <?= h($user->gender) ?></td>
                <td><?= h($user->phone) ?></td>
                <td><?= h($user->birthdate->i18nFormat('YYY-MM-dd')) ?></td>
                <td class="capitalize"><?= h($user->premium_flg) ?></td>
                <!-- <td class="capitalize"><?= h($user->scores ? $user->scores[0]->score : 'Empty') ?></td> -->

                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
