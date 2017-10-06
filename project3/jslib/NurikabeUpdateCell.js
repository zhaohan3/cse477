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