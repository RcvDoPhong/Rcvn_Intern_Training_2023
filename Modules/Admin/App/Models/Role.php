<?php

namespace Modules\Admin\App\Models;

use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Models\Permission;
use Modules\Admin\app\Observers\RoleObserver;
use Modules\Admin\database\factories\RoleFactory;
use ONGR\ElasticsearchDSL\Search;

class Role extends Model
{
    use HasFactory;
    use Searchable;

    protected $table = 'roles';

    protected $primaryKey = 'role_id';

    protected $fillable = [
        'role_name',
        'is_delete',
        'updated_by'
    ];

    public function searchableAs(): string
    {
        // return 'elasticsearch.indices.settings.' . $this->getTable();
        return $this->getTable();
    }

    public function modelObserver()
    {
        return new RoleObserver;
    }

    protected static function newFactory(): RoleFactory
    {
        return RoleFactory::new();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permission', 'role_id', 'permission_id')
            ->withPivot('allow');
    }

    public static function getList()
    {
        return self::where('is_delete', '<>', Constants::DESTROY)->get();
    }

    public static function isExistsRole(int $id)
    {
        return self::where('role_id', $id)->exists();
    }

    public static function getDetail(int $id)
    {
        if (self::isExistsRole($id)) {
            $role = self::where('role_id', $id)->first();

            if ($role !== Constants::DESTROY) {
                return $role;
            }
        }

        return null;
    }

    public function getPermissionList()
    {
        return Permission::getList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        $query = self::where('is_delete', '<>', Constants::DESTROY);

        $arrSearchData = array_diff_key($arrSearchData, [
            'page' => 0,
            'query' => 0
        ]);

        if (!empty($arrSearchData)) {
            // $conditions = formatQuery($arrSearchData);

            // $query = $query->where($conditions);

            $queryString = formatQueryString($arrSearchData);
            $queryString = empty($queryString) ? '*' : $queryString;

            $query = searchQueryString($queryString, $this, []);
            // $query = self::search($queryString, function (Client $client, Search $body) {
            //     $body->setSize(Constants::PER_PAGE);
            //     return $client->search([
            //         'index' => $this->searchableAs(),
            //         'body' => $body->toArray()
            //     ])->asArray();
            // })->where('is_delete', Constants::NOT_DESTROY);
        }
        return $query->orderBy('updated_at', 'desc')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function createNew(array $arrRoleData)
    {
        $role = self::create([
            'role_name' => $arrRoleData['role_name']
        ]);

        $role->permissions()->sync($arrRoleData['permissions']);

        return $role;
    }

    public function updateDataPermissions(int $roleId, array $arrRoleData = [], array $arrPermissionData = [])
    {
        $role = $this->getDetail($roleId);

        if ($role) {

            if ($arrRoleData) {
                $role->update($arrRoleData);
            }

            if ($arrPermissionData) {
                $role->permissions()->sync($arrPermissionData);
            }

            $role->update([
                'updated_by' => auth()->guard('admin')->user()->admin_id
            ]);

            return true;
        }

        return null;
    }

    public function changeRoleAdmin(int $roleId, int $newRoleId)
    {
        Admin::where('role_id', $roleId)->update([
            'role_id' => $newRoleId
        ]);
    }
}
