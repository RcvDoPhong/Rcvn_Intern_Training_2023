<?php

declare(strict_types=1);

use Elastic\Adapter\Indices\Mapping;
use Elastic\Adapter\Indices\Settings;
use Elastic\Migrations\Facades\Index;
use Elastic\Migrations\MigrationInterface;

final class CreateIndexProduct implements MigrationInterface
{
    /**
     * Run the migration.
     */
    public function up(): void
    {
        Index::createIfNotExists('index-products', function (Mapping $mapping, Settings $settings) {
            $mapping->long('product_id');
            $mapping->long('parent_product_id', ['null_value' => 0]);
            $mapping->text('product_name', ['boost' => 2]);
            $mapping->unsigned_long('category_id');
            $mapping->unsigned_long('brand_id');
            $mapping->float('base_price');
            $mapping->text('product_description');
            $mapping->text('brief_description');
            $mapping->byte('status');
            $mapping->byte('is_delete');
            $mapping->byte('is_sale');
            $mapping->unsigned_long('updated_by');
            $mapping->date('created_at');
            $mapping->date('updated_at');
        });

        Index::putAlias('index-products', 'products');
    }

    /**
     * Reverse the migration.
     */
    public function down(): void
    {
        Index::dropIfExists('index-products');
    }
}
