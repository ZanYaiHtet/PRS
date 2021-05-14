<?php echo $this->Html->script('Winwheel'); ?>
<?php echo $this->Html->script('http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js'); ?>
<html>
<meta name="csrf-token" content="{{ csrf_token() }}" />

<head>
    <title>HTML5 Canvas Winning Wheel</title>
</head>
<style>
    body {

        background-color: #fff;
    }

    /* Sets the background image for the wheel */
    .the_wheel {
        background-image: url("../img/wheel_back.png");
        background-repeat: no-repeat;
        background-position: center;
        padding-top: 20px;
    }

    /* Do some css reset on selected elements */
    h1,
    p {
        margin: 0;
    }

    div.power_controls {
        margin-right: 70px;
    }

    div.html5_logo {
        margin-left: 50px;
    }

    /* Styles for the power selection controls */
    table {
        margin-top: 2rem;
    }

    table.power {
        background-color: #cccccc;
        cursor: pointer;
        border: 1px solid #333333;
    }

    table.power th {
        background-color: white;
        cursor: default;
    }

    td.pw1 {
        background-color: #6fe8f0;
    }

    td.pw2 {
        background-color: #86ef6f;
    }

    td.pw3 {
        background-color: #ef6f6f;
    }

    /* Style applied to the spin button once a power has been selected */
    .clickable {
        cursor: pointer;
    }

    /* Other misc styles */
    .margin_bottom {
        margin-bottom: 5px;
    }
</style>

<body>
    <div align="center">

        <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td></td>
                <td width="465" height="582" class="the_wheel" id="spinWheel" onClick="startSpin();">
                    <canvas id="canvas" width="465" height="541">
                        <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
                    </canvas>
                </td>
                <td></td>
            </tr>
        </table>
    </div><br><br>

    <form action=" <?php
                    echo Cake\Routing\Router::url([
                        'controller' => 'prizes', 'action' => 'getscores/' . $Luser['id']
                    ]); ?>" method="post" id="form">

        <input type="hidden" value="" id="custom_scores" name="custom_scores">
        <input type="hidden" value="" id="userType" name="userType">

    </form>
    <!-- comment routes.php line 58 -->
    <script>
        // Create new wheel object specifying the parameters at creation time.
        let theWheel = new Winwheel({
            'outerRadius': 212, // Set outer radius so wheel fits inside the background.
            'innerRadius': 75, // Make wheel hollow so segments don't go all way to center.
            'textFontSize': 24, // Set default font size for the segments.
            'textOrientation': 'vertical', // Make text vertial so goes down from the outside of wheel.
            'textAlignment': 'outer', // Align text to outside of wheel.
            'numSegments': <?php echo $luckydraw_count; ?>, // Specify number of segments.
            'segments': // Define segments including colour and text.
                [ // font size and test colour overridden on backrupt segments.
                    <?php
                    foreach ($luckydraw_result as $score) {
                        echo "{'fillStyle' : '$score->color', 'text' : '$score->scores'},";
                    }
                    ?>
                ],
            'animation': // Specify the animation to use.
            {
                'type': 'spinToStop',
                'duration': 10, // Duration in seconds.
                'spins': 3, // Default number of complete spins.
                'callbackFinished': alertPrize,
                'callbackSound': playSound, // Function to call when the tick sound is to be triggered.
                'soundTrigger': 'pin' // Specify pins are to trigger the sound, the other option is 'segment'.
            },
            'pins': // Turn pins on.
            {
                'number': <?php echo $luckydraw_count; ?>,
                'fillStyle': 'silver',
                'outerRadius': 4,
            }
        });

        // Loads the tick audio sound in to an audio object.
        let audio = new Audio('tick.mp3');

        // This function is called when the sound is to be played.
        function playSound() {
            // Stop and rewind the sound if it already happens to be playing.
            audio.pause();
            audio.currentTime = 0;

            // Play the sound.
            audio.play();
        }

        // Vars used by the code in this page to do power controls.
        let wheelPower = 0;
        // -------------------------------------------------------
        // Click handler for spin button.
        // -------------------------------------------------------
        spinWheel = document.querySelector("#spinWheel");

        function startSpin() {
            theWheel.animation.spins = 10;
            theWheel.startAnimation();
            spinWheel.onclick = false;
        }
        // -------------------------------------------------------
        // Function for reset button.
        // -------------------------------------------------------
        function resetWheel() {
            theWheel.stopAnimation(false); // Stop the animation, false as param so does not call callback function.
            theWheel.rotationAngle = 0; // Re-set the wheel angle to 0 degrees.
            theWheel.draw(); // Call draw to render changes to the wheel.
            startSpin();
        }

        function alertPrize(indicatedSegment) {
            if (indicatedSegment.text == 'Again') {
                alert('Oh!, You get 1 Time Free');
                resetWheel();
            } else {
                var stext = indicatedSegment.text;
                alert("You have won " + stext);
                document.getElementById("custom_scores").value = stext;
                console.log(stext);
                formAction();
            }
        }

        function formAction() {
            let form = document.getElementById('form');
            form.submit();
        }
    </script>
</body>

</html>