<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planners', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class);
            $table->char('monday')->default('0');
            $table->char('tuesday')->default('0');
            $table->char('wednesday')->default('0');
            $table->char('thursday')->default('0');
            $table->char('friday')->default('0');
            $table->char('saturday')->default('0');
            $table->char('sunday')->default('0');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planners');
    }
}
