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