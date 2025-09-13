<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Project;
use App\Models\MaterialTransaction;
use App\Models\MaterialTransactionItem;
use Illuminate\Support\Facades\Auth;

// Tambahkan use statement ini
use Livewire\Attributes\Url; // Untuk Livewire v3
// Jika menggunakan Livewire v2, gunakan: use Livewire\WithPagination; dan protected $queryString;

class LogisticPurchase extends Component
{
    use WithFileUploads;

    // Definisikan properti yang bisa diisi dari URL query string (Livewire v3)
    #[Url]
    public $project = null; // Akan secara otomatis diisi dari ?project=ID di URL

    public $projects;
    public $selectedProjectId; // Properti yang digunakan di form
    public $storeName;
    public $transactionDate;
    public $items = [];
    public $newItem = [
        'item_description' => '',
        'unit' => '',
        'quantity' => 0,
        'unit_price' => 0,
        'discount_amount' => 0,
    ];
    public $receiptPhoto;

    protected $rules = [
        'selectedProjectId' => 'required|exists:projects,id',
        'storeName' => 'required|string|max:255',
        'transactionDate' => 'required|date',
        // Rules untuk newItem (saat menambahkan item)
        'newItem.item_description' => 'required|string|max:255',
        'newItem.unit' => 'required|string|max:50',
        'newItem.quantity' => 'required|numeric|min:0',
        'newItem.unit_price' => 'required|numeric|min:0',
        'newItem.discount_amount' => 'nullable|numeric|min:0',
        'receiptPhoto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    public function mount()
    {
        $this->projects = Project::all();
        $this->transactionDate = now()->format('Y-m-d');

        // Periksa apakah ada parameter 'project' di URL
        if ($this->project && $this->projects->contains('id', $this->project)) {
            // Jika ada dan valid, set selectedProjectId secara otomatis
            $this->selectedProjectId = $this->project;
        } else {
            $this->selectedProjectId = null; // Biarkan user pilih
        }
    }

    public function render()
    {
        return view('livewire.logistic-purchase');
    }

    public function addItem()
    {
        $this->validate([
            'newItem.item_description' => 'required|string|max:255',
            'newItem.unit' => 'required|string|max:50',
            'newItem.quantity' => 'required|numeric|min:0',
            'newItem.unit_price' => 'required|numeric|min:0',
            'newItem.discount_amount' => 'nullable|numeric|min:0',
        ], [
            // Array pesan kustom - kunci: 'field.rule'
            'newItem.item_description.required' => 'Nama Item harus diisi.', // <-- Pesan khusus
            'newItem.item_description.max' => 'Nama Item maksimal 255 karakter.',
            'newItem.unit.required' => 'Satuan harus diisi.',
            'newItem.quantity.required' => 'Qty harus diisi.',
            'newItem.unit_price.required' => 'Harga Satuan harus diisi.',
            // Tambahkan pesan lain sesuai kebutuhan
        ]);

        $totalPrice = ($this->newItem['quantity'] * $this->newItem['unit_price']) - ($this->newItem['discount_amount'] ?? 0);

        $this->items[] = [
            'id' => uniqid(), // temporary ID for frontend
            'item_description' => $this->newItem['item_description'],
            'unit' => $this->newItem['unit'],
            'quantity' => (float) $this->newItem['quantity'],
            'unit_price' => (float) $this->newItem['unit_price'],
            'discount_amount' => (float) ($this->newItem['discount_amount'] ?? 0),
            'total_price' => (float) $totalPrice,
        ];

        // Reset form
        $this->newItem = [
            'item_description' => '',
            'unit' => '',
            'quantity' => 0,
            'unit_price' => 0,
            'discount_amount' => 0,
        ];

        $this->dispatch('item-added');
    }

    public function removeItem($itemId)
    {
        $this->items = array_filter($this->items, fn($item) => $item['id'] !== $itemId);
        $this->items = array_values($this->items); // reindex
    }

    public function savePurchase()
    {
        // 1. Validasi data header transaksi
        // $validatedData = $this->validate(); // Ini memvalidasi selectedProjectId, storeName, dll.

        // 2. Validasi setiap item dalam array $this->items
        // Cek apakah ada item yang ditambahkan
        if (empty($this->items)) {
            // Jika tidak ada item, tampilkan pesan error
            $this->addError('items', 'Harap tambahkan minimal satu item belanja.');
            return; // Hentikan proses simpan
        }

        // Validasi setiap item
        $itemErrors = [];
        foreach ($this->items as $index => $item) {
            // Buat validator untuk setiap item
            $validator = \Illuminate\Support\Facades\Validator::make($item, [
                'item_description' => 'required|string|max:255',
                'unit' => 'required|string|max:50',
                'quantity' => 'required|numeric|min:0',
                'unit_price' => 'required|numeric|min:0',
                'discount_amount' => 'nullable|numeric|min:0',
                'total_price' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                // Kumpulkan error dari setiap item yang tidak valid
                // Anda bisa pilih cara menampilkan error ini, misalnya:
                // - Tampilkan error umum: "Ada item yang tidak valid"
                // - Tampilkan error spesifik untuk setiap item (lebih kompleks)
                // Untuk saat ini, kita tambahkan error umum.
                $itemErrors[] = "Item baris " . ($index + 1) . " tidak valid.";
                // Atau tambahkan error ke session/flash message
                // session()->flash('error', 'Item baris ' . ($index + 1) . ' tidak valid.');
            }
        }

        // Jika ada error pada item, hentikan proses
        if (!empty($itemErrors)) {
            // Tambahkan error ke properti error Livewire
            $this->addError('items', 'Ada item yang tidak valid: ' . implode(', ', $itemErrors));
            // Atau gunakan flash message
            // session()->flash('error', 'Ada item yang tidak valid. Silakan periksa kembali.');
            return;
        }

        try {
            // 3. Simpan data transaksi header (MaterialTransaction)
            $transaction = MaterialTransaction::create([
                'project_id' => $this->selectedProjectId,
                'store_name' => $this->storeName,
                'transaction_date' => $this->transactionDate,
                'receipt_photo' => null, // Akan diupdate setelah upload
            ]);

            // 4. Upload foto nota (jika ada) dan update path ke header
            if ($this->receiptPhoto) {
                $path = $this->receiptPhoto->store('receipts', 'public'); // Sesuaikan disk jika perlu
                $transaction->update(['receipt_photo' => $path]);
            }

            // 5. Simpan setiap item belanja (MaterialTransactionItem)
            foreach ($this->items as $item) {
                MaterialTransactionItem::create([
                    'material_transaction_id' => $transaction->id,
                    'item_description' => $item['item_description'],
                    'unit' => $item['unit'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'discount_amount' => $item['discount_amount'] ?? 0,
                    'total_price' => $item['total_price'],
                ]);
            }

            // 6. Reset form atau beri pesan sukses
            $this->reset(['selectedProjectId', 'storeName', 'transactionDate', 'items', 'receiptPhoto']);
            // Reset newItem ke default
            $this->newItem = [
                'item_description' => '',
                'unit' => '',
                'quantity' => 0,
                'unit_price' => 0,
                'discount_amount' => 0,
            ];
            session()->flash('success', 'Transaksi belanja berhasil disimpan.');

        } catch (\Exception $e) {
            // Tangani error
            session()->flash('error', 'Terjadi kesalahan saat menyimpan transaksi: ' . $e->getMessage());
            // \Log::error('Error saving purchase: ' . $e->getMessage());
        }
    }

    // Method untuk mengupdate storeName ketika proyek dipilih
    public function updatedSelectedProjectId()
    {
        // Opsional: auto-fill store name berdasarkan proyek
        $project = Project::find($this->selectedProjectId);
        if ($project && $project->default_store) {
            $this->storeName = $project->default_store;
        } else {
            // Kosongkan jika tidak ada default
            $this->storeName = '';
        }
    }

}
