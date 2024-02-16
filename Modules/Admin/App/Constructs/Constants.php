<?php

namespace Modules\Admin\App\Constructs;

class Constants
{
    const PER_PAGE = 5;

    const DESTROY = 1;

    const NOT_DESTROY = 0;

    const APPROVED = 1;

    const NOT_APPROVED = 0;

    const ADMIN_NON_ACTIVE = 0;

    const ADMIN_ACTIVE = 1;

    const CATEGORY_HIERARCHY = [
        [
            'id' => 0,
            'name' => 'Parent'
        ],
        [
            'id' => 1,
            'name' => 'Child'
        ]
    ];

    const PAYMENT_LIST = [
        [
            'id' => 0,
            'name' => 'COD'
        ],
        [
            'id' => 1,
            'name' => 'Banking'
        ]
    ];

    const GENDERS = [
        [
            'id' => 0,
            'name' => 'Female'
        ],
        [
            'id' => 1,
            'name' => 'Male'
        ]
    ];

    const ACTIVE_LIST = [
        [
            'id' => 0,
            'name' => 'Locked'
        ],
        [
            'id' => 1,
            'name' => 'Active'
        ]
    ];

    const PRODUCT_STATUS = [
        [
            'id' => 0,
            'name' => 'Stop selling'
        ],
        [
            'id' => 1,
            'name' => 'Selling'
        ],
        [
            'id' => 2,
            'name' => 'Out of stock'
        ]
    ];

    const PRODUCT_PRICE_TYPE = [
        [
            'id' => 0,
            'name' => 'Plain price'
        ],
        [
            'id' => 1,
            'name' => 'Percent price'
        ],
    ];

    const VENDOR_AREA_SUPPORT = [
        [
            'id' => 0,
            'name' => 'All areas'
        ],
        [
            'id' => 1,
            'name' => 'Selected areas'
        ]
    ];

    const APPROVE_LIST = [
        [
            'id' => self::NOT_APPROVED,
            'name' => 'Pending'
        ],
        [
            'id' => self::APPROVED,
            'name' => 'Approved'
        ]
    ];

    const DASHBOARD_FIELDS = [
        'orders' => [
            'table' => 'orders',
            'func' => 'count',
            'field' => '*'
        ],
        'totalPrice' => [
            'table' => 'orders',
            'func' => 'sum',
            'field' => 'total_price',
            'alias' => 'totalPrice'
        ],
        'users' => [
            'table' => 'users',
            'func' => 'count',
            'field' => '*'
        ],
        'reviews' => [
            'table' => 'reviews',
            'func' => 'count',
            'field' => '*'
        ]
    ];

    const PERMISSION_GROUP = [
        'admin' => [
            'admin.view',
            'admin.create',
            'admin.update',
            'admin.delete',
        ],
        'role' => [
            'role.view',
            'role.create',
            'role.update',
            'role.delete'
        ],
        'brand' => [
            'brand.view',
            'brand.create',
            'brand.update',
            'brand.delete',
        ],
        'category' => [
            'category.view',
            'category.create',
            'category.update',
            'category.delete',
        ],
        'product' => [
            'product.view',
            'product.create',
            'product.update',
            'product.delete',
        ],
        'vendor' => [
            'vendor.view',
            'vendor.create',
            'vendor.update',
            'vendor.delete',
        ],
        'order' => [
            'order.view',
            'order.update',
        ],
        'customer' => [
            'customer.view',
            'customer.update',
            'customer.delete',
        ],
        'review' => [
            'review.view',
            'review.update',
        ]
    ];

