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

<form method="post">
    <input type="hidden" name="survey_id" value="<?= h($survey[0]->id) ?>" />
    <input type="hidden" name="category_id" value="<?= h($survey[0]->category_id) ?>" />
    <input type="hidden" name="product_id" value="<?= h($survey[0]->product_id) ?>" />
    <!-- <input type="hidden" name="answers" id="answers" /> -->

    <!-- Title Card -->
    <div class="container" id="title-card">
        <div class="col s3">
            <div class="card hoverable">
                <div class="card-content">
                    <div class="row">
                        <div class="col s12">
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

    <div class="row center my-submit">
        <div class="col s7"></div>
        <div class="col s3">
            <button id="btnSave" class="btn waves-effect waves-light btn-medium indigo right" type="submit" name="action">back
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
    var answers = <?php echo json_encode($answers); ?>;
    console.log(answers);

    questions.forEach(element => {
        createCard(element.id, element.type, element.description);
        options.forEach(elem => {
            if (element.id === elem.question_id) {
                addOption(element.type, elem.description, cardCount, elem.id);
            }
        });
    });

    // Create Card
    function createCard(qID, type, description) {
        // get last card
        var lastCardID = $(".container:last").attr('id');
        var cardTotal = $(".container").length - 2; //default container and title container

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
        var text = false;

        if (type === 'text') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6  id="question-text-' + cardCount + '-' + qID + '" >' + cardCount + '. ' + description + '</h6></div></div><div class="row"><div class="input-field col s12"><input id="answer-text-' + cardCount + '-' + qID + '" placeholder="Your answer" type="text" class="validate"></div></div></div></div></div></div>');

            var text = true;
        } else if (type === 'check') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-check-' + cardCount + '-' + qID + '">' + cardCount + '. ' + description + '</h6></div></div><div id="crd-' + cardCount + '-check-child-1" class="row check-child"> <div id="crd-' + cardCount + '-check-child-2" class="input-field col s12"></div></div></div></div></div></div> ');
        } else if (type === 'radio') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-radio-' + cardCount + '-' + qID + '">' + cardCount + '. ' + description + '</h6></div></div><div id="crd-' + cardCount + '-radio-child-1" class="row radio-child"> <div id="crd-' + cardCount + '-radio-child-2" class="input-field col s12"></div></div></div></div></div></div>');
        }

        container.append(card);

        if (text) {
            answers.forEach(ans => {
                if (ans.question_id == qID) {
                    $('#answer-text-' + cardCount + '-' + qID).val(ans.answer);
                }
            });
            text = false;
        }
    }

    // add Check/Radio Option
    function addOption(optionType, description, cardNo, ID) {
        var parentID = 'crd-' + cardNo + '-' + optionType + '-child-2';

        var option = '';

        if (optionType == 'check') {
            option = '<p><label><input id="' + ID + '" type="checkbox" /><span>' + description + '</span></label></p>';
        } else if (optionType == 'radio') {
            option = '<p><label><input id="' + ID + '" class="with-gap" name="group' + cardNo + '" type="radio" /><span>' + description + '</span></label></p>';
        }

        if (option != '') {
            $('#' + parentID).append(option);
        }
    }

    function checkOption() {
        answers.forEach(ans => {
            /* if (ans.option_id === ID && ans.question_id === qID) {
                console.log(ans.option_id + '\n' + ID);
                return true;
            } */
            $('#' + ans.option_id).prop("checked", true);
        });
    }

    // Remark & Rating Card
    function addRemarkNRatingCard() {
        var lastCardID = $(".container:last").attr('id');
        var containerRating = $('<div class="container" id="card-rating"></div>');
        var containerRemark = $('<div class="container" id="card-remark"></div>');

        var cardRemark = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6  id="question-remark-x-x" >' + ++cardCount + '. We appreciate your remarks?</h6></div></div><div class="row"><div class="input-field col s12"><input id="answer-remark-x-x" placeholder="Your remark" type="text" class="validate" value="' + answers[0].remark + '"></div></div></div></div></div></div>');

        var cardRating = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-rating-h-r">' + ++cardCount + '. How many stars will you rate to this product?</h6></div></div><div class="row my-rate"><div class="col s4"></div><div class="rate"><input type="radio" id="star5" name="rate" value="5" /><label for="star5" title="excellent">5 stars</label><input type="radio" id="star4" name="rate" value="4" /><label for="star4" title="best">4 stars</label><input type="radio" id="star3" name="rate" value="3" /><label for="star3" title="good">3 stars</label><input type="radio" id="star2" name="rate" value="2" /><label for="star2" title="bad">2 stars</label><input type="radio" id="star1" name="rate" value="1" /><label for="star1" title="worst">1 star</label></div><div class="col s3"></div></div></div></div></div>');

        containerRemark.insertAfter($('#' + lastCardID));
        containerRemark.append(cardRemark);

        containerRating.insertAfter($('#card-remark'));
        containerRating.append(cardRating);
    }

    $(function() {
        addRemarkNRatingCard();

        // check all child
        checkOption();

        // add star
        if (answers[0].rating) {
            $('#star' + answers[0].rating).prop("checked", true);
        }

        $("input").attr('disabled', 'disabled');
    });
</script>