<?php
    $pieceTypes=Array(
        'K' => new PieceType(
            'King',
            'K',
            Array(
                new PieceMove(0+1,0*1,'','',''),
                new PieceMove(0+1,0+1,'','',''),
                new PieceMove(0*1,0+1,'','',''),
                new PieceMove(0-1,0+1,'','',''),
                new PieceMove(0-1,0*1,'','',''),
                new PieceMove(0-1,0-1,'','',''),
                new PieceMove(0*1,0-1,'','',''),
                new PieceMove(0+1,0-1,'','','')
                //NEEDS BOTH CASTLES...
        ),
        ' ' => new PieceType(
            'Pawn',
            ' ',
            Array(
                new PieceMove(0-1,0+1,Array(0-1,0+1),,),
                new PieceMove(0+1,0+1,Array(0+1,0+1),,),
                new PieceMove(0-1,0+1,Array(0-1,0+1),,)
                //INSERT THE EN PASSENT
            )
        ),
        'C' => new PieceType(
            'King Checker'
            'C',
            Array(
                new PieceMove(0+1,0+1,Array(0+1,0+1),Array(0+2,0+2),Array(0+1,0+1)),
                new PieceMove(0-1,0+1,Array(0-1,0+1),Array(0-2,0+2),Array(0-1,0+1)),
                new PieceMove(0+1,0-1,Array(0+1,0-1),Array(0+2,0-2),Array(0+1,0-1)),
                new PieceMove(0-1,0-1,Array(0-1,0-1),Array(0-2,0-2),Array(0-1,0-1))
            )
        )
        'P' => new PieceType(
            'Checker'
            'P',
            Array(
                new PieceMove(0+1,0+1,Array(0+1,0+1),Array(0+2,0+2),Array(0+1,0+1)),
                new PieceMove(0-1,0+1,Array(0-1,0+1),Array(0-2,0+2),Array(0-1,0+1))
            )
        )
    );
?>