/**
 * Created by agbaydan on 6/28/2017.
 */

function Nurikabe(sel, gameBoard, gameSolution) {
    var that = this;
    this.sel = sel;
    this.gameBoard = parse_json(gameBoard);
    this.gameSolution = parse_json(gameSolution);
    this.isRed = false;
    this.consts = {
        SEA : 'sea',
        ISLAND : 'island',
        VACANT : 'vacant',
        RED : 'red',
        RED_ISLAND : 'red_island'
    };
    // console.log(this.consts);

    console.log("Game started!");
    console.log(this.gameBoard);
    console.log(this.gameSolution);

    // hide winner p, yes no buttons, solve confirm p
    $("#winner-message").hide();
    $("#solveYes").hide();
    $("#solveNo").hide();
    $("#message-solve").hide();


    //console.log("Sel: "+this.sel);
    //console.log($(this.sel + " td button"));

    $(this.sel + " td button").click(function(event) {
        event.preventDefault();
        console.log("cell clicked!");
        // console.log($(that.sel + " td button"));
        loc = this.value.split(',');
        r = loc[0];
        c = loc[1];
        // update the cell
        that.updateCell(r, c, false);
    });

    $("#checkSolution").click(function (event) {
        event.preventDefault();
        console.log("check solution clicked!!");
        that.checkSolution();
    });

    $("#solve").click(function (event) {
        event.preventDefault();
        that.solveConfirm();
    });

    $("#solveYes").click(function (event) {
        event.preventDefault();
        that.solveYes();
    });

    $("#solveNo").click(function (event) {
        event.preventDefault();
        that.solveNo();
    });

    $("#clear").click(function () {
        event.preventDefault();
        console.log("clear clicked!!");
        that.clear();
    });
}