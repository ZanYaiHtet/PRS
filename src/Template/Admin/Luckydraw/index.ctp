<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Luckydraw[]|\Cake\Collection\CollectionInterface $luckydraw
 */

//Cutom CSS and JS Files
// echo $this->Html->css('luckydraw_index');

?>
<h3><?= __('Scores') ?></h3>
<div class="row">
  <?= $this->Html->link(__('New Score'),  array('controller' => 'Luckydraw', 'action' => 'add'), ['id'=>'btnNew','class' => 'waves-effect waves-light btn right indigo']) ?>
</div>
<div class="table-content">
  <table cellpadding="0" cellspacing="0">
    <thead>
      <tr>
        <th scope="col">No</th>
        <th scope="col"><?= $this->Paginator->sort('scores') ?></th>
        <th scope="col"><?= $this->Paginator->sort('color') ?></th>
        <th scope="col" width="15%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $page = $this->Paginator->counter(['format' => __('{{page}}')]);
      $no = 1;
      if ($page > 2)
        $no = $page * 20 - 19;
      else if ($page == 2)
        $no = $page * 10 + 1;
      ?>
      <?php foreach ($luckydraw as $luckydraw) : ?>
        <tr>
          <td><?= $this->Number->format($no++) ?></td>
          <td><?= h($luckydraw->scores) ?></td>
          <td>
            <div style="background-color:<?= h($luckydraw->color) ?> ; width:60px;height:20px;"></div>
          </td>
          <td>
            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $luckydraw->id]) ?>
            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $luckydraw->id], ['confirm' => __('Are you sure you want to delete # {0}?', $luckydraw->id)]) ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
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

<style>
  table {
    width: 80%;
    margin-left: 7rem;
  }
  h3 {
    margin-top: 2rem;
    margin-left: 6rem;
  }
  #btnNew{
    margin-right: 6rem;
    margin-bottom: -1rem;
  }
</style>