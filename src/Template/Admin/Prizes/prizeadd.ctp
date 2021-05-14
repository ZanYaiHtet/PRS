<!DOCTYPE html>
<html>

<head>
  <title>Add Prize</title>
  <style>
    .card {
      margin-top: 5rem;

    }

    .my-row {
      margin-bottom: 0.4rem;
    }
  </style>
</head>

<body>
  <!-- Grid column -->
  <div class="container">

    <!--Form without header-->
    <div class="card">

      <div class="card-content">
        <?= $this->Form->create($prize) ?>

        <!--Header-->
        <span class="card-title center">Add Prize</span>
        <div class="input-field col s6">
          <input placeholder="Prize Name" name="prize_name" type="text" class="validate" required>
        </div>
        <div class="input-field col s6">
          <input placeholder="Scores" name="scores" type="number" class="validate" required>
        </div>
      </div>
      <div class="card-action">
        <div class="row my-row">
          <div class="col s4"></div>
          <div class="col s2">
            <button type="submit" class="waves-effect waves-light btn indigo center">Save</button>
          </div>
          <div class="col s3">
            <?= $this->Html->link(
              __('Cancel'),
              ['action' => 'prizelist'],
              [
                'class' => 'waves-effect waves-light btn center indigo',
              ]
            ) ?>
          </div>
          <div class="col s2"></div>
        </div>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</body>

</html>