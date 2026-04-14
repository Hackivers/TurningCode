<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Performance indexes untuk mempercepat query yang sering dijalankan.
     */
    public function up(): void
    {
        // UserHistory: query paling sering = WHERE user_id + pluck sub_materi_id + ORDER BY viewed_at
        Schema::table('user_histories', function (Blueprint $table) {
            // Composite index untuk dashboard progress & history page
            if (!$this->hasIndex('user_histories', 'user_histories_user_sub_viewed_index')) {
                $table->index(['user_id', 'sub_materi_id', 'viewed_at'], 'user_histories_user_sub_viewed_index');
            }
        });

        // UserFavorite: query WHERE user_id + favoritable_type + favoritable_id
        Schema::table('user_favorites', function (Blueprint $table) {
            if (!$this->hasIndex('user_favorites', 'user_favorites_user_type_id_index')) {
                $table->index(['user_id', 'favoritable_type', 'favoritable_id'], 'user_favorites_user_type_id_index');
            }
        });

        // StudySchedule: query WHERE user_id + is_active + ORDER BY start_time
        Schema::table('study_schedules', function (Blueprint $table) {
            if (!$this->hasIndex('study_schedules', 'study_schedules_user_active_start_index')) {
                $table->index(['user_id', 'is_active', 'start_time'], 'study_schedules_user_active_start_index');
            }
        });

        // SubMateri: query WHERE materi_id + is_published
        Schema::table('sub_materis', function (Blueprint $table) {
            if (!$this->hasIndex('sub_materis', 'sub_materis_materi_published_index')) {
                $table->index(['materi_id', 'is_published'], 'sub_materis_materi_published_index');
            }
        });
    }

    public function down(): void
    {
        Schema::table('user_histories', function (Blueprint $table) {
            $table->dropIndex('user_histories_user_sub_viewed_index');
        });

        Schema::table('user_favorites', function (Blueprint $table) {
            $table->dropIndex('user_favorites_user_type_id_index');
        });

        Schema::table('study_schedules', function (Blueprint $table) {
            $table->dropIndex('study_schedules_user_active_start_index');
        });

        Schema::table('sub_materis', function (Blueprint $table) {
            $table->dropIndex('sub_materis_materi_published_index');
        });
    }

    private function hasIndex(string $table, string $indexName): bool
    {
        try {
            $indexes = Schema::getIndexes($table);
            foreach ($indexes as $index) {
                if ($index['name'] === $indexName) {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            // Fallback: try to create, will fail gracefully if exists
        }
        return false;
    }
};
