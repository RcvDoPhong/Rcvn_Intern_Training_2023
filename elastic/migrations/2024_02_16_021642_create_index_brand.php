<?php
declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateIndexBrand implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::create('brands', function (Mapping $mapping, Settings $settings) {
            $mapping->unsigned_long('brand_id');
            $mapping->text('brand_name', ['boost' => 2]);
            $mapping->date('founded');
            $mapping->byte('is_active');
            $mapping->byte('is_delete');
            $mapping->unsigned_long('updated_by');
            $mapping->date('created_at');
            $mapping->date('updated_at');
        });
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('brands');
    }
}
