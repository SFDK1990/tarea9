<?php
	class Mate{
    /**	
     * @param float $base
	 * @param float $exponente
     * @return float $resul
     */
    public function potencia($base, $exponente)
    {
        return pow($base, $exponente);
    }
        /**	
     * @param float $op1
	 * @param float $op2
     * @return float $resul
     */
	public function suma($op1, $op2)
    {
        return $op1 + $op2;
    }
}
