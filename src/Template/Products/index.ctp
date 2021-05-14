<!-- Search Button Style -->
<style>
    .Flatsearch {
        align-items: center;
        border-radius: 5px;
        border: 0px solid #ccc;
        display: flex;
        justify-content: space-between;
        width:300px;
        margin: 1px 0;
        padding: 0px;
        color: #000;
        transition: all 0.5s ease 0s;
    }
    .Flatsearch button,
    .Flatsearch input {
      -webkit-appearance: none;
        -moz-appearance: none;
              appearance: none;
      background: transparent;
      border: 0;
      color: inherit;
      font: inherit;
      outline: 0;
    }
    i.small.material-icons.prefix {
        margin-left: -2rem;
        color: gray;
        
    }
    #search {
        padding-right: 1.8rem;
    }
    #button {
        margin-right: 2rem;
    }
</style>

<!-- Product List Page -->
<div class="products index large-9 medium-8 columns content">
    
    <!-- Header -->
    <h4><?= __('Product List') ?></h4>
    
    <!-- Upper Section -->
    <div class="row">

        <!-- Search Button -->
        <div class="col s4 Flatsearch">
            <?= $this->Form->text('search', ['id' => 'search', 'size' => '100', 'maxlength' => '100', 'placeholder' => 'Search...']) ?>
            <?= $this->Form->button('<i class="small material-icons prefix">search</i>', ['type' => 'button' ,'id' => 'button']); ?>      
        </div>
        
        <!-- Empty Spacing -->
        <div class="col s5"></div>
        
        <!-- New Product Button -->
        <div class="col s3">            
            <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'user-hide waves-effect waves-light btn right indigo']) ?>
        </div>

    </div>
    <!-- End Upper Section -->

    <!-- Table Section -->
    <div class="table-content">
        <!-- Search Result Table List -->
        <table cellpadding="0" cellspacing="0">
            
            <!-- Header Section -->
            <thead>
                <tr>
                    <th scope="col"><?= __('No') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Product') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Price') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('Status') ?></th>                    
                    <th scope="col"><?= $this->Paginator->sort('Trending') ?></th>
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
                        <td><?= $this->Number->format($product['price'])?> MMK</td>
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
                            <?= $this->Html->link(__('View'), ['action' => 'view', $product['id'], $purl]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product['id']], ['class' => 'user-hide']) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product['id']], ['confirm' => __('Are you sure you want to delete '.$product['name'].'?', $product['id']), ['class' => 'user-hide']]) ?>
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
    </div>
    <!-- End Table Section -->
</div>

<!-- Search Function Script -->
<script>
  $('document').ready(function() {

    // User Authorize Hide Function
    var purl = "<?php echo $purl ?>";
    if (purl == "1") {
        $('.user-hide').hide();
    }
    
    $('#search').keyup(function() {
        if (!$(this).val() || $(this).val().trim() == '') {
            location.reload();
        } else {
            var searchkey = $(this).val();
            searchProducts(searchkey);
        }
    });

    // Controller Query Link with Ajax
    function searchProducts(keyword) {
      var data = keyword;
      $.ajax({
        method: 'get',
        url: "<?php 
        if ($purl === '1') 
        echo $this->Url->build(['controller' => 'Products', 'action' => 'Searchuser']); 
        else 
        echo $this->Url->build(['controller' => 'Products', 'action' => 'Search']); 
        ?>",
        data: {
          keyword: data
        },

        // Show Result List
        success: function(response) {
          $('.table-content').html(response);
        }
      });
    };
  });
</script>