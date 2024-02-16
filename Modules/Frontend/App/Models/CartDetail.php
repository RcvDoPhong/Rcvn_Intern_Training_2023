<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\CartDetailFactory;

class CartDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["user_id", 'product_id', "quantity"];

    protected $table = "cart_detail";

    /**
     * Retrieves the associated product for this instance.
     *
     * @return BelongsTo The associated product.
     *
     * 12/01/2024
     * version:1
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Retrieve the associated User model.
     *
     * @return BelongsTo The associated User model.
     * 12/01/2024
     * version:1
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Check if a cart exists for a given user and product.
     *
     * @param int $userID The ID of the user.
     * @param int $productID The ID of the product.
     * @return bool Returns true if a cart exists, false otherwise.
     * 14/01/2024
     * version:1
     */
    public function checkExistCart(int $userID, int $productID): bool
    {
        return $this->where('user_id', $userID)->where('product_id', $productID)->exists();
    }

    /**
     * Retrieves a single product from the cart.
     *
     * @param int $userID The ID of the user.
     * @param int $productID The ID of the product.
     * @return CartDetail|null The CartDetail object representing the product in the cart, or null if not found.
     * 14/01/2024
     * version:1
     */
    public function getSingleProductInCart(int $userID, int $productID): ?CartDetail
    {

        return $this->where('user_id', $userID)->where('product_id', $productID)->first();
    }

    /**
     * Change the quantity of a product in the cart.
     *
     * @param array $options An associative array containing the following keys:
     *                       - 'user_id': The ID of the user.
     *                       - 'product_id': The ID of the product.
     *                       - 'quantity': The new quantity of the product.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return void
     * 14/01/2024
     * version:1
     */
    public function changeQuantity(array $options)
    {

        $this->where('product_id', $options['product_id'])
            ->where('user_id', $options['user_id'])
            ->update(['quantity' => $options['quantity']]);
    }

    /**
     * Retrieves the cart items from the database for a given user ID.
     *
     * @param int $userID The ID of the user.
     * @throws Some_Exception_Class Description of exception.
     * @return Collection The collection of cart items.
     * 12/01/2024
     * version:1
     */
    public function getCartFromDB(int $userID): Collection
    {

        return $this->with('product')->where('user_id', $userID)->get();
    }

    /**
     * Updates the data to the database.
     *
     * @param array $options An array of options to update the data.
     * @throws \Some_Exception_Class A description of the exception that can be thrown.
     * @return bool Returns true if the data is successfully updated, false otherwise.
     * 12/01/2024
     * version:1
     */
    public function updateToDB(array $options = [])
    {

        if ($this->checkExistCart($options['user_id'], $options['product_id'])) {
            $this->changeQuantity($options);
        } else {
            $this->create(
                ['product_id' => $options['product_id'], 'user_id' => $options['user_id']],
                ['quantity' => $options['quantity']]
            );

        }

    }

    /**
     * Deletes a record from the database based on the given options.
     *
     * @param array $options An array of options:
     *                      - user_id: The user ID.
     *                      - product_id: The product ID.
     * @throws \Some_Exception_Class If an error occurs during the deletion process.
     * @return void
     * 14/01/2024
     * version:1
     */
    public function deleteFromDB(array $options = [])
    {
        return $this->where('user_id', $options['user_id'])->where('product_id', $options['product_id'])->delete();
    }



    /**
     * Clears the cart entries from the database for the given user ID.
     *
     * @param int $userID The user ID for which the cart entries should be cleared.
     * @throws Some_Exception_Class Description of exception
     * @return
     * 17/01/2024
     * version:1
     */
    public function clearCartFromDB(int $userID): void
    {
        $this->where('user_id', $userID)->delete();
    }
}
