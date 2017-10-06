/**
 * Created by agbaydan on 6/24/2017.
 */
function Simon(sel) {
    console.log("Simon Started");

    this.state = "initial";
    this.sequence = [];
    this.sequence.push(Math.floor(Math.random() * 4));
    this.current = 0;

    this.configureButton = function(ndx, color) {
        var button = $(this.form.find("input").get(ndx));
        var that = this;

                button.click(function (event) {
                if(that.state === "enter" || that.state === "fail") {
                    that.buttonPress(ndx, color);
                    if(that.state === "fail"){
                        document.getElementById("buzzer").currentTime = 0;
                        document.getElementById("buzzer").play();
                        window.setTimeout(function() {
                            window.location.replace("");
                        }, 1000);
                    }
                    else{
                        document.getElementById(color).currentTime = 0;
                        document.getElementById(color).play();
                    }
                }
            });

            button.mousedown(function (event) {
                if(that.state === "enter") {
                    button.css("background-color", color);
                }
            });

            button.mouseup(function (event) {
                if(that.state === "enter") {
                    button.css("background-color", "lightgrey");
                }
            });
    };

    // Get a reference to the form object
    this.form = $(sel);
    this.configureButton(0, "red");
    this.configureButton(1, "green");
    this.configureButton(2, "blue");
    this.configureButton(3, "yellow");

    this.play();
}

Simon.prototype.play = function() {
    console.log(this.sequence);
    this.state = "play";    // State is now playing
    this.current = 0;       // Starting with the first one
    this.playCurrent();
};

Simon.prototype.playCurrent = function() {
    var that = this;

    if(this.current < this.sequence.length) {
        // We have one to play
        var colors = ['red', 'green', 'blue', 'yellow'];
        document.getElementById(colors[this.sequence[this.current]]).play();
        this.buttonOn(this.sequence[this.current]);
        this.current++;

        window.setTimeout(function() {
            that.playCurrent();
        }, 1000);

    }
    else {
        // set all buttons back to grey
        this.buttonOn(-1);
        // set state to enter
        this.state = "enter";
        // reset current to 0
        this.current=0;
        // re-enable buttons
    }
};

Simon.prototype.buttonOn = function(button) {
    var colors = ['red', 'green', 'blue', 'yellow'];
    var that = this;

    if(button !== -1) {
        var i;
        for (i = 0; i <= 3; i++) {
            if (i === button) {
                //console.log("found button " + i);
                $(that.form.find("input").get(i)).css("background-color", colors[i]);
            }
            else {
                //console.log("wrong button " + i);
                $(that.form.find("input").get(i)).css("background-color", "lightgrey");
            }
        }
        console.log("\n");
    }
    // sets all back to grey
    else{
        for(var j=0; j<=3; j++){
            $(that.form.find("input").get(j)).css("background-color", "lightgrey");
        }
    }
};

Simon.prototype.buttonPress = function(button, color) {
    console.log(this.state);
    var that = this;
    console.log("Button pressed: " + button);
    console.log("current index: " + this.current);
    console.log("current value to match: "+ this.sequence[this.current]+"\n");

    // run the check: compare guess with current index in sequence
        // if a guess is wrong, play error buzzer and reset game
    if( button !== this.sequence[this.current] ){
        console.log("************* WRONG GUESS LOSER **************");
        this.state = "fail";
        return;
    }



    this.current++;
    // see if guessing is over
    if (this.current === this.sequence.length) {
        console.log("done guessing\n");
        /*
         done with guessing, user did not fail
         add a new value to the sequence
         run play
         */
        this.sequence.push(Math.floor(Math.random() * 4));
        window.setTimeout(function () {
            that.play();
        }, 1000);
    }
};
