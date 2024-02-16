<?php

namespace Modules\Frontend\App\Repositories\Cart;



use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Modules\Frontend\App\Models\CartDetail;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;

/**
 * class Brand Category class for retrieve brands.
 *
 * 08/01/2024
 * version:1
 */
class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    const RECENTLY_VIEWED_KEY = 'recently_viewed';
    const CART_KEY = 'cart';




    public function getModel()
    {
        return CartDetail::class;
    }


    /**
     * Retrieves the shopping cart.
     *
     * If the user is authenticated, the cart is retrieved from the database
     * using the user's ID. Otherwise, the cart is retrieved from the session.
     *
     * @return array The shopping cart.
     *   14/01/2024
     * version:2
     */
    public function getCart(): array
    {

        if (Auth::check()) {

            return $this->getCartFromDB(Auth::user()->user_id);
        } else {

            return array_values(array_filter((array) Session::get('cart', [])));
        }
    }

    /**
     * Retrieves the cart data for a given user from the database.
     *
     * @param int $userID The ID of the user.
     * @return array The cart data for the user.
     *   14/01/2024
     * version:2
     */
    public function getCartFromDB(int $userID): array
    {
        $cartDB = $this->model->getCartFromDB($userID);

        $transformCart = $cartDB->map(function ($item) {
            $product = $item['product'];
            $isSale = $product['isSale'];
            $displayPrice = $product['base_price'];
            if ($isSale) {
                $displayPrice = $product['sale_type'] === 0
                    ? (float) $product['sale_price']
                    : $product['base_price'] - $product['base_price'] * $product['sale_price_percent'];
            }

            $productLink = route('frontend.product.index', ['id' => $product['product_id']]);
            return [
                'product_id' => $product['product_id'],
                'product_name' => $product['product_name'],
                'display_price' => $displayPrice,
                'product_quantity' => (int) $item['quantity'],
                'product_thumbnail' => $product['product_thumbnail'],
                'product_link' => $productLink,
                'stock' => $product['stock'],
                'total_price' => (float) $displayPrice * (int) $item['quantity'],
                'option_name' => $product['option_name'] ?? 'No option'
            ];
        });
        Session::put('cart', $transformCart->toArray());

        return $transformCart->toArray();
    }

    /**
     * Adds a product to the cart.
     *
     * @param Request $request the HTTP request object
     * @param array $cart the current cart
     * @throws Some_Exception_Class if the quantity exceeds available stock
     * @return array the updated cart
     *   14/01/2024
     * version:2
     */
    public function addCart(Request $request, array $cart): array
    {
        $product = $request->input('product', []);
        list(
            "product_id" => $productID,
            "product_quantity" => $productQuantity,
            "display_price" => $productPrice,
            "product_name" => $productName,
            "product_thumbnail" => $productImage,
            "product_link" => $productLink,
            'stock' => $productStock,
            'option_name' => $productOption
        ) = $product;

        // Check if the quantity exceeds available stock
        if ((int) $productQuantity > (int) $productStock) {

            return ['error' => 'Quantity exceeds available stock.', "status" => 400];
        }

        $found = false;
        // Check if the product already exists in the cart, update quantity if so
        if (isset($cart) && !empty($cart)) {

            foreach ($cart as $key => $item) {

                if ($item["product_id"] == $productID) {

                    if ((int) $cart[$key]['product_quantity'] + (int) $productQuantity > (int) $cart[$key]['stock']) {

                        return ['error' => 'Quantity exceeds available stock.', "status" => 400];
                    }


                    $cart[$key]['product_quantity'] += $productQuantity; // add quantity

                    $cart[$key]['total_price'] = $cart[$key]['display_price'] * $cart[$key]['product_quantity'];


                    $found = true;
                    break;
                }
            }
        }

        // If the product is not found, add it to the cart
        if (!$found) {
            $cart[] = [
                'product_id' => $productID,
                'product_name' => $productName,
                'display_price' => $productPrice,
                'product_quantity' => (int) $productQuantity,
                'product_thumbnail' => $productImage,
                'product_link' => $productLink,
                'stock' => (int) $productStock,
                'total_price' => (float) $productPrice * (int) $productQuantity,
                'option_name' => $productOption ?? 'No option'
            ];
        }


        // Save the updated cart back to the session
        Session::put('cart', $cart);

        if (Auth::check()) {


            $this->updateDB([
                'userID' => Auth::user()->user_id,
                'cart' => $cart,
            ]);
        }

        return array_values($cart);
    }

    /**
     * Change the quantity of a product in the cart.
     *
     * @param array $options An associative array containing the following keys:
     *                      - "product_id": The ID of the product.
     *                      - "product_quantity": The quantity to be added or subtracted.
     *                      - "product_mode": The mode of operation, either "add" or "subtract".
     * @throws Some_Exception_Class Description of exception
     * @return array The updated cart as an array.
     *   14/01/2024
     * version:2
     */
    public function changeQuantity(Request $request, int $productID)
    {

        $cart = $this->getCart();

        $productQuantity = $request->productQuantity;
        $productMode = $request->productMode;

        $productQuantityInt = intval($productQuantity);

        if (isset($cart) && !empty($cart)) {

            foreach ($cart as $key => $item) {

                if ($item["product_id"] == $productID) {

                    if ($productMode == "add") {

                        $cart[$key]['product_quantity'] += $productQuantityInt; // add quantity
                    } else {
                        $cart[$key]['product_quantity'] -= $productQuantityInt; // subtract quantity
                    }
                    $cart[$key]['total_price'] = $cart[$key]['display_price'] * $cart[$key]['product_quantity'];

                    break;
                }
            }
        }

        // Save the updated cart back to the session
        Session::put('cart', $cart);

        if (Auth::check()) {
            $this->updateDB([
                'userID' => Auth::user()->user_id,
                'cart' => $cart,
            ]);
        }


        return array_values($cart);
    }

    /**
     * Checks if a product is in the cart.
     *
     * @param int $productID The ID of the product to check.
     * @return bool Returns true if the product is found in the cart, false otherwise.
     *   14/01/2024
     * version:2
     */
    public function isProductInCart($productID): bool
    {
        $cart = $this->getCart();

        if (isset($cart) && !empty($cart)) {
            foreach ($cart as $item) {
                if ($item["product_id"] == $productID) {
                    return true; // Product found in cart
                }
            }
        }

        return false; // Product not found in cart
    }

    /**
     * Calculates the total number of items in the shopping cart.
     *
     * @param array $cart An array representing the shopping cart.
     * @return int|null The total number of items in the shopping cart, or null if the cart is empty.
     *   14/01/2024
     * version:2
     */
    public function totalCart(array $cart): ?int
    {

        return count($cart);
    }

    /**
     * Calculates the sum of the total prices in the given cart.
     *
     * @param array $cart An array containing cart items.
     * @return int|null The sum of the total prices in the cart, or null if the cart is empty.
     *  *   14/01/2024
     * version:2
     */
    public function sumPriceCart(array $cart): ?int
    {

        return array_sum(array_column($cart, 'total_price'));
    }

    /**
     * Deletes a product from the cart.
     *
     * @param array $cart The cart containing the products.
     * @param int $productID The ID of the product to be deleted.
     * @return array|null The updated cart after deleting the product.
     *   14/01/2024
     * version:2
     */
    public function deleteCart(array $cart, int $productID): ?array
    {
        // Check if the product with the given ID exists in the cart
        $productID = (string) $productID;

        if (isset($cart) && !empty($cart)) {
            foreach ($cart as $key => $item) {

                if ($item["product_id"] == $productID) {

                    if (Auth::check()) {
                        $this->model->deleteFromDB([
                            'user_id' => Auth::user()->user_id,
                            'product_id' => $productID
                        ]);
                    }

                    unset($cart[$key]);

                    break;
                }
            }
        }



        Session::put('cart', $cart);
        return $cart;
    }

    /**
     * Updates the database with the provided options.
     *
     * @param array $options An array of options.
     *                      - userID: The ID of the user.
     *                      - cart: An array of cart items.
     * @throws Some_Exception_Class Description of exception
     * @return void
     *
     *   14/01/2024
     * version:1
     */
    public function updateDB(array $options = [])
    {
        list(
            "userID" => $userID,
            "cart" => $carts
        ) = $options;



        foreach ($carts as $cart) {
            $option = [
                "user_id" => $userID,
                'product_id' => (int) $cart['product_id'],
                'quantity' => (int) $cart['product_quantity']
            ];
            $this->model->updateToDB($option);
        }
    }

    /**
     * Updates the cart after a user logs in.
     *
     * @param int $userID The ID of the user.
     * @throws Some_Exception_Class A description of the exception.
     * @return
     * 14/01/2024
     * version:1
     */
    public function updateCartAfterLogin(int $userID)
    {

        $this->mergeSessionAndDBCart($userID);
    }
    /**
     * Merges the cart from session and database for a given user.
     *
     * @param int $userID The ID of the user.
     * @throws Some_Exception_Class If an error occurs during the merging process.
     * @return array The merged cart as an array.
     * 14/01/2024
     * version:1
     */
    public function mergeSessionAndDBCart(int $userID): array
    {
        // Get cart from session
        $sessionCart = array_values(array_filter((array) Session::get('cart', [])));

        // Get cart from database+
        $dbCart = $this->getCartFromDB($userID);

        // Merge session and database carts
        $mergedCart = $this->_mergeCarts($sessionCart, $dbCart);

        // Update session with merged cart
        Session::put('cart', $mergedCart);

        // Update database with merged cart
        $this->updateDB([
            "userID" => $userID,
            'cart' => $mergedCart,
        ]);

        return $mergedCart;
    }

    /**
     * Merges two shopping carts into a single cart.
     *
     * @param array $sessionCart The cart from the current session.
     * @param array $dbCart The cart from the database.
     * @return array The merged cart.
     * 17/01/2024
     * version:1
     */
    private function _mergeCarts(array $sessionCart, array $dbCart): array
    {
        $mergedCart = [];

        // Use product_id as a key for easy comparison
        $indexedSessionCart = $this->_indexCartByProductID($sessionCart);
        $indexedDBCart = $this->_indexCartByProductID($dbCart);

        // Merge carts based on product_id
        foreach ($indexedDBCart as $productID => $dbCartItem) {
            $sessionCartItem = $indexedSessionCart[$productID] ?? null;

            if ($sessionCartItem) {
                // Product exists in both session and DB carts, merge the quantities
                $dbCartItem['product_quantity'] += $sessionCartItem['product_quantity'];
            }

            $mergedCart[] = $dbCartItem;
        }

        // Add any remaining items from session cart that are not in the DB cart
        foreach ($indexedSessionCart as $productID => $sessionCartItem) {
            if (!isset($indexedDBCart[$productID])) {
                $mergedCart[] = $sessionCartItem;
            }
        }

        return $mergedCart;
    }

    /**
     * Indexes the given cart array by product ID.
     *
     * @param array $cart The cart array to be indexed.
     * @return array The indexed cart array.
     * 17/01/2024
     * version:1
     */

    private function _indexCartByProductID(array $cart): array
    {
        $indexedCart = [];

        foreach ($cart as $item) {
            $indexedCart[$item['product_id']] = $item;
        }

        return $indexedCart;
    }

    /**
     * Clears the cart.
     *
     * This function clears the cart in the session. If the user is logged in, it also clears the cart in the database.
     *
     * @throws Some_Exception_Class description of exception
     * @return void
     * 17/01/2024
     * version:1
     */
    public function clearCart(): void
    {
        Session::forget('cart');

        if (Auth::check()) {
            $userID = Auth::user()->user_id;
            $this->model->clearCartFromDB($userID);
        }
    }

    /**
     * Adds a product to the recently viewed list.
     *
     * @param int $productId The ID of the product to be added.
     * @throws Some_Exception_Class Description of exception (if applicable).
     * @return array
     * 18/01/2024
     * version:1
     */
    public function addRecentlyViewedProduct($productId): array
    {
        $recentlyViewed = Session::get(self::RECENTLY_VIEWED_KEY, []);

        $recentlyViewed = array_filter($recentlyViewed, function ($product) use ($productId) {
            return $product['id'] !== $productId;
        });

        array_unshift($recentlyViewed, ['id' => $productId, 'timestamp' => now()]);

        $recentlyViewed = array_slice($recentlyViewed, 0, 25);
        Session::put(self::RECENTLY_VIEWED_KEY, $recentlyViewed);
        return $recentlyViewed;
    }

    /**
     * Retrieves the recently viewed products.
     *
     * @return array The array of recently viewed products.
     * 18/01/2024
     * version:1
     */
    public function getRecentlyViewedProductsSession(): array
    {
        return Session::get(self::RECENTLY_VIEWED_KEY, []);
    }

    /**
     * Retrieve the number of items in the cart.
     *
     * @return int
     */
    public function getCartLength(): int
    {
        $cart = Session::get('cart');
        return count($cart);
    }
}
