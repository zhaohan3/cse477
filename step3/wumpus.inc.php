<?php
/**
 * Create an array that represents the cave
 * @returns Array
 */
function cave_array() {
    $cave = array(1 => array(5, 6, 2),
        2 => array(1, 8, 3),
        3 => array(2,10,4),
        4 => array(3,12,5),
        5 => array(4,14,1),
        6 => array(1,15,7),
        7 => array(6,8,16),
        8 => array(2,7,9),
        9 => array(8,17,10),
        10 => array(9,11,3),
        11 => array(18,12,10),
        12 => array(11,13,4),
        13 => array(12,19,14),
        14 => array(5,15,13),
        15 => array(14,6,20),
        16 => array(7,20,17),
        17 => array(16,9,18),
        18 => array(17,11,19),
        19 => array(18,13,20),
        20 => array(19,15,16)
    );
    return $cave;
}