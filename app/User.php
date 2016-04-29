<?php

namespace App;

use App\Services\ReservationService;
use App\Traits\HasMedia;
use App\Traits\PermissionRoleAuthenticationTrait;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class User extends Authenticatable
{
    use ThrottlesLogins, HasMedia, PermissionRoleAuthenticationTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        $permissions = new Collection();
        foreach($this->roles as $role){
            $permissions = $permissions->merge($role->permissions);
        }
        return $permissions;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reserve(RoomType $roomType, int $occupancy, string $checkInDate, string $checkOutDate)
    {
        $reservation = new ReservationService();
        $reservation->make($this, $roomType, $occupancy, $checkInDate, $checkOutDate);

        $checkDate = $reservation->check_in;
        while($reservation->check_out->gt($checkDate)){
            $reservation->reservationNights()->create([
                'date' => $checkDate,
                'room_type_id' => $roomType->id
            ]);
            $checkDate->addDay();
        }
        return $reservation;
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'owner_id');
    }

    public function wishLists(){
        return $this->hasMany(WishList::class);
    }

    public function wishListItems()
    {
        return $this->hasManyThrough(WishListItem::class, WishList::class);
    }

    public function createWishList(array $wishListParam)
    {
        return $this->wishLists()->create($wishListParam);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }
    public function messageRooms()
    {
        return $this->belongsToMany(MessageRoom::class);
    }
}