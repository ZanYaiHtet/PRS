<style type="text/css">
    .card .card-content {
        padding: 10px;
        border-radius: 50px;
    }

    .col .row {
        margin-left: 0rem;
        margin-right: 0rem;
        margin-bottom: 0rem;
    }

    .my-submit,
    .container {
        margin-top: 2rem;
    }

    .row .col.s5 {
        width: 26.6666666667%;
        margin-right: 6%;
        left: auto;
        right: 0px;
    }

    .btn-large {
        width: max-content;
    }

    .my-input-field {
        margin-top: 0.5rem;
        margin-bottom: -2rem;
    }

    .my-icon {
        color: grey;
    }

    .my-card-action {
        margin-top: 1.5rem;
    }
</style>

<!--
    TODO: Draggleable Card
-->

<form method="post" action="/surveys/add" id="form-id">
    <!-- TODO: handle Category and Products -->
    <input type="hidden" name="card_total" id="card_total" value="0">

    <input type="hidden" name="card_array" id="card_array">


    <div class="row">
        <div class="input-field col s1"></div>
        <div class="input-field col s2">
            <h6>Choose target &emsp;:</h6>
        </div>
        <div class="input-field col s4">
            <select id="selCategory" name="category_id">
                <option value="0" disabled selected>Choose your category</option>
                <?php foreach ($my_categories as $category) : ?>
                    <option value="<?= h($category->id) ?>"><?= h($category->name) ?></option>
                <?php endforeach ?>
            </select>
            <label>Select Category</label>
        </div>

        <div class="input-field col s4">
            <select id="selProduct" class="selProduct" name="product_id">
                <option value="0" disabled selected>Choose your product</option>
                <!-- <option value="1">Option 1</option> -->
                <!-- <?php foreach ($my_products as $product) : ?>
                    <option value="<?= h($product->id) ?>" data-category="<?= h($product->category_id) ?>"><?= h($product->name) ?></option>
                <?php endforeach; ?> -->
            </select>
            <label>Select Product</label>
        </div>
    </div>

    <!-- Title Card -->
    <div class="container" id="title-card">
        <div class="col s3">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="txtTitle" name="name" placeholder="Survey Title" type="text" class="validate" require>
                            <input id="txtDescription" name="description" placeholder="Survey Description" type="text" class="validate">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- FAB -->
    <div class="fixed-action-btn">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">add</i>
        </a>
        <ul>
            <li onclick="createCard(1)"><a class="btn-floating yellow darken-1 tooltipped" data-position="left" data-tooltip="Text Question"><i class="material-icons">title</i></a></li>
            <li onclick="createCard(2)"><a class="btn-floating green tooltipped" data-position="left" data-tooltip="CheckBox Question"><i class=" material-icons">check_box</i></a></li>
            <li onclick="createCard(3)"><a class="btn-floating blue tooltipped" data-position="left" data-tooltip="Radio Button Question"><i class="material-icons">radio_button_checked</i></a></li>
        </ul>
    </div>
    <div class="row center my-submit">
        <div class="col s5"></div>
        <div class="col s6">
            <button id="btnSave" class="btn waves-effect waves-light btn-medium indigo right" type="submit" name="action">Save
            </button>
        </div>
        <div class="col s1"></div>
    </div>
</form>
<!-- TOAST -->
<!-- <a id="add" class="btn">
    <i class="material-icons left">ac_unit</i>Toast!</a> -->

