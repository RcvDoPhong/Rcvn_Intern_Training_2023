<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateIndexRole implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('index-roles', function (Mapping $mapping, Settings $settings) {
            $mapping->unsigned_long('role_id');
            $mapping->text('role_name', ['boost' => 2]);
            $mapping->byte('is_delete');
            $mapping->date('created_at');
            $mapping->date('updated_at');
            $mapping->unsigned_long('updated_by');
        });

        Index::putAlias('index-roles', 'roles');
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('index-roles');
    }
}
