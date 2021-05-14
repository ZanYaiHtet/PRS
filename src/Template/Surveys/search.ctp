<table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Name</th>
            <th scope="col" width="40%">Description</th>
            <th scope="col">Product</th>
            <th scope="col">Category</th>
            <th scope="col">Admin</th>
            <!-- <th scope="col" width="10%">Created</th> -->
            <th scope="col" class="actions" width="10%"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php $page = $this->Paginator->counter(['format' => __('{{page}}')]);
        $no = 1;
        if ($page > 2)
            $no = $page * 20 - 19;
        else if ($page == 2)
            $no = $page * 10 + 1; ?>
        <?php foreach ($surveys as $survey) : ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= h($survey->name) ?></td>
                <td><?= h($survey->description) ?></td>
                <td><?= $survey->has('product') ? h($survey->product->name) : '' ?></td>
                <td><?= $survey->has('category') ? h($survey->category->name) : '' ?></td>
                <td><?= $survey->has('admin') ? h($survey->admin->email) : '' ?></td>
                <!-- <td><?= h($survey->created->i18nFormat('yyyy-MM-dd')) ?></td> -->
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $survey->id]) ?>
                    <!-- <?= $this->Html->link(__('Edit'), ['action' => 'edit', $survey->id]) ?> -->
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $survey->id], ['confirm' => __('Are you sure you want to delete "{0}"?', $survey->name)]) ?>
                    <?= ($survey->public == 'N') ? $this->Html->link(__('Publish'), ['action' => 'publish', $survey->id]) : '<i>Published</i>' ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>