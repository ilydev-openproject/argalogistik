<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('material_transactions', function (Blueprint $table) {
            // Hapus kolom item yang seharusnya pindah ke tabel items
            $table->dropColumn([
                'item_description',
                'unit',
                'quantity',
                'unit_price',
                'discount_amount',
                'total_price',
            ]);
        });

        // Buat tabel material_transaction_items
        Schema::create('material_transaction_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_transaction_id')
                ->constrained('material_transactions')
                ->onDelete('cascade');
            $table->string('item_description');
            $table->string('unit');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0);
            $table->decimal('total_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_transaction_items');

        // Tambahkan kembali kolom yang dihapus
        Schema::table('material_transactions', function (Blueprint $table) {
            $table->string('item_description');
            $table->string('unit');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2);
        });
    }
};
