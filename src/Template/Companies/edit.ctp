<style>
    .card {
        margin-top: 1rem;
    }

    .card-action {
        margin-top: -2rem;
    }

    .input {
        margin: 1rem;
    }

    .input-field {
        margin-bottom: -.3rem;
    }

    .row {
        margin-bottom: -.1rem;
    }

    .my-input {
        margin-top: 0rem;
    }

    h4 {
        margin-top: -.3rem;
        margin-bottom: 1.5rem;
    }
</style>
<?php

use Cake\ORM\TableRegistry;

$this->set('_serialize', ['company']);
$categories = TableRegistry::get('categories');
$companies = TableRegistry::get('companies');
$selected_list  = "";
$categories_list = $categories->find('all')->where(["del_flg" => "not"])->order(['name' => 'ASC']);
//SELECT * FROM Companies WHERE category_type LIKE '%4%'
$type_list = $companies->find('all')->where(["id" => $company["id"]]);
foreach ($type_list as $t) {
    $selected_list = $t['category_type'];
}

?>

<div class="container">
    <center>
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <?= $this->Form->create($company) ?>
                    <!-- <span class="card-title">Company Information</span> -->
                    <center>
                        <h4>Company Info</h4>
                    </center>
                    <table>
                        <input type="hidden" name="id" value="<?= $company['id'] ?>" />
                        <tr>
                            <th width='45%'>Company Name</th>
                            <td>
                                <div class="input-field col s12 my-input">
                                    <input name="name" type="text" class="validate" value="<?= $company['name'] ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Company Website <br> (Optional)</th>
                            <td>
                                <div class="input-field col s12 my-input">
                                    <input name="website" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" value="<?= $company['website'] ?>" />
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Company Address</th>
                            <td>
                                <div class="input-field col s12 my-input">
                                    <input name="address" type="text" class="validate" value="<?= $company['address'] ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Primary Contact Number <br>(format: 09-xxxxxxxx, 01-xxxxx)</th>
                            <td>
                                <div class="input-field col s12 my-input">
                                    <input name="phone" type="text" class="validate" pattern="[0-9]{0,3}-[0-9]{5,9}" value="<?= $company['phone'] ?>" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>Secondary Contact Number <br> (Optional)</th>
                            <td>
                                <div class="input-field col s12 my-input">
                                    <input name="other_phone" type="text" pattern="[0-9]{0,3}-[0-9]{5,9}" value="<?= $company['other_phone'] ?>">
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th>Types of Products</th>
                            <td>
                                <div class="input-field col s12">
                                    <select name="type[]" id="seltest" multiple>
                                        <option value="" disabled>Choose Category</option>
                                        <?php foreach ($categories_list as $cat) :
                                            $selected = "";
                                            // if (strcmp(strval($cat->id), $selected_list) > 0)
                                            if (strpos($selected_list, strval($cat->id)) !== false)
                                                $selected = "selected";
                                        ?>

                                            <option value="<?= h($cat->id) ?>" <?php echo $selected ?>><?= h($cat->name) ?></option>

                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="card-action">
                <div class="row">
                    <button type="submit" class="waves-effect waves-light btn indigo center">Update</button>
                    <?= $this->Html->link(__('Cancel'), ['action' => 'index'], ['class' => 'waves-effect waves-light btn center indigo']) ?>
                </div>
                </form>
            </div>
        </div>
    </center>
</div>
<script>
    $(document).ready(function() {
        $('select').formSelect();
    });
</script>