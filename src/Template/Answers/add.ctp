<!-- <?php
        /**
         * @var \App\View\AppView $this
         */
        ?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Answers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Products'), ['controller' => 'Products', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Product'), ['controller' => 'Products', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Categories'), ['controller' => 'Categories', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Category'), ['controller' => 'Categories', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Questions'), ['controller' => 'Questions', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Question'), ['controller' => 'Questions', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Surveys'), ['controller' => 'Surveys', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Survey'), ['controller' => 'Surveys', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Options'), ['controller' => 'Options', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Option'), ['controller' => 'Options', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="answers form large-9 medium-8 columns content">
    <?= $this->Form->create($answer) ?>
    <fieldset>
        <legend><?= __('Add Answer') ?></legend>
        <?php
        echo $this->Form->control('product_id', ['options' => $products, 'empty' => true]);
        echo $this->Form->control('category_id', ['options' => $categories]);
        echo $this->Form->control('question_id', ['options' => $questions]);
        echo $this->Form->control('survey_id', ['options' => $surveys]);
        echo $this->Form->control('option_id', ['options' => $options, 'empty' => true]);
        echo $this->Form->control('user_id', ['options' => $users]);
        echo $this->Form->control('answer');
        echo $this->Form->control('remark');
        echo $this->Form->control('rating');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div> -->

<style type="text/css">
    .card .card-content {
        padding: 1.5rem;
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

    p {
        padding-bottom: 1rem;
    }

    h4 {
        margin: 0rem 0 1rem 0;
    }

    h6 {
        margin-top: -0.5rem;
    }

    /* span {
        color: black;
    } */
</style>

<form method="post" action="/answers/add">
    <!-- <input type="hidden" name="user_id" value="1" /> -->
    <input type="hidden" name="survey_id" value="<?= h($survey[0]->id) ?>" />
    <input type="hidden" name="category_id" value="<?= h($survey[0]->category_id) ?>" />
    <input type="hidden" name="product_id" value="<?= h($survey[0]->product_id) ?>" />
    <input type="hidden" name="answers" id="answers" />

    <!-- Title Card -->
    <div class="container" id="title-card">
        <div class="col s3">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
                            <!-- <input id="txtTitle" name="name" placeholder="Survey Title" type="text" class="validate" require> -->
                            <!-- <input id="txtDescription" name="description" placeholder="Survey Description" type="text" class="validate">
                             -->
                            <h4><?= h($survey[0]->title) ?></h4>
                            <blockquote>
                                <?= h($survey[0]->description) ?>
                            </blockquote>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- for Rating -->
    <style>
        .my-rate {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>

    <div class="row center my-submit">
        <div class="col s7"></div>
        <div class="col s3">
            <button id="btnSave" class="btn waves-effect waves-light btn-medium indigo right" type="submit" name="action">submit
            </button>
        </div>
        <div class="col s2"></div>
    </div>
</form>

<script>
    var cardCount = 0;
    // load data from PHP
    var survey = <?php echo json_encode($survey); ?>;
    var questions = <?php echo json_encode($questions); ?>;
    var options = <?php echo json_encode($options); ?>;
    /* console.log(survey);
    console.log(questions);
    console.log(options); */

    questions.forEach(element => {
        // console.log(element.id);
        // var type = getType(element.type);
        // console.log(type);
        createCard(element.id, element.type, element.description);
        // console.log('card no : ' + cardCount);
        options.forEach(elem => {
            if (element.id === elem.question_id) {
                // console.log('option: ' + elem.description);
                addOption(element.type, elem.description, cardCount, elem.id);
            }
        });
    });

    // before Save
    $(document).on("click", "#btnSave", function(event) {
        if (validate() === 1) {
            getAnswers();
            // event.preventDefault();
        } else {
            M.toast({
                html: 'Please answer all questions.'
            });

            event.preventDefault();
        }
    });

    function getAnswers() {
        var allCards = [];
        var card = {};

        $("[id^=card-]").each(function() {
            var cardID = $(this).attr('id');

            card.question = $('#' + cardID).find('h6').attr('id').split('-').pop();

            questionType = $('#' + cardID).find('h6').attr('id').split('-');
            // console.log(questionType);

            if (questionType[1] == 'text') {
                card.answer = $('#' + cardID).find('input[type=text]').val();

                // console.log($('#' + cardID).find('input[type=text]').val());
            } else if (questionType[1] == 'radio') {
                var group = $('#' + cardID).find(':radio').attr('name');
                // console.log($(':radio[name="' + group + '"]:checked').val());
                card.option = $(':radio[name="' + group + '"]:checked').val();
            } else if (questionType[1] == 'check') {
                var options = [];
                $('#' + cardID).find(':checkbox').each(function() {
                    if ($(this).is(':checked')) {
                        // console.log($(this).val());
                        options.push($(this).val());
                    }
                });
                card.options = options;
            } else if (questionType[1] == 'remark') {
                delete card.question;
                card.remark = $('#' + cardID).find('input[type=text]').val();

                // console.log($('#' + cardID).find('input[type=text]').val());
            } else if (questionType[1] == 'rating') {
                delete card.question;
                card.rating = $(':radio[name="rate"]:checked').val();
            }
            allCards.push(card);
            card = {};
        });
        $('#answers').val(JSON.stringify(allCards));
    }

    // validation
    function validate() {
        var ready = 0;
        var checkArr = [];
        var radioArr = [];
        var textArr = [];

        // RADIO
        // get all radio group
        var radio_groups = {}
        $(":radio").each(function() {
            radio_groups[this.name] = true;
        });
        // selected or not?
        for (group in radio_groups) {
            if_checked = !!$(":radio[name='" + group + "']:checked").length;
            // console.log('if checked : ' + if_checked);
            if_checked ? radioArr.push(1) : radioArr.push(0);

            // console.log(group + (if_checked ? ' has checked radios, value is : id-' + $(":radio[name='" + group + "']:checked").val() : ' does not have checked radios'));
        }

        // CHECKBOX
        // get all cardID
        $("[id^=card-]").each(function() {
            var cardID = $(this).attr('id');
            var checked = 0;

            // console.log('card id : ' + cardID);

            if ($('#' + cardID + ' div:nth-child(even)').attr('id')) {
                var checkID = $('#' + cardID + ' div:nth-child(even)').attr('id');
                var raw = checkID.split('-');
                if (raw[2] == 'check') {
                    $('#' + checkID).find(':checkbox').each(function() {
                        if ($(this).is(':checked')) {
                            checked = 1;
                            // console.log($(this).val());
                        }
                    });
                    checkArr.push(checked);
                    checked = 0;
                }
            }
            /* else
                           console.log('no such child'); */
        });

        // TEXTBOX
        $("input[type='text']").each(function() {
            // alert('text input : ' + ($(this).attr('id')));
            // alert('val : ' + $(this).val());

            $(this).val() ? textArr.push(1) : textArr.push(0);
        });

        /* console.log('check array : ' + checkArr);
        console.log('all radios : ' + radioArr);
        console.log('all text : ' + textArr); */

        if (($.inArray(0, checkArr) === -1) && ($.inArray(0, radioArr) === -1) && ($.inArray(0, textArr) === -1)) {
            ready = 1;
            // alert('Ok bro!');
        } else ready = 0;

        return ready;
    }

    // Create Card
    function createCard(qID, type, description) {
        // get last card
        var lastCardID = $(".container:last").attr('id');
        var cardTotal = $(".container").length - 2; //default container and title container

        // if (cardTotal < 30) {
        // $('#card_total').val(cardTotal + 1);

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

        if (type === 'text') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6  id="question-text-' + cardCount + '-' + qID + '" >' + cardCount + '. ' + description + '</h6></div></div><div class="row"><div class="input-field col s12"><input id="answer-text-' + cardCount + '-' + qID + '" placeholder="Your answer" type="text" class="validate"></div></div></div></div></div></div>');
        } else if (type === 'check') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-check-' + cardCount + '-' + qID + '">' + cardCount + '. ' + description + '</h6></div></div><div id="crd-' + cardCount + '-check-child-1" class="row check-child"> <div id="crd-' + cardCount + '-check-child-2" class="input-field col s12"></div></div></div></div></div></div> ');
        } else if (type === 'radio') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-radio-' + cardCount + '-' + qID + '">' + cardCount + '. ' + description + '</h6></div></div><div id="crd-' + cardCount + '-radio-child-1" class="row radio-child"> <div id="crd-' + cardCount + '-radio-child-2" class="input-field col s12"></div></div></div></div></div></div>');
        }

        container.append(card);
        // } else {
        //     M.toast({
        //         html: 'Only 30 Questions\'re allowed.'
        //     });
        // }
    }

    // add Check/Radio Option
    function addOption(optionType, description, cardNo, ID) {
        // var id = $(btnAdd).parent().parent().attr('id');
        // console.log("parent id : " + id);

        // if (getChildCount(id) < 9) {
        // var raw = id.split('-');

        // var cardNo = raw[1];
        // var optionType = raw[2];
        var parentID = 'crd-' + cardNo + '-' + optionType + '-child-2';

        var option = '';

        if (optionType == 'check') {
            option = '<p><label><input type="checkbox" value="' + ID + '"/><span>' + description + '</span></label></p>';
        } else if (optionType == 'radio') {
            option = '<p><label><input class="with-gap" name="group' + cardNo + '" type="radio" value="' + ID + '"/><span>' + description + '</span></label></p>';
        }

        if (option != '') {
            $('#' + parentID).append(option);
        }
    }

    // Remark & Rating Card
    function addRemarkNRatingCard() {
        var lastCardID = $(".container:last").attr('id');
        var containerRating = $('<div class="container" id="card-rating"></div>');
        var containerRemark = $('<div class="container" id="card-remark"></div>');

        var cardRemark = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6  id="question-remark-x-x" >' + ++cardCount + '. We appreciate your remarks?</h6></div></div><div class="row"><div class="input-field col s12"><input id="answer-remark-x-x" placeholder="Your remark" type="text" class="validate"></div></div></div></div></div></div>');

        var cardRating = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-rating-h-r">' + ++cardCount + '. How many stars will you rate to this product?</h6></div></div><div class="row my-rate"><div class="col s4"></div><div class="rate"><input type="radio" id="star5" name="rate" value="5" /><label for="star5" title="excellent">5 stars</label><input type="radio" id="star4" name="rate" value="4" /><label for="star4" title="best">4 stars</label><input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="good">3 stars</label><input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="bad">2 stars</label><input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="worst">1 star</label></div><div class="col s3"></div></div></div></div></div>');

        containerRemark.insertAfter($('#' + lastCardID));
        containerRemark.append(cardRemark);

        containerRating.insertAfter($('#card-remark'));
        containerRating.append(cardRating);
    }

    $(function() {
        addRemarkNRatingCard();
    });
</script>