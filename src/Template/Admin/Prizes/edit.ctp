<!DOCTYPE html>
<html>

<head>
  <title>Update Prize</title>
  <style type="text/css">
    .card {
      margin-top: 5rem;

    }

    .my-row {
      margin-bottom: 0.4rem;
    }
  </style>

</head>

<body>
  <div class="container">
    <!--Form without header-->
    <div class="card">

      <div class="card-content">
        <?= $this->Form->create($prize) ?>
        <span class="card-title center">Update Prize</span>
        <div class="input-field col s6">
          <!-- <input type="text" placeholder="Prize Name" name="prize_name" required /> -->
          <?php
          echo $this->Form->control('prize_name', array(['required'], 'label' => '', 'class' => 'validate', 'type' => 'text', 'placeholder' => 'Prize Name'));
          ?>
        </div>

        <div class="input-field col s6">
          <?php
          echo $this->Form->control('scores', array(['required'], 'label' => '', 'class' => 'validate', 'type' => 'number', 'placeholder' => 'Scores'));
          ?>
        </div>
      </div>
      <div class="card-action">
        <div class="row my-row">
          <div class="col s4"></div>
          <div class="col s2">
            <?= $this->Form->button(__('Update'), array('class' => 'btn indigo')) ?>
          </div>
          <div class="col s3">
            <?= $this->Html->link(__('Cancel'), array('controller' => 'Prizes', 'action' => 'prizelist'), array('class' => 'btn indigo')) ?>

          </div>
          <div class="col s2"></div>
        </div>
      </div>




      <?= $this->Form->end() ?>

    </div>




  </div>
  <!--/Form without header-->



  </div>

</body>

</html>