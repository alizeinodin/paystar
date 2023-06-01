<?php

use App\Models\CreditCard;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount');
            $table->string('ref_num');
            $table->string('status')->default('pending');
            $table->string('transaction_id')->nullable();
            $table->string('tracking_code')->nullable();
            $table->foreignIdFor(CreditCard::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
