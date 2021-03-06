<?php

namespace GetCandy\Api\Http\Transformers\Fractal\Users;

use Illuminate\Database\Eloquent\Model;
use GetCandy\Api\Http\Transformers\Fractal\BaseTransformer;
use GetCandy\Api\Http\Transformers\Fractal\Orders\OrderTransformer;
use GetCandy\Api\Http\Transformers\Fractal\Addresses\AddressTransformer;
use GetCandy\Api\Http\Transformers\Fractal\Languages\LanguageTransformer;
use GetCandy\Api\Http\Transformers\Fractal\Customers\CustomerGroupTransformer;

class UserTransformer extends BaseTransformer
{
    protected $availableIncludes = [
        'store', 'addresses', 'groups', 'roles', 'orders', 'language', 'details',
    ];

    public function transform(Model $user)
    {
        return [
            'id' => $user->encodedId(),
            'email' => $user->email,
        ];
    }

    public function includeLanguage(Model $user)
    {
        return $this->item($user->language, new LanguageTransformer);
    }

    public function includeAddresses(Model $user)
    {
        return $this->collection($user->addresses, new AddressTransformer);
    }

    public function includeGroups(Model $user)
    {
        return $this->collection($user->groups, new CustomerGroupTransformer);
    }

    public function includeRoles(Model $user)
    {
        return $this->collection($user->roles, new UserRoleTransformer);
    }

    public function includeOrders(Model $user)
    {
        return $this->collection($user->orders, new OrderTransformer);
    }

    public function includeDetails(Model $user)
    {
        if (! $user->details) {
            return $this->null();
        }

        return $this->item($user->details, new UserDetailsTransformer);
    }
}
