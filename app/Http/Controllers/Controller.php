<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    protected $activationFee = 3000;

    protected $referralBonus = 1000;

    protected $adminPayment = 500;


    protected $level1Payment = 1500;
    protected $level2Payment = 2500;
    protected $level3Payment = 5000;
    protected $level4Payment = 16000;
    protected $level5Payment = 56000;
    protected $level6Payment = 350000;

    /**
     * Get the payment amount required for a specific level.
     * This centralizes the payment logic as suggested in README.md.
     * Level 1 is considered the activation fee.
     *
     * @param int $level
     * @return int
     * @throws \InvalidArgumentException
     */
    protected function getPaymentForLevel(int $level): int
    {
        $payments = [
            1 => $this->activationFee,
            2 => $this->level2Payment,
            3 => $this->level3Payment,
            4 => $this->level4Payment,
            5 => $this->level5Payment,
            6 => $this->level6Payment,
        ];

        if (!isset($payments[$level])) {
            throw new \InvalidArgumentException("Invalid payment level requested: {$level}");
        }

        return $payments[$level];
    }
}
