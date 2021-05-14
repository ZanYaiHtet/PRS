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

<form method="post" action="/surveys/view">
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

    <!-- Check Card -->
    <!-- <div class="container" id="card-2">
        <div class="col s3">
            <div class="card">
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col s12">
                            <h6 id="txt-text-Question-' + cardCount + '">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Illum beatae inventore ducimus cupiditate ex nam recusandae reprehenderit odio ea totam molestiae quisquam excepturi rerum amet officiis tempora aut, optio, consequuntur expedita minus. Pariatur blanditiis dolorem inventore! Quas perspiciatis libero suscipit ut? Natus veniam dolor culpa itaque ipsum tempore ducimus iste.</h6>
                        </div>
                    </div>
                    <div id="card-1-child-1" class="row check-child">
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input type="checkbox" />
                                    <span>Filled in Lorem ipsum dolor sit, amet consectetur adipisicing elit. Eum, quam!</span>
                                </label>
                            </p>
                            <p>
                                <label>
                                    <input type="checkbox" />
                                    <span>Filled in</span>
                                </label>
                            </p>
                        </div>
                        <div class="input-field col s6">
                            <p>
                                <label>
                                    <input type="checkbox" />
                                    <span>Filled in / out Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsa,</span>
                                </label>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

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

        if (type === 'text') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6  id="question-text-' + cardCount + '-' + qID + '" >' + description + '</h6></div></div><div class="row"><div class="input-field col s12"><input id="answer-text-' + cardCount + '-' + qID + '" placeholder="Your answer" type="text" class="validate"></div></div></div></div></div></div>');
        } else if (type === 'check') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-check-' + cardCount + '-' + qID + '">' + description + '</h6></div></div><div id="crd-' + cardCount + '-check-child-1" class="row check-child"> <div id="crd-' + cardCount + '-check-child-2" class="input-field col s12"></div></div></div></div></div></div> ');
        } else if (type === 'radio') {
            card = $('<div class="col s3"><div class="card hoverable"><div class="card-content"><div class="row"><div class="input-field col s12"><h6 id="question-radio-' + cardCount + '-' + qID + '">' + description + '</h6></div></div><div id="crd-' + cardCount + '-radio-child-1" class="row radio-child"> <div id="crd-' + cardCount + '-radio-child-2" class="input-field col s12"></div></div></div></div></div></div>');
        }

        container.append(card);
    }

    // add Check/Radio Option
    function addOption(optionType, description, cardNo, ID) {
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
</script>