<?php

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Elastic\Elasticsearch\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
// use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Models\Admin;
use ONGR\ElasticsearchDSL\Query\TermLevel\RangeQuery;
use ONGR\ElasticsearchDSL\Search;

if (!function_exists('flashMessage')) {
    function flashMessage(string $messageHeader, string $message, string $alertType)
    {
        session()->flash('alert-class', $alertType);
        session()->flash($messageHeader, $message);
    }
}

if (!function_exists('formatQuery')) {
    function formatQuery(array $arrData)
    {
        $conditions = [];
        $arrData = array_diff_key($arrData, ['page' => 0]);
        foreach ($arrData as $field => $value) {
            if (!is_null($value)) {
                if (is_array($value)) {
                    $conditions[] = [$field, 'IN', $value];
                } else {
                    if (is_numeric($value)) {
                        $conditions[] = [$field, $value];
                    } else {
                        $conditions[] = [$field, 'LIKE', "%$value%"];
                    }
                }
            }
        }

        return $conditions;
    }
}

if (!function_exists('searchBetween')) {
    function searchBetween(Builder $query, string $key, ?string $fromInput, ?string $toInput)
    {
        if ($fromInput && $toInput) {
            $query = $query->whereBetween($key, [$fromInput, $toInput]);
        } elseif ($fromInput) {
            $query = $query->where($key, '>', $fromInput);
        } elseif ($toInput) {
            $query = $query->where($key, '<', $toInput);
        }

        return $query;
    }
}

if (!function_exists('handleReportDashboard')) {
    function handleReportDashboard(string $table, string $aggregatedFn = 'count', string $field = '*', string $alias = '')
    {
        $result = DB::table($table)
            ->selectRaw("$aggregatedFn($field) as name")
            ->whereRaw('date(created_at) = ?', date("Y-m-d"))
            ->get();

        return $result[0];
    }
}

if (!function_exists('formatDashboardField')) {
    function formatDashboardField(array $fields)
    {
        $arrFields = [];
        foreach ($fields as $table => $fields) {
            $arrFields[$table] = handleReportDashboard(
                $fields['table'],
                $fields['func'],
                $fields['field'],
                data_get($fields, 'alias') ?? $table
            );
        }

        return $arrFields;
    }
}

if (!function_exists('getDateRange')) {
    function getDateRange(string $startDate, string $endDate, string $betweenDate = '1 day')
    {
        return collect(new CarbonPeriod($startDate, $betweenDate, $endDate))->map(function (Carbon $date) {
            return $date->format('Y-m-d');
        });
    }
}

if (!function_exists('defineChartLabelRange')) {
    function defineChartLabelRange(array $arrTime)
    {
        $labels = null;
        switch ($arrTime['timeType']) {
            case 'month':
                $labels = getAllDaysRange($arrTime['time'], 'month');
                break;
            case 'date':
                $labels = getDateRange(
                    $arrTime['time']['fromDate'],
                    $arrTime['time']['toDate']
                );
                break;
            case 'year':
                $labels = getAllDaysRange($arrTime['time'], 'year');
                break;
            default:
                $labels = getAllDaysRange($arrTime['time'], 'week');
                break;
        }

        return $labels;
    }
}

if (!function_exists('formatQueryReport')) {
    function formatQueryReport(
        Builder|QueryBuilder $query,
        array $arrTime,
        string $targetTable,
        bool $addSelect = true,
        bool $groupBy = true,
        bool $orderBy = true,
        string $customField = ''
    ) {
        $createdAt = $targetTable . '.created_at';

        switch ($arrTime['timeType']) {
            case 'week':
                $dates = getAllDaysRange($arrTime['time'], 'week');
                $query = $query->whereRaw("date($createdAt) between ? and ?", [$dates[0], $dates[6]]);
                break;

            case 'month':
                $endOfMonth = getAllDaysRange($arrTime['time'], 'month');
                $length = count($endOfMonth);
                $query = $query->whereRaw("date($createdAt) between ? and ?", [
                    $endOfMonth[0],
                    $endOfMonth[$length - 1]
                ]);
                break;

            case 'date':
                $query = $query->whereRaw("date($createdAt) between ? and ?", [
                    $arrTime['time']['fromDate'],
                    $arrTime['time']['toDate']
                ]);
                break;

            default:
                $query = $query->whereRaw("date($createdAt) between ? and ?", [
                    $arrTime['time'] . '-01-01',
                    $arrTime['time'] . '-12-31',
                ]);
                break;
        }

        $alias = 'dates';
        if ($addSelect) {
            $key = "date($createdAt)";
            $query = $query->addSelect(DB::raw("$key as $alias"));
        }

        $labels = defineChartLabelRange([
            'timeType' => $arrTime['timeType'],
            'time' => $arrTime['time']
        ]);

        if ($groupBy) {
            $groupByField = $customField ? $customField : $alias;
            $query = $query->groupBy($groupByField);
        }

        if ($orderBy) {
            $query = $query->orderBy($alias, 'ASC');
        }

        return [
            // 'key' => $alias,
            'labels' => $labels,
            'query' => $query
        ];
    }
}

