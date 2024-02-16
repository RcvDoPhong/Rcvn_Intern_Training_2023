<?php

namespace Modules\Frontend\App\Repositories\User;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Frontend\App\Models\User;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Cart\CartRepositoryInterface;
use Modules\Frontend\App\Repositories\User\UserRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\CityRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\WardRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\DistrictRepositoryInterface;

/**
 * class UserRepository for registering and authenticating users.
 *
 * 4/1/2023
 * version:1
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    private $cartRepo;
    private $cityRepo;
    private $districtRepo;
    private $wardRepo;
    public function __construct(
        CartRepositoryInterface $cartRepo,
        CityRepositoryInterface $cityRepo,
        DistrictRepositoryInterface $districtRepo,
        WardRepositoryInterface $wardRepo
    ) {
        parent::__construct();
        $this->cartRepo = $cartRepo;
        $this->cityRepo = $cityRepo;
        $this->districtRepo = $districtRepo;
        $this->wardRepo = $wardRepo;
    }

    public function getModel()
    {
        return User::class;
    }

    /**
     * Registers a new user.
     *
     * @param array $data The data for the new user.
     * @return User|null The newly created user, or null if the registration failed.
     * 4/1/2023
     * version:1
     */
    public function register(array $data): ?User
    {
        return $this->model->createUser($data);
    }

    /**
     * Authenticate the user by performing a login.
     *
     * @param array $data The user's login data.
     * @param bool $boolHasRemember Whether to remember the user.
     * @return array|null The login result, including the status, message, and redirect URL.
     * 4/1/2023
     * version:1
     */
    public function login(array $data, bool $boolHasRemember = false): array
    {
        if (!$this->model->existsUser($data['email'])) {
            return [
                "status" => 404,
                "message" => "Đăng nhập thất bại",
            ];
        }

        if (!$this->model->isActiveUser($data['email'])) {
            return [
                "status" => 423,
                "message" => "Tài khoản khách hàng đã bị khóa",
            ];
        }

        if ($this->model->isDeleteUser($data['email'])) {
            return [
                "status" => 403,
                "message" => "Tài khoản đã bị xóa",
            ];
        }

        if (Auth()->attempt($data, $boolHasRemember)) {
            return [
                "status" => 200,
                'user' => Auth::user(),
                "message" => "Đăng nhập thành công",
                'redirect' => route('frontend.home.index'),
            ];
        } else {
            return [
                "status" => 401,
                "message" => "Đăng nhập thất bại",
            ];
        }
    }

    /**
     * Logout the user.
     *
     * @return array|null Returns an array with status, message, and redirect keys.
     * 4/1/2023
     * version:1
     */
    public function logout(): array
    {
        $userID = Auth::id();
        Auth::logout();
        $this->model->deleteRememberToken($userID);
        $this->cartRepo->clearCart();
        return [
            "status" => 200,
            "message" => "Đăng xuất thành công",
            'redirect' => route('frontend.auth.index')
        ];
    }

    /**
     * Retrieves a user by their ID.
     *
     * @param int $userID The ID of the user to retrieve.
     * @return User|null The user object, or null if no user is found.
     * 15/1/2024
     * version:1
     */
    public function getUser(int $userID): ?User
    {

        return $this->model->getUserByID($userID);
    }

    /**
     * Get user information detail.
     *
     * @return array
     * 7/2/2024
     * version:1
     */
    public function getUserInforDetail(): array
    {
        $user = $this->getUser(Auth::user()->user_id);

        $deliveryCityID = $user->delivery_city_id;
        $deliveryDistrictID = $user->delivery_district_id;

        $cities = $this->cityRepo->getCities();
        $districts = [];
        $wards = [];
        if ($deliveryCityID) {
            $districts = $this->districtRepo->getDistrictsByCity($deliveryCityID);
        } else {

            $districts = $this->districtRepo->getDistrictsByCity($cities[0]['city_id']);
        }
        if ($deliveryDistrictID) {
            $wards = $this->wardRepo->getWardsByDistrict($deliveryDistrictID);
        } else {

            $wards = $this->wardRepo->getWardsByDistrict($districts[0]['district_id']);
        }
        return  [
            'user' => $user,
            'cities' => $cities,
            'districts' => $districts,
            'wards' => $wards,
            'isEnableDistrict' => empty($districts) > 0,
            'isEnableWard' => count($wards) > 0,
        ];
    }

    /**
     * Update a user with the given options.
     *
     * @param array $options An array of options for updating the user.
     * @return User|null The updated user object if successful, null otherwise.
     */
    public function updateUser(int $userID, array $options = []): ?User
    {
        return $this->model->updateUser($userID, $options);
    }

    public function getInforAfterUpdate(Request $request): array
    {
        $newInfoUser = $this->updateUser(Auth::user()->user_id, $request->all());

        $deliveryCityID = $newInfoUser['delivery_city_id'];
        $deliveryDistrictID = $newInfoUser['delivery_district_id'];

        $cities = $this->cityRepo->getCities();


        $districts = [];
        $wards = [];

        if ($deliveryCityID) {
            $districts = $this->districtRepo->getDistrictsByCity($deliveryCityID);
        }
        if ($deliveryDistrictID) {
            $wards = $this->wardRepo->getWardsByDistrict($deliveryDistrictID);
        }

        return [
            'user' => $newInfoUser,
            'cities' => $cities,
            'districts' => $districts,
            'wards' => $wards,
            'isEnableDistrict' => count($districts) > 0,
            'isEnableWard' => count($wards) > 0,
        ];
    }

    /**
     * Determines if the billing address has been changed.
     *
     * @param int $value The value to check if the billing address has been changed.
     * @return bool Returns true if the billing address has been changed, false otherwise.
     */
    public function isChangeBillingAddress(Request $request): bool
    {
        $isBillingAddressValue =  $request->input('isChange', true) === "true" ? 1 : 0;
        return $this->model->isChangeBillingAddress(Auth::user()->user_id, $isBillingAddressValue);
    }

    public function changePassword(Request $request)
    {
        $currentPassword = $request->input('current_password', "");
        $newPassword = $request->input('new_password', "");
        $check = $this->model->changePassword($currentPassword, $newPassword);
        return $check === true ? "success" : "fail";
    }

    /**
     * Subscribe a user for push notifications.
     *
     * @param Request $request The request data
     */
    public function subscribeUser(Request $request)
    {
        $endpoint = $request->endpoint;
        $token = $request->keys['auth'];
        $key = $request->keys['p256dh'];
        $userID = Auth::user()->user_id;
        $getUser = $this->getUser($userID);
        if (isset($getUser)) {
            $getUser->updatePushSubscription($endpoint, $key, $token);
        }
    }
}
