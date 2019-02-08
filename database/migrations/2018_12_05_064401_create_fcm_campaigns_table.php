<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_campaigns', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->string('description')->nullable();

            $table->string('condition')->nullable();
            $table->string('collapse_key')->nullable();
            $table->string('priority')->nullable();
            $table->boolean('content_available')->nullable(); // ios only
            $table->boolean('mutable_content')->nullable(); // ios only
            $table->integer('time_to_live')->nullable();
            $table->string('restricted_package_name')->nullable();
            $table->boolean('dry_run')->default(false);
            $table->text('data')->nullable();

            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->string('android_channel_id')->nullable(); // android only
            $table->string('icon')->nullable(); // android only
            $table->string('badge')->nullable(); // ios only
            $table->string('sound')->nullable();
            $table->string('tag')->nullable();
            $table->string('color')->nullable();
            $table->string('click_action')->nullable();
            $table->string('body_loc_key')->nullable();
            $table->text('body_loc_args')->nullable();
            $table->string('title_loc_key')->nullable();
            $table->text('title_loc_args')->nullable();

            $table->enum('status', [
                'Pending',
                'Sending',
                'Sent',
                'Cancelled',
                'Failed',
            ])->default('Pending')->nullable();

            $table->timestamp('sent_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();

            $table->nullableTimestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fcm_campaigns');
    }
}
