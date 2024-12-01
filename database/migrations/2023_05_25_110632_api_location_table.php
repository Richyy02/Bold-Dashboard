<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('api_locations', function (Blueprint $table) {
            $table->id();
            $table->string("uri");
            $table->string("api_key");
            $table->string("slug")->unique();
            $table->string("name")->unique();
            $table->timestamp("created_at")->useCurrent();
            $table->timestamp("updated_at")->useCurrent()->useCurrentOnUpdate();

//            $table->foreignIdFor(User::class)
//                ->constrained()
//                ->onUpdate('cascade')
//                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('api_locations');
    }
};
