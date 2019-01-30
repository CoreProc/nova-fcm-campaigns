<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFcmCampaignDeviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fcm_campaign_device', function (Blueprint $table) {
            $table->integer('fcm_campaign_id', false, true)->nullable();
            $table->foreign('fcm_campaign_id')->references('id')->on('fcm_campaigns')->onDelete('set null');

            $table->integer('device_id', false, true)->nullable();
            $table->foreign('device_id')->references('id')->on('devices')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fcm_campaign_device', function (Blueprint $table) {
            $table->dropForeign(['fcm_campaign_id']);
            $table->dropForeign(['device_id']);
        });
        Schema::dropIfExists('fcm_campaign_device');
    }
}
