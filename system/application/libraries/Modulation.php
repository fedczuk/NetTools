<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * NetCalculations Tools
 *
 * Zestaw narzędzi wspomagających obliczenia dotyczące sieci.
 *
 * @package		NetCalculations Tools
 * @author		SFinX
 * @copyright	Copyright (c) 2009, SFinX
 * @license		GPLv3
 * @since		Version 0.3
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Szerokość jednego bitu.
 */ 
define('BIT_WIDTH', 30);

/**
 * Wysokość wygenerowanej grafiki.
 */ 
define('IMAGE_HEIGHT', 100);

/**
 * TODO: Nie pamiętam po jakie licho to jest.
 */ 
define('Y', 40);

/**
 * Najniższy poziom wykresu.
 */ 
define('MIN', 70);

/**
 * Najwyższy poziom wykresu.
 */ 
define('MAX', 10);

/**
 * NetCalculations Tools - LModulation Class
 *
 * Umożliwia wyrysowanie wykresu modulacji dla metod:
 * - nrz/nrzi,
 * - manchester/manchester inverted,
 * - mlt3.
 *
 * @package		NetCalculations Tools
 * @subpackage	Libraries
 * @category	Libraries
 * @author		SFinX
 */

class Modulation {

	/**
	 * Bity, które zostaną poddane wizualizacji
	 * w oparciu o daną metodę modulacji.
	 */ 
    var $_bits;
	
	/**
	 * Ilość bitów.
	 */ 
    var $_length;
	
	/**
	 * Przechowuje informację o metodzie modulacji.
	 */ 
	var $_type;
	
	/**
	 * Uchwyt do zasobu zawierającego nasz obrazek.
	 */ 
    var $_image = FALSE;
	
	/**
	 * Przechowuje informację o kolorze wykorzystywanym
	 * do rysowania wykresu modulacji.
	 */ 
    var $_red;
	
	/**
	 * Tworzy nową grafikę (czarne tło, biała siatka, nanosi
	 * wszystkie bity) przygotowaną do rysowania wykresu modulacji.
	 * 
	 * @param STRING $bits
	 * Bity, które zostaną poddane wizualizacji.
	 * 
	 * @param STRING $type
	 * Metoda modulacji.
	 */
    function set($bits, $type){
		if ($this->_image != FALSE)
			imagedestroy($this->_image);
		
        $this->_bits = $bits;
		$this->_type = $type;
        $this->_length = strlen($this->_bits);
		
        $width = BIT_WIDTH*$this->_length + 2*BIT_WIDTH;
        $this->_image = imagecreate($width, IMAGE_HEIGHT);
        $background = imagecolorallocate($this->_image, 0, 0, 0);
        
        $white = imagecolorallocate($this->_image, 255, 255, 255);
		$style = array(
			$white, 
			$white, 
			$white, 
			$white, 
			IMG_COLOR_TRANSPARENT, 
			IMG_COLOR_TRANSPARENT, 
			IMG_COLOR_TRANSPARENT, 
			IMG_COLOR_TRANSPARENT
		);

		imagesetstyle($this->_image, $style);
		imageline($this->_image, 0, 40, $width, 40, IMG_COLOR_STYLED);

		imagedashedline($this->_image, BIT_WIDTH, MAX, BIT_WIDTH, MIN, $white);
        for($i = 1; $i <= $this->_length; $i++){
            $x = $i*BIT_WIDTH;
            imagedashedline($this->_image, $x+BIT_WIDTH, MAX, $x+BIT_WIDTH, MIN, $white);
            imagechar($this->_image, 4, $x+12, 75, $this->_bits[$i-1], $white);
        }
		
        $this->_red = imagecolorallocate($this->_image, 255, 0, 0);
        imagesetthickness($this->_image, 2);
    }

	/**
	 * Wyrysowuje i wyświetla grafikę - wykres modulacji.
	 */ 
    function render(){
		header("Content-type: image/png");
		call_user_func(array($this, $this->_type));
        imagepng($this->_image);
        imagedestroy($this->_image);
    }

	/**
	 * Rysuje wykres modulacji dla metody NRZ/NRZI.
	 * 
	 * @param BOOL $inverted
	 * Domyślnie FALSE. Wartość TRUE oznacza, 
	 * że należy wyrysować wykres metody NRZI.
	 */ 
    function nrz($inverted = FALSE){
        for($i = 1; $i <= $this->_length; $i++){
			$x = $i*BIT_WIDTH;
			
			$one = ($this->_bits[$i-1] == '1');
			
			$y = ($one) ? MAX : MIN;
			if ($inverted)
				$y = ($one) ? MIN : MAX;
			
            imageline($this->_image, $x, $y, $x+BIT_WIDTH, $y, $this->_red);
			
            if (isset($this->_bits[$i]) && $this->_bits[$i-1] != $this->_bits[$i])
                imageline($this->_image, $x+BIT_WIDTH, MAX, $x+BIT_WIDTH, MIN, $this->_red);
        }
    }

	/**
	 * Rysuje wykres modulacji dla metody NRZI.
	 */ 
    function nrzi(){
		$this->nrz(TRUE);
    }
	
	/**
	 * Rysuje wykres modulacji dla metody Manchester/Manchester Inverted.
	 * 
	 * @param BOOL $inverted
	 * Domyślnie FALSE. Wartość TRUE oznacza, 
	 * że należy wyrysować wykres metody Manchester Inverted.
	 */
    function manchester($inverted = FALSE){
        $center = BIT_WIDTH/2;
        for($i = 1; $i <= $this->_length; $i++){
            $x = $i*BIT_WIDTH;
            
			$one = ($this->_bits[$i-1] == '1');
			$y1 = ($one) ? MAX : MIN;
			$y2 = ($one) ? MIN : MAX;
			
			if ($inverted){
				$y1 = ($one) ? MIN : MAX;
				$y2 = ($one) ? MAX : MIN;
			}

            imageline($this->_image, $x, $y1, $x+$center, $y1, $this->_red);
            imageline($this->_image, $x+$center, MAX, $x+$center, MIN, $this->_red);
            imageline($this->_image, $x+$center, $y2, $x+BIT_WIDTH, $y2, $this->_red);
            
            if (isset($this->_bits[$i]) && $this->_bits[$i-1] == $this->_bits[$i])
                imageline($this->_image, $x+BIT_WIDTH, MAX, $x+BIT_WIDTH, MIN, $this->_red);
        }
    }

	/**
	 * Rysuje wykres modulacji dla metody Manchester Inverted.
	 */
    function manchesteri(){
		$this->manchester(TRUE);
    }

	/**
	 * Rysuje wykres modulacji dla metody MLT3.
	 */
    function mlt3(){
        $top = FALSE;
        $y1 = MIN;
        $y2 = Y;
		
        for($i = 1; $i <= $this->_length; $i++){
            $x = $i*BIT_WIDTH;

            if ($this->_bits[$i-1] == '1'){
                if (!$top){
					$max = ($y2 == MAX);
					$y2 = ($max) ? Y : MAX;
					$y1 = ($max) ? MAX : Y;
					if ($max) $top = true;
                }
                else {
					$min = ($y2 == MIN);
					$y2 = ($min) ? Y : MIN;
					$y1 = ($min) ? MIN : Y;
					if ($min) $top = false;
                }
				
                imageline($this->_image, $x, $y1, $x, $y2, $this->_red);
                imageline($this->_image, $x, $y2, $x+BIT_WIDTH, $y2, $this->_red);
            }
            else {
                imageline($this->_image, $x, $y2, $x+BIT_WIDTH, $y2, $this->_red);
            }
        }
    }
}

?>
