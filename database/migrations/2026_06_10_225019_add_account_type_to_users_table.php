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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('account_type', ['student', 'recruiter'])->default('student')->after('is_admin');
            $table->string('company_name')->nullable()->after('account_type');
            $table->string('badge_path')->nullable()->after('company_name');
            $table->enum('recruiter_status', ['pending', 'approved', 'rejected'])->nullable()->after('badge_path');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['account_type', 'company_name', 'badge_path', 'recruiter_status']);
        });
    }
};