<script>
    var cardCount = 0;

    $(function() {

        // function for TOAST
        /* $("#add").click(function() {
            var last_id = $(".container:last").attr('id');
            var total = $(".container").length - 1;

            M.toast({
                html: "card total : " + total + ",<br> last card id : " + last_id
            });
        }); */

        // FAB
        $('.fixed-action-btn').floatingActionButton();

        // SELECT
        $('select').formSelect();

        // Tooltips
        $('.tooltipped').tooltip();
    });

    // selCategory index change event
    $("#selCategory").on('change', function() {
        var categories = <?php echo json_encode($my_categories); ?>;
        var products = <?php echo json_encode($my_products); ?>;
        // console.log(categories);
        // console.log(products);

        var categoryID = $(this).val();
        // console.log(categoryID);
        $('#selProduct option').remove();
        $('#selProduct').append('<option value="0" disabled selected>Choose your product</option>')

        $.each(products, function() {
            // console.log($(this)[0].category_id);
            // console.log('product_name : ' + $(this)[0].product_name);

            if (categoryID == $(this)[0].category_id) {
                $('#selProduct').append('<option value="' + $(this)[0].id + '">' + $(this)[0].name + '</option>');
            }
        });
        // <option value="0" disabled selected>Choose your product</option>
        // $('#selProduct').append("<option value='" + 1 + "'> Test </option>");
        $('select').formSelect();
    });

    // validation
    function validate() {
        var valid = 1;
        // select validation
        $('#selCategory option').each(function() {
            if ($(this).is(':selected') && $('#selCategory').val() == null) {
                M.toast({
                    html: "Select Category"
                });
                event.preventDefault();
                valid = 0;
            } else {
                valid = 1;
            }
        });

        // all input validation
        $('input[type=text]').each(function() {
            if ($(this).attr('placeholder') && !$(this).val()) {
                if ($(this).attr('disabled')) {
                    return true;
                } else {
                    $(this).focus();
                    M.toast({
                        html: "Fill your data"
                    });
                    event.preventDefault();
                    valid = 0;
                }
            }
        });

        return valid;
    }

    // before save
    $(document).on("click", "#btnSave", function() {
        var cardTotal = [];
        var card = {};

        var ready = validate();
        var numOfCard = $('#card_total').val();
        console.log(ready);

        if (ready == 1 && numOfCard >= 3) {
            $("[id^=card-]").each(function() {
                var cardID = $(this).attr('id');
                var options = [];

                $("#" + cardID + " :input").each(function(index) {

                    if (index == 0) {
                        var questionID = $(this).attr('id').split('-');
                        card.type = questionID[1];
                        card.question = $(this).val();
                    } else {
                        if ($(this).prop('disabled')) {
                            options = null;
                        } else {
                            if ($(this).val()) {
                                options.push($(this).val());
                            }
                        }
                    }
                    if (options != null) {
                        card.options = options;
                    }
                });
                cardTotal.push(card);
                card = {};
            });

            $('#card_array').val(JSON.stringify(cardTotal));
        } else {
            if (numOfCard < 3) {
                M.toast({
                    html: 'A survey should have at least 3 questions.'
                });
            }
            return false;
        }

    });

    // disable enterOnSubmit
    $(function() {
        $("form").on("keypress", function(event) {
            var keyPressed = event.keyCode || event.which;
            if (keyPressed === 13) {
                var focused = $(':focus');
                var parent = $(focused).parent().parent().attr('id');
                if (parent) {
                    addOption(focused);
                }
                event.preventDefault();
                return false;
            }
        });
    });

    // Delete Card
    $(document).on("click", ".my-btn", function() {
        var clickedBtnID = $(this).attr('id');
        var id = clickedBtnID.split("-");

        $("#card-" + id[1]).remove();

        $('#card_total').val($('#card_total').val() - 1);

        M.toast({
            html: "Deleted"
        });
    });

    // select box index change
    /*     $('#selCategory').change(function() {
            var idx = $('#selCategory').val();
            console.log(idx);

            // $('.selProduct option[data-category="' + idx + '"]').remove();
            $(".selProduct option[value='2']").each(function() {
                $(this).remove();
            });
        }); */

    // Create Card
    function createCard(type) {
        // get last card
        var lastCardID = $(".container:last").attr('id');
        var cardTotal = $(".container").length - 2; //default container and title container

        if (cardTotal < 30) {
            $('#card_total').val(cardTotal + 1);

            if (cardTotal > cardCount) {
                cardCount = cardTotal;
                cardCount++;
            } else {
                cardCount++;
            }

            var ID = 'card-' + cardCount;
            var container = $('<div class="container" id="' + ID + '"></div>');
            container.insertAfter($("#" + lastCardID));
            var card = "";

            if (type == 1) {
                card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><input  id="txt-text-Question-' + cardCount + '"  placeholder="Question" type="text" class="validate" require></div></div><div class="row"><div class="input-field col s12"><input placeholder="Answer Text" type="text" class="validate" disabled></div></div></div><div class="card-action"><div class="row"><div class="col s10"></div><div class="col s2"><div id="delete-' + cardCount + '" class="waves-effect waves-light my-btn"><i class="material-icons">delete</i></div></div></div></div></div></div></div>');
            } else if (type == 2) {
                card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><input id="txt-check-Question-' + cardCount + '"  placeholder="Question" type="text" class="validate" require></div></div><div id="crd-' + cardCount + '-check-child-1" class="row check-child"> <div class="input-field col s8 my-input-field"> <i class = "material-icons prefix my-icon" > check_box_outline_blank </i> <input placeholder = "Option" type = "text"> </div> <div class = "input-field col s1" > <a class = "btn-floating waves-effect btn-small green lighten-1" onclick="addOption(this)"> <i class = "material-icons"> add </i> </a> </div> </div> </div> <div class="card-action my-card-action"> <div class="row"> <div class="col s10"> </div> <div class = "col s2" >  <div id = "delete-' + cardCount + '" class = "waves-effect waves-light my-btn" > <i class = "material-icons">delete</i> </div> </div> </div > </div> </div> </div> </div > ');
            } else if (type == 3) {
                card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><input id="txt-radio-Question-' + cardCount + '"  placeholder="Question" type="text" class="validate" require></div></div><div id="crd-' + cardCount + '-radio-child-1" class="row radio-child"> <div class="input-field col s8 my-input-field"> <i class = "material-icons prefix my-icon" > radio_button_unchecked</i> <input placeholder = "Option" type = "text"> </div> <div class = "input-field col s1" > <a class = "btn-floating waves-effect btn-small green lighten-1" onclick="addOption(this)"> <i class = "material-icons"> add </i> </a> </div> </div> </div> <div class="card-action my-card-action"> <div class="row"> <div class="col s10"> </div> <div class = "col s2" >  <div id = "delete-' + cardCount + '" class = "waves-effect waves-light my-btn" > <i class = "material-icons">delete</i> </div> </div> </div > </div> </div> </div> </div > ');
            }

            container.append(card);
        } else {
            M.toast({
                html: 'Only 30 Questions\'re allowed.'
            });
        }
    }

    // add Check/Radio Option
    function addOption(btnAdd) {
        var id = $(btnAdd).parent().parent().attr('id');
        console.log("parent id : " + id);

        if (getChildCount(id) < 9) {
            var raw = id.split('-');
            var cardNo = raw[1];
            var optionType = raw[2];
            var option = '';

            if (optionType == 'check') {
                option = '<div id="crd-' + cardNo + '-check-child-1" class="row check-child"><div class="input-field col s8 my-input-field"><i class="material-icons prefix my-icon">check_box_outline_blank</i><input placeholder="Option" type="text"></div><div class="input-field col s1"><a class="btn-floating waves-effect btn-small red lighten-1 remove"><i class="material-icons">remove</i></a></div></div>';
            } else if (optionType == 'radio') {
                option = '<div id="crd-' + cardNo + '-radio-child-1" class="row radio-child"><div class="input-field col s8 my-input-field"><i class="material-icons prefix my-icon">radio_button_unchecked</i><input placeholder="Option" type="text"></div><div class="input-field col s1"><a class="btn-floating waves-effect btn-small red lighten-1 remove"><i class="material-icons">remove</i></a></div></div>';
            }

            if (option != '') {
                $('#' + id).append(option);

                // setNewID(id);
            }
            $('#' + id + ' :last-child').focus();
        }
    }

    // remove Option
    $(document).on("click", "a.remove", function() {
        $(this).parent().parent().remove();
    });

    // renew ID of Options
    /*     function setNewID(ID) {
            var className = getClassName(ID);
            var raw = ID.split('-');
            $('#' + ID + ' > .' + className).map(function(index) {
                index += 2;
                var newID = 'crd-' + raw[1] + '-' + className + '-' + index;
                $(this).attr('id', newID);
            });
        } */

    function getClassName(ID) {
        var className = $('#' + ID).attr('class').split(' ').pop();
        return className;
    }

    function getChildCount(ID) {
        var className = getClassName(ID);
        var count = $('#' + ID + ' > .' + className).length;
        return count;
    }
</script>