<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('sub_materis', function (Blueprint $table) {
            $table->string('title')->after('materi_id');
            $table->string('subtitle')->nullable()->after('title');
            $table->string('author')->nullable()->after('subtitle');
            $table->string('thumbnail')->nullable()->after('author');
            $table->string('meta_title')->nullable()->after('thumbnail');
            $table->text('meta_description')->nullable()->after('meta_title');
            $table->boolean('is_published')->default(true)->after('meta_description');
        });
    }

    public function down(): void
    {
        Schema::table('sub_materis', function (Blueprint $table) {
            $table->dropColumn([
                'title',
                'subtitle',
                'author',
                'thumbnail',
                'meta_title',
                'meta_description',
                'is_published',
            ]);
        });
    }
};
