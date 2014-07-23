<?php
    abstract class GamePiece {
        private $name;
        private $position;
        private $pieceType;
        private $theGameBoard;
        private $fromWhite=TRUE;//pieces have a default orientation of coming from the white side   
        private $isWhite=TRUE;    
        function __construct(&$pieceType,$board,$isWhite,$fromWhite,$position=Array(0,0)){
            $this->position=$position;
            
        }
        function getPieceType();
        function getAvailableMoves();
        function __toString(){
            
            
        }
        static public $shorthand;
    } 
    class ChessKing extends GamePiece{
        private $canCastle;
        function isInCheck(){
            
        }
        function checkForCheck(){
            $this->theGameBoard
        }
    }
    class ChessKnight extends GamePiece {
        static 
    }
    class PieceType {
        public $moveSet=Array();
        public $name='';
        public $shortHand;
        function __construct($name,$shortHand,$moveSet){
            $this->moveSet=$moveSet;
            $this->name=$name;
            $this->shortHand=$shortHand;
        }
    }
    class PieceMove {
       
        //Will have a way to account for pieces being rec
        public $piecesAt=Array();
        public $noPiecesAt=Array();
        public $forwardMovement;
        public $lateralMovement;
        public $takesPiecesAt=Array();
        function toString(){
        }
        function __construct($lateral,$forward, $piecesAt=Array(),$noPiecesAt=Array(),$takesPiecesAt=Array()){
            $this->piecesAt=$piecesAt;
            $this->lateralMovement=$lateral;
            $this->forwardMovement=$forward;
            $this->noPiecesAt=$noPiecesAt;
            $this->takesPiecesAt=$takesPiecesAt;
        } 
        function isValid($board,GamePiece $piece){
            $board
            
        }
    }

    $pieceTypes=Array(
        'K' => new PieceType(
            'King',
            'K',
            Array(
                new PieceMove(0+1,0*1),
                new PieceMove(0+1,0+1),
                new PieceMove(0*1,0+1),
                new PieceMove(0-1,0+1),
                new PieceMove(0-1,0*1),
                new PieceMove(0-1,0-1),
                new PieceMove(0*1,0-1),
                new PieceMove(0+1,0-1)
                //NEEDS BOTH CASTLES...
        ),
        ' ' => new PieceType(
            'Pawn',
            ' ',
            Array(
                new PieceMove(0-1,0+1,Array(0-1,0+1)),
                new PieceMove(0+1,0+1,Array(0+1,0+1)),
                new PieceMove(0-1,0+1,Array(0-1,0+1))
                //INSERT THE EN PASSENT
            )
        ),
        'C' => new PieceType(
            'King Checker'
            'C',
            Array(
                new PieceMove(0+2,0+2,Array(0+1,0+1),Array(0+2,0+2),Array(0+1,0+1)),
                new PieceMove(0-2,0+2,Array(0-1,0+1),Array(0-2,0+2),Array(0-1,0+1)),
                new PieceMove(0+2,0-2,Array(0+1,0-1),Array(0+2,0-2),Array(0+1,0-1)),
                new PieceMove(0-2,0-2,Array(0-1,0-1),Array(0-2,0-2),Array(0-1,0-1)),
                new PieceMove(0+1,0+1,Array(),Array(0+1,0+1),Array()),
                new PieceMove(0-1,0+1,Array(),Array(0-1,0+1),Array()),
                new PieceMove(0+1,0-1,Array(),Array(0+1,0-1),Array()),
                new PieceMove(0-1,0-1,Array(),Array(0-1,0-1),Array())
            )
        ),
        'P' => new PieceType(
            'Checker'
            'P',
            Array(
                new PieceMove(0+2,0+2,Array(0+1,0+1),Array(0+2,0+2),Array(0+1,0+1)),
                new PieceMove(0-2,0+2,Array(0-1,0+1),Array(0-2,0+2),Array(0-1,0+1)),
                new PieceMove(0+1,0+1,'',Array(0+1,0+1),''),
                new PieceMove(0-1,0+1,'',Array(0-1,0+1),'')
            )
        ),
        'N' => new PieceType(
            'Knight',
            'N',
            Array(
                new PieceMove(0+1,0+2),
                new PieceMove(0+2,0+1),
                new PieceMove(0+2,0-1),
                new PieceMove(0+1,0-2),
                new PieceMove(0-1,0-2),
                new PieceMove(0-2,0-1),
                new PieceMove(0-2,0+1),
                new PieceMove(0-2,0+1)
            )
        ),
        
        
        
        
        
        )
    );
    
    
    
    
?>