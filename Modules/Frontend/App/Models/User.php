<?php

namespace Modules\Frontend\App\Models;

use Laravel\Sanctum\HasApiTokens;
use Modules\Admin\App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasPushSubscriptions;

    private const ACTIVE = 1;
    private const NON_ACTIVE = 0;
    protected $table = 'users';

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'delivery_city_id',
        'delivery_district_id',
        'delivery_ward_id',
        'billing_city_id',
        'billing_district_id',
        'billing_ward_id',
        'name',
        'email',
        'nickname',
        'is_subscription',
        'birthday',
        'password',
        'gender',
        'delivery_fullname',
        'delivery_address',
        'delivery_zipcode',
        'delivery_phone_number',
        'billing_fullname',
        'billing_address',
        'billing_zipcode',
        'billing_phone_number',
        'billing_tax_id_number',
        'is_active',
        'is_delete',
        'updated_by',
        'email_verified_at',
        'is_billing_address'
    ];

    protected $hidden = [
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Retrieves the delivery city associated with this object.
     *
     * @return City The delivery city associated with this object.
     * 15/01/2024
     * version:1
     */
    public function deliveryCity()
    {
        return $this->belongsTo(City::class, 'delivery_city_id', 'city_id');
    }

    /**
     * Retrieves the related district for the delivery district.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *      * 15/01/2024
     * version:1
     */
    public function deliveryDistrict()
    {
        return $this->belongsTo(District::class, 'delivery_district_id', 'district_id');
    }


    /**
     * Retrieves the delivery ward associated with the current model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function deliveryWard()
    {
        return $this->belongsTo(Ward::class, 'delivery_ward_id', 'ward_id');
    }

    /**
     * A description of the billingCity function.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *      15/01/2024
     * version:1
     */
    public function billingCity()
    {
        return $this->belongsTo(City::class, 'billing_city_id', 'city_id');
    }

    /**
     * A description of the entire PHP function.
     *
     * @return BelongsTo
     *      15/01/2024
     * version:1
     */
    public function billingDistrict()
    {
        return $this->belongsTo(District::class, 'billing_district_id', 'district_id');
    }

    /**
     * A description of the entire PHP function.
     *
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     *      15/01/2024
     * version:1
     */

    public function billingWard()
    {
        return $this->belongsTo(Ward::class, 'billing_ward_id', 'ward_id');
    }

    /**
     * Retrieves the Admin model instance that represents the user who last updated the record.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * The relationship between the record and the Admin model.
     *      15/01/2024
     * version:1
     */
    public function updatedBy()
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'admin_id');
    }


    /**
     * Creates a new user.
     *
     * @param array $data The data used to create the user.
     * @throws Some_Exception_Class If there is an exception while creating the user.
     * @return User|null The newly created user, or null if there was an error.
     * version:1
     * 3/1/2024
     */
    public function createUser(array $data): ?User
    {
        $hashPassword = Hash::make($data['password']);
        return self::create([
            'email' => $data['email'],
            'password' => $hashPassword,
            'name' => $data['name'],
            'nickname' => '',
            'birthday' => now(),
            'gender' => 1,
            'delivery_fullname' => '',
            'delivery_address' => '',
            'delivery_zipcode' => '',
            'delivery_phone_number' => '',
            'billing_fullname' => '',
            'billing_address' => '',
            'billing_zipcode' => '',
            'billing_phone_number' => '',
            'billing_tax_id_number' => '',
            'is_active' => 1,
        ]);
    }

    /**
     * Check if a user with the given email exists.
     *
     * @param string $email The email to check.
     * @return bool True if a user with the given email exists, false otherwise.
     * version:1
     * 4/1/2024
     */
    public function existsUser(string $email): bool
    {

        return self::where('email', $email)->exists();
    }

    /**
     * Check if the user with the given email is active.
     *
     * @param string $email The email of the user.
     * @return bool Returns true if the user is active, false otherwise.
     * version:1
     * 4/1/2024
     */
    public function isActiveUser(string $email): bool
    {
        $user = self::where('email', $email)->first();
        return $user->is_active === self::ACTIVE;
    }

    /**
     * Checks if a user with the given email is marked for deletion.
     *
     * @param string $email The email of the user to check.
     * @return bool True if a user with the given email is marked for deletion, false otherwise.
     * version:1
     * 4/1/2024
     */
    public function isDeleteUser(string $email): bool
    {
        $user = self::where('email', $email)->first();
        return $user->is_delete === self::NON_ACTIVE;
    }

    /**
     * Retrieve a user by email.
     *
     * @param string $email The email of the user.
     * @throws Some_Exception_Class Description of exception
     * @return User The user object.
     * version:1
     * 4/1/2024
     */
    public function getUser(string $email): User|bool
    {
        if (self::existsUser($email)) {
            return self::where('email', $email)->first();
        }

        return false;
    }
    /**
     * Retrieves a User by their ID.
     *
     * @param int $userID The ID of the User to retrieve.
     * @return User|null The retrieved User or null if not found.
     * 15/01/2024
     * version:1
     */
    public function getUserByID(int $userID): ?User
    {

        $user = $this->where('user_id', $userID)->with([
            'deliveryCity', 'deliveryDistrict', 'deliveryWard',
            'billingCity', 'billingDistrict', 'billingWard'
        ])->first();
        if ($user) {
            return $user;
        }

        return null;
    }

    /**
     * Delete the remember token for a user.
     *
     * @param int $userId The ID of the user.
     * @return void
     * version:1
     * 4/1/2024
     */
    public function deleteRememberToken($userId)
    {
        $user = self::find($userId);
        if ($user) {
            $user->forceFill([
                'remember_token' => null,
            ])->save();
        }
    }

    /**
     * Updates a user in the database.
     *
     * @param int $userID The ID of the user to update.
     * @param array $options An array of options for the update.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return User|null The updated User object, or null if the user was not found.
     * version:1
     * 15/1/2024
     */
    public function updateUser(int $userID, array $options = []): ?User
    {
        if (isset($options['is_subscription'])) {
            $options['is_subscription'] = $options['is_subscription'] === "on" ? 1 : 0;
        } else {
            $options['is_subscription'] = 0;
        }



        if (isset($options['is_billing_address'])) {
            $options['is_billing_address'] = $options['is_billing_address'] === "on" ? 1 : 0;
        } else {
            $options['is_billing_address'] = 0;
        }

        // Update the user
        $this->where('user_id', $userID)->update($options);

        // Fetch the updated user


        return User::find($userID);
    }

    /**
     * Change the user's password.
     *
     * @param array $option an array containing the user's current password and the new password
     * @throws Some_Exception_Class if the current password doesn't match
     * @return bool true if the password was successfully changed, false otherwise
     */
    public function changePassword(string $currentPassword, string $newPassword)
    {
        // Retrieve the current user
        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($currentPassword, $user->password)) {
            return false; // Current password doesn't match
        }

        // Hash the new password
        $hashedNewPassword = Hash::make($newPassword);

        // Update the user's password in the database
        $this->where("user_id", $user->user_id)->update(['password' => $hashedNewPassword]);

        return true;
    }

    /**
     * Updates the billing address status for a user.
     *
     * @param int $userID The ID of the user.
     * @param int $value The new value for the billing address status.
     * @throws Some_Exception_Class Description of the exception (if any).
     * @return bool Returns true if the update was successful, false otherwise.
     */
    public function isChangeBillingAddress(int $userID, int $value): bool
    {

        return $this->where('user_id', $userID)->update([
            "is_billing_address" => $value
        ]);
    }
}
