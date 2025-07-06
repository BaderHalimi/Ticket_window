<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PaysHistory;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class Reports extends Component
{
    public $startDate;
    public $endDate;
    public $pays;

    public function mount()
    {
        $this->startDate = Carbon::now()->subMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
        $this->loadPays();
    }

    public function updated($property)
    {
        if (in_array($property, ['startDate', 'endDate'])) {
            $this->loadPays();
        }
    }

    public function loadPays()
    {
        $this->pays = PaysHistory::with(['user', 'item'])
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59'])
            ->get();
    }

    public function render()
    {
        // تحليل additional_data
        $parsed = $this->pays->map(function ($pay) {
            $add = $pay->additional_data;
            $pay->typeInAdditional = $add['type'] ?? 'pay';
            $pay->couponCode = $add['coupon_code'] ?? null;
            $pay->note = $add['notes'] ?? null;
            return $pay;
        });

        // إجمالي الدفع
        $totalPay = $parsed->where('typeInAdditional', 'pay')->sum('amount');
        $totalRefund = $parsed->where('typeInAdditional', 'refund')->sum('amount');
        $netSales = $totalPay - $totalRefund;

        // الخصومات من الكوبونات
        $couponLoss = $parsed->where('couponCode', '!=', '')->sum('amount');

        // توزيع حسب المنتج
        $salesByProduct = $parsed
            ->where('typeInAdditional', 'pay')
            ->groupBy('item.name')
            ->map(fn($group) => $group->sum('amount'));

        // طرق الدفع
        $countByPaymentMethod = $parsed
            ->where('typeInAdditional', 'pay')
            ->groupBy('payment_method')
            ->map(fn($group) => $group->count());

        // الحالات
        $countByStatus = $parsed
            ->groupBy('status')
            ->map(fn($group) => $group->count());

        // أفضل العملاء
        $topUsers = $parsed
            ->where('typeInAdditional', 'pay')
            ->groupBy('user.f_name')
            ->map(fn($group) => $group->sum('amount'))
            ->sortDesc()
            ->take(5);

        // المبيعات اليومية مع الملاحظات
        $dailySales = $parsed
            ->where('typeInAdditional', 'pay')
            ->groupBy(fn($item) => $item->created_at->format('Y-m-d'))
            ->map(function ($group) {
                return [
                    'total' => $group->sum('amount'),
                    'notes' => $group->pluck('note')->filter()->values()->all(),
                ];
            })
            ->sortKeys();

        return view('livewire.reports', [
            'netSales' => $netSales,
            'totalPay' => $totalPay,
            'totalRefund' => $totalRefund,
            'couponLoss' => $couponLoss,
            'salesByProduct' => $salesByProduct,
            'countByPaymentMethod' => $countByPaymentMethod,
            'countByStatus' => $countByStatus,
            'topUsers' => $topUsers,
            'dailySales' => $dailySales,
        ]);
    }
}
