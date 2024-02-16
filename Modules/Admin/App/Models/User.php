<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Models\Order;
use Modules\Admin\database\factories\UserFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'users';

    protected $primaryKey = 'user_id';

    // public funciton isAdmin()
    // {
    //     return $this->
    // }

    protected $fillable = [
        'role_id',
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
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, $this->primaryKey);
    }

    public function getCities()
    {
        return City::getList();
    }

    public function getDistricts(?int $cityId)
    {
        return District::getDistricts($cityId);
    }

    public function getWards(?int $districtId)
    {
        return Ward::getWards($districtId);
    }

    public function isExistsById(int $id)
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function getList()
    {
        return self::where('is_delete', '<>', Constants::ADMIN_NON_ACTIVE)->get();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        $query = self::where('is_delete', '<>', Constants::ADMIN_NON_ACTIVE);

        if (!empty($arrSearchData)) {
            $conditions = formatQuery(array_diff_key($arrSearchData, [
                'fromDate' => 0,
                'toDate' => 0,
            ]));

            $query = $query->where($conditions);

            $query = searchBetween($query, 'birthday', data_get($arrSearchData, 'fromDate'), data_get($arrSearchData, 'toDate'));
        }

        return $query->orderBy('updated_at', 'desc')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function getPaginatedOrdersList(array $arrSearchData, int $userId)
    {
        $query = Order::orderBy('updated_at', 'DESC')->where($this->primaryKey, $userId);

        if (!empty($arrSearchData)) {
            $conditions = formatQuery(array_diff_key($arrSearchData, [
                'priceFrom' => 0,
                'priceTo' => 0,
                'status' => 0
            ]));

            $query = $query->where($conditions);

            $query = searchBetween($query, 'total_price', data_get($arrSearchData, 'priceFrom'), data_get($arrSearchData, 'priceTo'));
        }

        return $query->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function getDetail(int $id)
    {
        if ($this->isExistsById($id)) {
            $user = self::where($this->primaryKey, $id)->first();

            if ($user->is_delete !== Constants::ADMIN_NON_ACTIVE) {
                return $user;
            }
        }
        return null;
    }

    public function updateUser(int $id, array $arrUserData)
    {
        self::where($this->primaryKey, $id)->update($arrUserData);
    }
}
