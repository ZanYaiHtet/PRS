<?php

/**
 * @var \App\View\AppView $this
 */

//Cutom CSS and JS Files
//
echo $this->Html->css('materialize');
echo $this->Html->css('materialize.min');
echo $this->Html->css('luckydrawAdd');

echo $this->Html->script('jquery-3.5.1');
echo $this->Html->script('jquery-3.5.1.min');
echo $this->Html->script('materialize');
echo $this->Html->script('materialize.min');
?>
<center>
  <legend>New Score For Lucky Draw</legend>
  <div id="addLuckydrawBorder">
    <?= $this->Form->create($luckydraw) ?>
    <div class="row">
      <div class="col s6" id="label_scores">Scores</div>
      <div class="col s6"><?php echo $this->Form->control('scores', array('label' => false)); ?> </div>
    </div>
    <div class="row" id="color_row">
      <div class="col s6" id="label">Color</div>
      <div class="col s1"><?php echo $this->Form->control('color', array('label' => false, 'type' => 'color')); ?> </div>
    </div>
    <div class="row">
      <div class="col s6"><?= $this->Form->button(__('Save'), ['action' => 'add', 'id' => 'btnSave']) ?></div>
      <div class="col s3"><?= $this->Html->link("Cancel", array('controller' => 'Luckydraw', 'action' => 'index'), array('class' => 'button', 'id' => 'btnCancel')) ?></div>
      <?= $this->Form->end() ?>
    </div>

  </div>
</center>