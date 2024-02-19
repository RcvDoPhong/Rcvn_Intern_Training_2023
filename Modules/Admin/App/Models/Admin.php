<?php

namespace Modules\Admin\App\Models;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Laravel\Scout\Searchable;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\database\factories\AdminFactory;
use ONGR\ElasticsearchDSL\Aggregation\Metric\MinAggregation;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Search;

class Admin extends Authenticatable
{
    use HasFactory;
    // use Searchable;

    /**
     * The attributes that are mass assignable.
     */

    protected $table = 'admins';

    protected $primaryKey = 'admin_id';

    protected $fillable = [
        'role_id',
        'name',
        'email',
        'nickname',
        'birthday',
        'password',
        'is_active',
        'is_delete',
        'gender',
        'updated_by'
    ];

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    protected static function newFactory(): AdminFactory
    {
        return AdminFactory::new();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', $this->primaryKey);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function hasPermission(string $permission)
    {
        $admin = auth()->guard('admin')->user();
        $permissionGet = Permission::getDetailByName($permission);

        if ($permissionGet) {
            foreach ($admin->role->permissions as $permission) {
                if ($permission->permission_id === $permissionGet->permission_id) {
                    return $permission->pivot->allow === 1;
                }
            }
        }

        return false;
    }

    public function isExistsByEmail(string $email, bool $excluded = false, int $adminId = 0): bool
    {
        $query = self::where('email', $email);

        if ($excluded) {
            $query = $query->where($this->primaryKey, '<>', $adminId);
        }

        return $query->exists();
    }

    public function isExistsById(int $id): bool
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public static function getList(): Collection
    {
        return self::where('is_delete', '<>', Constants::ADMIN_NON_ACTIVE)->get();
    }

    public function isIdentityPassword(int $id, string $password): bool
    {
        $userPassword = $this->getDetailById($id)->password;

        return Hash::check($password, $userPassword);
    }

    public function getPaginatedList(array $arrSearchData): LengthAwarePaginator
    {
        $query = self::where('is_delete', '<>', Constants::ADMIN_NON_ACTIVE);
        $arrSearchData = array_diff_key($arrSearchData, [
            'page' => 0,
            'query' => 0
        ]);
        if (!empty($arrSearchData)) {
            // $conditions = formatQuery(array_diff_key($arrSearchData, [
            //     'fromDate' => 0,
            //     'toDate' => 0
            // ]));

            // $query = $query->where($conditions);

            // $query = searchBetween($query, 'birthday', data_get($arrSearchData, 'fromDate'), data_get($arrSearchData, 'toDate'));

            $queryString = formatQueryString(array_diff_key($arrSearchData, [
                'fromDate' => 0,
                'toDate' => 0,
            ]));
            $queryString = empty($queryString) ? '*' : $queryString;

            $query = searchQueryString(
                $queryString,
                $this,
                [
                    'field' => 'birthday',
                    'from' => data_get($arrSearchData, 'fromDate'),
                    'to' => data_get($arrSearchData, 'toDate')
                ],
                Constants::ADMIN_ACTIVE
            );
        }

        return $query->orderBy('updated_at', 'DESC')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function getDetailByEmail(string $email)
    {
        if (self::isExistsByEmail($email)) {
            $admin = self::where('email', $email)->first();

            if ($admin->is_delete !== Constants::ADMIN_NON_ACTIVE) {
                return $admin;
            }
        }
        return null;
    }

    public function getDetailById(int $id)
    {
        if (self::isExistsById($id)) {
            $admin = self::where($this->primaryKey, $id)->first();

            if ($admin->is_delete !== Constants::ADMIN_NON_ACTIVE) {
                return $admin;
            }
        }
        return null;
    }

    public function isUserLockOrDelete(string $email): bool
    {
        $admin = self::getDetailByEmail($email);
        if ($admin) {
            return $admin->is_active === Constants::ADMIN_NON_ACTIVE || $admin->is_delete === Constants::ADMIN_NON_ACTIVE;
        }

        return false;
    }

    public function updateData(int $id, array $arrData): void
    {
        $admin = $this->getDetailById($id);

        if ($admin) {
            $admin->update($arrData);
        }
        // self::where($this->primaryKey, $id)->update($arrData);
    }

    // public function deleteAdmin(int $id): void
    // {
    //     $admin = $this->getDetailById($id);

    //     if ($admin) {
    //         $admin->delete();
    //     }
    // }
}
