<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('store_id')->constrained('stores')->onDelete('cascade');
            $table->date('visit_date');
            $table->string('status')->default('Direncanakan'); // Direncanakan, Selesai, Dibatalkan
            $table->string('result_status')->nullable(); // Berhasil, Tutup, Ditolak
            $table->dateTime('check_in_time')->nullable();
            $table->decimal('order_value', 15, 2)->default(0.00);
            $table->text('fail_reason')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('simulated_latitude', 10, 7)->nullable();
            $table->decimal('simulated_longitude', 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
