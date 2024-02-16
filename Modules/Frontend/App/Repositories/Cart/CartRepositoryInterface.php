<?php

namespace Modules\Frontend\App\Repositories\Cart;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface CartRepositoryInterface extends RepositoryInterface
{

    public function getCart(): array;
    public function getCartFromDB(int $userID): array;

    public function addCart(Request $request, array $cart): array;

    public function sumPriceCart(array $cart): ?int;
    public function totalCart(array $cart): ?int;
    public function changeQuantity(Request $request, int $productID);
    public function isProductInCart($productID): bool;

    public function updateDB(array $options = []);

    public function updateCartAfterLogin(int $userID);

    public function deleteCart(array $cart, int $productID): ?array;

    public function clearCart(): void;

    public function addRecentlyViewedProduct($productId): array;
    public function getRecentlyViewedProductsSession(): array;
    public function getCartLength(): int;
}
