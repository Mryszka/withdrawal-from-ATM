<?php declare(strict_types = 1);

namespace Withdrawal\Calculators;

class PayoutCalculator {
    
   public function calculatePayout(int $sum, array $banknotes): array 
   {
       rsort($banknotes);
       $iterator = 0;
       $result = [];
       $unpaydAmound = $sum;
       $banknote = $banknotes[$iterator];
       
       while ($unpaydAmound > 0)
       {
           if ($unpaydAmound < $banknote){
               $iterator++;
               $banknote = $banknotes[$iterator];
           } else {
               $result[] = $banknote;
               $unpaydAmound -= $banknote;
           }
       }
       
       return $result;
   }
}
