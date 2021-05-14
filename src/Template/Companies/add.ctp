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

    .my-row1 {
        margin-top: -.2rem;
    }

    .my-row2 {
        margin-top: .1rem;
    }

    h4 {
        margin-top: -.3rem;
        margin-bottom: 1.5rem;
    }
</style>


<div class="container">
    <center>
        <div class="card">
            <div class="card-content">
                <div class="row">
                    <form action="add" method="post">
                        <center>
                            <h4>Add Company</h4>
                        </center>
                        <table>
                            <tr>
                                <th>Company Name</th>
                                <td>
                                    <div class="input-field col s12 my-input">
                                        <input name="name" type="text" class="validate" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Company Website <br>(Optional)</th>
                                <td>
                                    <div class="input-field col s12 my-input">
                                        <input name="website" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" />
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Company Address</th>
                                <td>
                                    <div class="input-field col s12 my-input">
                                        <input name="address" type="text" class="validate" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Primary Contact Number <br>(format: 09-xxxxxxxx, 01-xxxxx)</th>
                                <td>
                                    <div class="input-field col s12 my-input">
                                        <input name="phone" type="text" pattern="[0-9]{0,3}-[0-9]{5,9}" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Secondary Contact Number <br>(Optional)</th>
                                <td>
                                    <div class="input-field col s12 my-input">
                                        <input name="other_phone" type="text" pattern="[0-9]{0,3}-[0-9]{5,9}">
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <th>Types of Products</th>
                                <td>
                                    <div class="input-field col s12">
                                        <select name="type[]" id="seltest" multiple>
                                            <option value="" disabled>Choose Category</option>
                                            <?php foreach ($categories_list as $cat) : ?>
                                                <option value="<?= h($cat->id) ?>"><?= h($cat->name) ?></option>
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
                    <button type="submit" class="waves-effect waves-light btn indigo center">Save</button>
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