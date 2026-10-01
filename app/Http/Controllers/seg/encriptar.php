<?php

namespace App\Http\Controllers\seg;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Encriptacion de informacion 

class encriptar extends Controller
{
    public $CHAR_RANGE = 126 - 32 + 1;
    function shiftChar($char, $shift)
   {
       $charCode = ord($char);  // Obtener el código ASCII del carácter
       $newCharCode = (($charCode - 32 + $shift + $this->CHAR_RANGE) % $this->CHAR_RANGE) + 32;
       return chr($newCharCode); // Convertir el código ASCII de vuelta a carácter
   }
   function shiftText($text, $shift)
   {
       $result = array_map(function($char) use ($shift) {
           return $this->shiftChar($char, $shift);
       }, str_split($text));

       return implode('', $result);
   }
   
}
