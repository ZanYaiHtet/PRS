<!-- Search Result Table List -->
<table cellpadding="0" cellspacing="0">
    
    <!-- Header Section -->
    <thead>
        <tr>
            <th scope="col"><?= __('No') ?></th>
            <th scope="col"><?= __('Product') ?></th>
            <th scope="col"><?= __('Price') ?></th>
            <th scope="col"><?= __('Status') ?></th>
            <th scope="col"><?= __('Trending') ?></th>
            <th scope="col"><?= __('Action') ?></th>
        </tr>
    </thead>

    <!-- Body Section -->
    <tbody>
        <!-- Pagination Format -->
        <?php $page = $this->Paginator->counter(['format' => __('{{page}}')]);
            $no = 1;
            if ($page > 2) $no = $page * 20 - 19;
            else if ($page == 2) $no = $page * 10 + 1; ?>
        
        <!-- Forech Loop Listing -->
        <?php foreach ($products as $product) : ?>
            <tr>
                <td><?= __($no++) ?></td>
                <td><?= $product['name'] ?></td>
                <td><?= $this->Number->format($product['price']) ?> MMK</td>
                <td><?php 
                    // Status Condition
                    if (($product['rating'] / 5) * 100 > 50) {
                        echo "<i class='material-icons green-text'>arrow_upward</i>";
                    } elseif (($product['rating'] / 5) * 100 < 50) {
                        if (($product['rating'] / 5) * 100 === 0) {
                            echo "<label>no answer</label>";
                        } elseif (($product['rating'] / 5) * 100 === NULL) {
                            echo "<i class='material-icons black-text'>arrow_downward</i>";
                        } else {
                            echo "<i class='material-icons red-text'>arrow_downward</i>";
                        }
                    } ?>
                </td>
                <td><?php 
                    // Progress Bar Condition
                    if ($product['rating'] === NULL || $product['rating'] === ''): ?>
                        <?= 0 / 5 * 100 ?>% <progress value="<?= 0 / 5 * 100 ?>" max="100"></progress>
                    <?php else: ?>
                        <?= $product['rating'] / 5 * 100 ?>% <progress value="<?= $product['rating'] / 5 * 100 ?>" max="100"></progress>
                    <?php endif; ?>
                </td>
                <td>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $product['id'], '1']) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <!-- End Foreach Loop Listing -->
    </tbody>
</table>

<!-- Paginator Section -->
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