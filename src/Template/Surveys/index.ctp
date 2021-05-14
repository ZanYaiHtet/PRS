<div class="surveys index large-9 medium-8 columns content">
    <div class="row">
        <div class="col s8">
            <h3><?= __('Surveys') ?></h3>
        </div>
        <div class="input-field col s4">
            <i class="material-icons prefix">search</i>
            <input id="search" name="search" type="text" class="validate" placeholder="Search...">
            <!-- <label for="search">Search</label> -->
        </div>
    </div>
    <a id="btnAddSurvey" href="/add_survey" class="btn indigo right">New Survey</a>
    <div class="table-content">
        <table cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col"><?= $this->Paginator->sort('name') ?></th>
                    <th scope="col" width="40%"><?= $this->Paginator->sort('description') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('product_id') ?></th>
                    <th scope="col"><?= $this->Paginator->sort('category_id') ?></th>
                    <!-- <th scope="col"><?= $this->Paginator->sort('del_flg') ?></th> -->
                    <th scope="col"><?= $this->Paginator->sort('admin_id') ?></th>
                    <!-- <th scope="col"><?= $this->Paginator->sort('created') ?></th> -->
                    <!-- <th scope="col"><?= $this->Paginator->sort('modified') ?></th> -->
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
                        <!-- <td><?= $this->Number->format($survey->id) ?></td> -->
                        <td><?= $no++ ?></td>
                        <td><?= h($survey->name) ?></td>
                        <td><?= h($survey->description) ?></td>
                        <td><?= $survey->has('product') ? h($survey->product->name) : '' ?></td>
                        <td><?= $survey->has('category') ? h($survey->category->name) : '' ?></td>
                        <!-- <td><?= h($survey->del_flg) ?></td> -->
                        <td><?= $survey->has('admin') ? h($survey->admin->email) : '' ?></td>
                        <!-- <td><?= h($survey->created->i18nFormat('yyyy-MM-dd HH:mm:ss')) ?></td> -->
                        <!-- <td><?= h($survey->modified) ?></td> -->
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
</div>

<style>
    h3 {
        margin-top: 0.8rem;
    }

    .row {
        margin-bottom: .3rem;
        margin-top: 1rem;
    }

    div.input-field.col.s4 {
        border-radius: 10px;
        background-color: #e0e0e0;
        box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%);
        box-shadow: 0 3px 1px -2px rgb(0 0 0 / 12%);
        /* box-shadow: 0 1px 5px 0 rgb(0 0 0 / 20%); */

        /* box-shadow: 0 2px 2px 0 rgb(0 0 0 / 14%), 0 3px 1px -2px rgb(0 0 0 / 12%), 0 1px 5px 0 rgb(0 0 0 / 20%); */
        /* margin-right: 1rem; */
    }

    .input-field .prefix {
        top: .7rem;
        color: grey;
    }

    input#search.validate,
    input#search.validate.valid {
        margin: 3px 5px 3px 35px;
        border: none;
        font-family: inherit;
        box-shadow: none;
    }

    input#search.validate::placeholder {
        color: grey;
    }

    input#search:focus {
        box-shadow: none;
    }

    i.material-icons.prefix.active {
        color: #3F51B5;
    }

    #btnAddSurvey {
        margin-bottom: .5rem;
        margin-right: 1rem;
    }
</style>

<script>
    $('document').ready(function() {
        $('#search').keyup(function() {
            if (!$(this).val() || $(this).val().trim() == '') {
                location.reload();
            } else {
                var searchkey = $(this).val();
                searchSurveys(searchkey);
            }
        });

        function searchSurveys(keyword) {
            var data = keyword;
            $.ajax({
                method: 'get',
                url: "<?php echo $this->Url->build(['controller' => 'Surveys', 'action' => 'Search']); ?>",
                data: {
                    keyword: data
                },

                success: function(response) {
                    $('.table-content').html(response);
                }
            });
        };
    });
</script>