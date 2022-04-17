<?php

namespace Module\User\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Token extends Model
{
    use HasFactory;

    protected $guarded = [];

    const EXPIRATION_TIME = 10;

    public function __construct(array $attributes = [])
    {
        if (! isset($attributes['code'])){
            $attributes['code']  = $this->generateCode();
        }
        parent::__construct($attributes);
    }

    public function generateCode($length = 4)
    {
        $min = pow(10,$length);

        $max = $min * 10 - 1;
        $code = mt_rand($min,$max);

        return $code;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isValid()
    {
        return ! $this->isUsed() && ! $this->isExpired();
    }

    public function isUsed()
    {
        return $this->used;
    }

    public function isExpired()
    {
        return $this->created_at->diffInMinutes(Carbon::now())  > static::EXPIRATION_TIME;
    }

    public function send()
    {
        if (! $this->user()){
            throw new \Exception("no user");
        }
        if (! $this->code){
            $this->code = $this->generateCode();
        }

        try {
            echo "ok";
            /*Http::withHeaders([
                'apikey' => "api"
            ])->asForm()->post('https://api.ghasedak.me/v2/sms/send/simple',[
                'message' => $this->code,
                'receptor' => "123",
                'linenumber' =>"092123456"
            ]);*/
        } catch (\Exception $e){
            return false;
        }
        return true;
    }
}