if (!function_exists('formatPermissionName')) {
    function formatPermissionName(string $permissionName)
    {
        $permissionLists = Constants::PERMISSION_LISTS;
        foreach ($permissionLists as $key => $permission) {
            if (in_array($permissionName, $permission)) {
                return [
                    'id' => $key,
                    'name' => ucfirst($permission['page'])
                ];
            }
        }

        return [
            'id' => null,
            'name' => $permissionName
        ];
    }
}

if (!function_exists('adminList')) {
    function adminList()
    {
        return Admin::getList();
    }
}

if (!function_exists('getAllDaysRange')) {
    function getAllDaysRange(string $date, string $timeType)
    {
        $now = CarbonImmutable::parse($date);
        $betweenDays = '1 days';

        switch ($timeType) {
            case 'week':
                $start = $now->startOfWeek();
                $end = $now->endOfWeek();
                break;
            case 'month':
                $start = $now->startOfMonth();
                $end = $now->endOfMonth();
                break;

            default:
                $start = $now->startOfYear();
                $end = $now->endOfYear();
                break;
        }
        return getDateRange($start, $end, $betweenDays);
    }
}

if (!function_exists('checkRoleHasPermission')) {
    function checkRoleHasPermission(string $permission)
    {
        return Admin::hasPermission($permission);
    }
}

if (!function_exists('formatDate')) {
    function formatDate(string $date)
    {
        $time = explode('-', $date);
        return [
            'year' => $time[0],
            'month' => $time[1]
        ];
    }
}

if (!function_exists('formatBetweenQuery')) {
    function formatBetweenQuery(?string $field, ?string $fromValue, ?string $toValue)
    {
        if ($field) {
            if ($fromValue && $toValue) {
                return new RangeQuery($field, [
                    RangeQuery::GTE => $fromValue,
                    RangeQuery::LTE => $toValue
                ]);
            } elseif ($fromValue) {
                return new RangeQuery($field, [
                    RangeQuery::GTE => $fromValue
                ]);
            } elseif ($toValue) {
                return new RangeQuery($field, [
                    RangeQuery::LTE => $toValue
                ]);
            }
        }
    }
}

if (!function_exists('formatQueryString')) {
    function formatQueryString(array $arrQueryData)
    {
        $qString = [];
        foreach ($arrQueryData as $key => $item) {
            if ($item) {
                $qString[] = "($key:$item)";
            }
        }

        return implode(" AND ", $qString);
    }
}

if (!function_exists('searchQueryString')) {
    function searchQueryString(
        string $queryString,
        Model $model,
        array $betweenDate = [],
        int $isDelete = Constants::NOT_DESTROY
    ) {
        return $model::search($queryString, function (Client $client, Search $body) use ($betweenDate, $model) {
            $body->setSize(Constants::PER_PAGE);

            $betweenDate = formatBetweenQuery(
                data_get($betweenDate, 'field'),
                data_get($betweenDate, 'from'),
                data_get($betweenDate, 'to')
            );

            if ($betweenDate) {
                $body->addQuery($betweenDate);
            }

            return $client->search([
                'index' => $model->searchableAs(),
                'body' => $body->toArray()
            ])->asArray();
        })->where('is_delete', $isDelete);
    }
}

if (!function_exists('searchProductSQL')) {
    function searchProductSQL(Builder $query, string $productName)
    {
        if ($productName) {
            $query = $query->where('product_name', 'LIKE', "%$productName%")
                ->where('is_delete', Constants::NOT_DESTROY);
        }

        return $query->orderBy('product_name', 'asc');
    }
}
