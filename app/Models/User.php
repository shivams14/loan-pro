<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /*   protected $fillable = [
        'name',
        'email',
        'password',
    ];
    */

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
        'password'          => 'hashed',
    ];

    /* Store allowed payment method array */
    public function allowedPaymentMethod()
    {
        return $this->belongsToMany(PaymentMethod::class, 'users', 'allowed_payment_method', 'id');
    }

    /**
     * Get the client type associated with the User.
     */
    public function clientType()
    {
        return $this->hasOne(ClientType::class, 'id', 'client_type_id');
    }

    /**
     * Get the state associated with the User.
     */
    public function state()
    {
        return $this->hasOne(State::class, 'id', 'state_id');
    }

    /**
     * Get the family members associated with the Client.
     */
    public function family()
    {
        return $this->hasmany(User::class, 'parent_id', 'id');
    }

    /**
     * Get the loans associated with the Client.
     */
    public function loans() {
        return $this->hasMany(Loan::class, 'client_id', 'id');
    }

    /**
     * Get the supports tickets of clients associated with the Client.
     */
    public function supportClient() {
        return $this->hasMany(Support::class, 'client_id', 'id');
    }

    /**
     * Get the supports tickets of created by associated with the Client.
     */
    public function supportCreatedBy() {
        return $this->hasMany(Support::class, 'created_by', 'id');
    }

    /**
     * Get the inventories associated with the Investor.
     */
    public function inventories() {
        return $this->hasMany(Inventory::class, 'investor_id', 'id');
    }

    /**
     * Get the late fee balance associated with the Loan.
     */
    public function lateFee() {
        return $this->hasMany(LateFeeBalance::class, 'client_id', 'id');
    }
}
