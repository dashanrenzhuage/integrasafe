<?php
declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SocialLogins
 * @package App
 */
class SocialLogins extends Model
{
    // Multi Database
    protected $table = 'social_logins';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // Reference Users Class
        return $this->belongsTo('App\Users');
    }
}