    const PERMISSION_LISTS = [
        [
            'permission' => 'admin.view',
            'page' => 'View Admins'
        ],
        [
            'permission' => 'admin.create',
            'page' => 'Create Admin'
        ],
        [
            'permission' => 'admin.update',
            'page' => 'Update Admin'
        ],
        [
            'permission' => 'admin.delete',
            'page' => 'Delete Admin'
        ],
        [
            'permission' => 'role.view',
            'page' => 'View Role'
        ],
        [
            'permission' => 'role.create',
            'page' => 'Create Role'
        ],
        [
            'permission' => 'role.update',
            'page' => 'Update Role'
        ],
        [
            'permission' => 'role.delete',
            'page' => 'Delete Role'
        ],
        [
            'permission' => 'brand.view',
            'page' => 'View Brands'
        ],
        [
            'permission' => 'brand.create',
            'page' => 'Create Brand'
        ],
        [
            'permission' => 'brand.update',
            'page' => 'Update Brand'
        ],
        [
            'permission' => 'brand.delete',
            'page' => 'Delete Brand'
        ],
        [
            'permission' => 'category.view',
            'page' => 'View Categories'
        ],
        [
            'permission' => 'category.create',
            'page' => 'Create Category'
        ],
        [
            'permission' => 'category.update',
            'page' => 'Update Category'
        ],
        [
            'permission' => 'category.delete',
            'page' => 'Delete Category'
        ],
        [
            'permission' => 'product.view',
            'page' => 'View Products'
        ],
        [
            'permission' => 'product.create',
            'page' => 'Create Product'
        ],
        [
            'permission' => 'product.update',
            'page' => 'Update Product'
        ],
        [
            'permission' => 'product.delete',
            'page' => 'Delete Product'
        ],
        [
            'permission' => 'vendor.view',
            'page' => 'View Vendor'
        ],
        [
            'permission' => 'vendor.create',
            'page' => 'Create Vendor'
        ],
        [
            'permission' => 'vendor.update',
            'page' => 'Update Vendor'
        ],
        [
            'permission' => 'vendor.delete',
            'page' => 'Delete Vendor'
        ],
        [
            'permission' => 'order.view',
            'page' => 'View Orders'
        ],
        [
            'permission' => 'order.update',
            'page' => 'Update Order'
        ],
        [
            'permission' => 'customer.view',
            'page' => 'View Customers'
        ],
        [
            'permission' => 'customer.update',
            'page' => 'Update Customer'
        ],
        [
            'permission' => 'customer.delete',
            'page' => 'Delete Customer'
        ],
        [
            'permission' => 'review.view',
            'page' => 'View Reviews'
        ],
        [
            'permission' => 'review.update',
            'page' => 'Update Review'
        ],
    ];

    const ROUTE_LISTS = [
        'dashboard' => [
            'name' => 'Dashboard',
            'icon' => 'fas fa-home',
            'link' => 'admin.admin.dashboard',
            'permission' => ''
        ],
        'admins' => [
            'name' => 'Admins',
            'icon' => 'fas fa-users',
            'link' => 'admin.admin.index',
            'permission' => 'admin.view'
        ],
        'roles' => [
            'name' => 'Roles',
            'icon' => 'fas fa-user-cog',
            'link' => 'admin.roles.index',
            'permission' => 'role.view'
        ],
        'brands' => [
            'name' => 'Brands',
            'icon' => 'fas fa-building',
            'link' => 'admin.brands.index',
            'permission' => 'brand.view'
        ],
        'categories' => [
            'name' => 'Categories',
            'icon' => 'fas fa-tag',
            'link' => 'admin.categories.index',
            'permission' => 'category.view'
        ],
        'products' => [
            'name' => 'Products',
            'icon' => 'fas fa-box',
            'link' => 'admin.products.index',
            'permission' => 'product.view'
        ],
        'shippings' => [
            'name' => 'Vendors',
            'icon' => 'fas fa-shipping-fast',
            'link' => 'admin.shippings.index',
            'permission' => 'vendor.view'
        ],
        'orders' => [
            'name' => 'Orders',
            'icon' => 'fas fa-shopping-cart',
            'link' => 'admin.orders.index',
            'permission' => 'order.view'
        ],
        'users' => [
            'name' => 'Customers',
            'icon' => 'fas fa-user',
            'link' => 'admin.users.index',
            'permission' => 'customer.view'
        ],
        'reviews' => [
            'name' => 'Reviews',
            'icon' => 'fas fa-comments',
            'link' => 'admin.reviews.index',
            'permission' => 'review.view'
        ],
        'reports' => [
            'name' => 'Reports',
            'icon' => 'fas fa-chart-bar',
            'link' => 'admin.reports.index',
            'permission' => ''
        ],
    ];

    const REPORT_TYPES = [
        'sales ' => [
            'value' => 'sales',
            'name' => 'Sale report'
        ],
        'orders' => [
            'value' => 'orders',
            'name' => 'Order count report'
        ],
        'products' => [
            'value' => 'products',
            'name' => 'Top 10 most sale products report'
        ],
        'brands' => [
            'value' => 'brands',
            'name' => 'Top 5 most sale brands report'
        ],
    ];

    const ORDER_STATUS = [
        [
            'id' => 0,
            'name' => 'Pending'
        ],
        [
            'id' => 1,
            'name' => 'Prepare to delivery'
        ],
        [
            'id' => 2,
            'name' => 'Delivering',
        ],
        [
            'id' => 3,
            'name' => 'Delivery successfully',
        ],
        [
            'id' => 4,
            'name' => 'Canceled'
        ]
    ];

    const DATE_REPORT_ENUM = [
        'day' => 'daily',
        'week' => 'weekly',
        'month' => 'monthly',
        'year' => 'yearly'
    ];

    public static function getEnumDateReport(string $key)
    {
        return self::DATE_REPORT_ENUM[$key] ?? ucfirst($key);
    }
}
