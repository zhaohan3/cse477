/*! DO NOT EDIT project3 2017-06-29 */
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
/**
 * Created by agbaydan on 6/28/2017.
 */

Nurikabe.prototype.checkSolution = function () {
    var that = this;
    // loop thru game board: if cell is not vacant: check and set to red if wrong, set class to incorrect
    /************ LOOP THRU BOARD ************/
    for(var r=0; r<this.gameBoard.length; r++){
        var row = this.gameBoard[r];
        for(var c=0; c<row.length; c++){
            var gameCell = this.gameBoard[r][c];
            var solCell = this.gameSolution[r][c];
            if( ( gameCell === this.consts.SEA || gameCell === this.consts.ISLAND ) && gameCell !== solCell ){
                this.isRed = true;
                this.updateCell(r, c, true);
            }
        }
    }
};
/**
 * Created by agbaydan on 6/28/2017.
 */

Nurikabe.prototype.clear = function() {
    var that = this;
    console.log("clear function called!!");

    /************ LOOP THRU BOARD ************/
    // if cell is not int, set to vacant
    for(var r=0; r<this.gameBoard.length; r++){
        var row = this.gameBoard[r];
        for(var c=0; c<row.length; c++){
            var gameCell = this.gameBoard[r][c];
            if( isNaN(gameCell) ){
                console.log("NaN found!!");
                // set value and class to vacant
                this.gameBoard[r][c] = this.consts.VACANT;
                var boardCell = $(this.sel + " td#" + r+c);
                var currentClass = boardCell.attr('class');
                console.log(currentClass);
                boardCell.removeClass(currentClass);
                boardCell.addClass('vacant');
                boardCell.children('button').html('&nbsp;');
            }
        }
    }
};
/**
 * Created by agbaydan on 6/28/2017.
 */
Nurikabe.prototype.isSolved = function () {
    var that = this;

    if( this.gameBoard.toString() === this.gameSolution.toString() ){
        console.log("********** WINNER **********");
        // hide everything except for winner message
        $("#checkSolution").hide();
        $("#solve").hide();
        $("#clear").hide();

        $("#solveYes").hide();
        $("#solveNo").hide();
        $("#message-solve").hide();

        // show winning message
        $("#winner-message").show();

        // disable all cell buttons
        console.log($(this.sel + " td").children());
        $(this.sel + " td").children().attr("disabled", true);
        $(this.sel + " td").children().css("color", "black");
    }
};
/**
 * Created by agbaydan on 6/28/2017.
 */
Nurikabe.prototype.solveConfirm = function () {
    console.log("solve confirm!!");

    // hide check solution, solve, clear buttons
    $("#checkSolution").hide();
    $("#solve").hide();
    $("#clear").hide();

    // show yes no buttons and message
    $("#solveYes").show();
    $("#solveNo").show();
    $("#message-solve").show();
};
/**
 * Created by agbaydan on 6/28/2017.
 */

Nurikabe.prototype.solveNo = function () {
    console.log("Solve cuz i suck!!");

    // hide current options
    $("#solveYes").hide();
    $("#solveNo").hide();
    $("#message-solve").hide();

    // show regular options
    $("#checkSolution").show();
    $("#solve").show();
    $("#clear").show();
};
/**
 * Created by agbaydan on 6/29/2017.
 */

Nurikabe.prototype.solveYes = function () {
    console.log("solve me pls");

    /************ LOOP THRU BOARD ************/
    // set each cell to its corresponding solution cell
    for(var r=0; r<this.gameBoard.length; r++){
        var row = this.gameBoard[r];
        for(var c=0; c<row.length; c++){
            // set the game board
            this.gameBoard[r][c] = this.gameSolution[r][c];

            // set the class
            var boardCell = $(this.sel + " td#" + r+c);
            var currentClass = boardCell.attr('class');
            boardCell.removeClass(currentClass);
            if( this.gameSolution[r][c] === this.consts.SEA ){
                boardCell.addClass('sea')
                boardCell.children('button').html('&nbsp;');
            }
            else if( this.gameSolution[r][c] === this.consts.ISLAND ){
                boardCell.addClass('island');
                boardCell.children('button').html('&#9679;');
            }
        }
    }
    this.isSolved();
};
/**
 * Created by agbaydan on 6/28/2017.
 */

/*
 @param r row number
 @param c column number
 @param turnRed: bool: if true set cell to red, else update normally
 */
Nurikabe.prototype.updateCell = function (r, c, turnRed) {
    var that = this;
    console.log("update called!");
    console.log(r+" "+c);

    // cell object
    var cellObj = $(this.sel + " td#" + r+c);

    //console.log($(this.sel + " td#" + r+c).attr('class'));
    //console.log($(this.sel + " td#" + r+c));

    // check if the last move was checkSolution by checking for red cells in the board, if yes clear them
    if( this.isRed && !turnRed){
        console.log("red cells present");
        for(var cr=0; cr<this.gameBoard.length; cr++){
            var row = this.gameBoard[cr];
            for(var cc=0; cc<row.length; cc++){
                var gameCell = this.gameBoard[cr][cc];
                var redCellObj = $(this.sel + " td#" + cr+cc);
                if( gameCell === this.consts.RED  ){
                    redCellObj.removeClass('incorrect');
                    redCellObj.addClass('sea');
                    this.gameBoard[cr][cc] = this.consts.SEA;
                }
                else if( gameCell === this.consts.RED_ISLAND ){
                    redCellObj.removeClass('incorrect');
                    redCellObj.addClass('island');
                    this.gameBoard[cr][cc] = this.consts.ISLAND;
                }
            }
        }
        this.isRed = false;
    }

    /*
     For each cell: update the class and button html, update the game board
     if isRed, set the cell to proper 'red' state
     */
    // if vacant => sea
    if( cellObj.attr('class') === 'vacant' ){
        cellObj.removeClass('vacant');
        cellObj.addClass('sea');
        this.gameBoard[r][c] = this.consts.SEA;
    }
    // if sea => island, add dot
    else if( cellObj.attr('class') === 'sea' ){
        cellObj.removeClass('sea');
        if(turnRed){
            cellObj.addClass('incorrect');
            this.gameBoard[r][c] = this.consts.RED;
            return;
        }
        cellObj.addClass('island');
        cellObj.children('button').html('&#9679;');

        this.gameBoard[r][c] = this.consts.ISLAND;
    }
    // if island => vacant
    else if( cellObj.attr('class') === 'island' ){
        cellObj.removeClass('island');
        if(turnRed){
            cellObj.addClass('incorrect');
            this.gameBoard[r][c] = this.consts.RED_ISLAND;
            return;
        }
        cellObj.addClass('vacant');
        cellObj.children('button').html('&nbsp;');

        this.gameBoard[r][c] = this.consts.VACANT;
    }

    // after each cell is updated: check if game is solved
    this.isSolved();
};
/**
 * Created by agbaydan on 6/28/2017.
 */
function parse_json(json) {
    try {
        var data = $.parseJSON(json);
    } catch(err) {
        throw "JSON parse error: " + json;
    }

    return data;
}