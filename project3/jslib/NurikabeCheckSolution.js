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