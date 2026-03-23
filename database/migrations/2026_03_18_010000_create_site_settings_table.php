<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\SiteSetting;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, number, boolean, array, json
            $table->string('group')->default('general'); // general, branding, locale, booking, fees, social, seo
            $table->timestamps();
            
            $table->index('group');
        });

        // Seed default settings
        $this->seedDefaultSettings();
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }

    private function seedDefaultSettings(): void
    {
        $defaults = SiteSetting::defaults();
        
        foreach ($defaults as $key => $config) {
            $value = $config[0];
            $type = $config[1] ?? 'string';
            $group = $config[2] ?? 'general';
            
            // Store array values as JSON
            if (is_array($value)) {
                $value = json_encode($value);
            }
            
            SiteSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'type' => $type,
                    'group' => $group
                ]
            );
        }
    }
};
