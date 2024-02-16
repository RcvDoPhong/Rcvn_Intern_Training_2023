<?php
namespace Modules\Frontend\App\Repositories\Order;

use Illuminate\Http\Request;
use Modules\Frontend\App\Models\Order;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\OrderHistory;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function addOrderAndDetail(Request $request, array $carts = []): Order|array;
    public function isExistOrderUUID(string $orderUUID): bool;

    public function getOrderHistory(): LengthAwarePaginator;

    public function getOrderHistoryById(int $orderHistoryDetailID): ?OrderHistory;

    public function cancelOrder(Request $request): void;

    public function getPaymentInformationDetail(Request $request): array;

    public function _generateOrderUID(): string;
}
