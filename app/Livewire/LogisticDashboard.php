<?php

namespace App\Livewire;

use App\Models\MaterialTransaction;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class LogisticDashboard extends Component
{
    public $totalTransactions;
    public $totalSpent;
    public $monthlyTransactions;
    public $recentTransactions;

    public function mount()
    {
        // 1. Hitung total semua transaksi
        $this->totalTransactions = MaterialTransaction::count();

        // 2. Hitung total pengeluaran dari semua item transaksi
        $this->totalSpent = MaterialTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)->join('material_transaction_items', 'material_transactions.id', '=', 'material_transaction_items.material_transaction_id')
            ->sum('material_transaction_items.total_price');

        // 3. Hitung transaksi bulan ini (tanpa filter user)
        $this->monthlyTransactions = MaterialTransaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->count();

        // Tambahkan logika untuk mengambil 5 transaksi terakhir
        $this->recentTransactions = MaterialTransaction::with(['project', 'items'])
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                $total = $transaction->items->sum('total_price');
                $transaction->total_formatted = 'Rp ' . number_format($total, 0, ',', '.');
                return $transaction;
            });
    }

    public function render()
    {
        return view('livewire.logistic-dashboard');
    }
}