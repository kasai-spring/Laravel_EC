<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

/**
 * App\Models\Inquiry
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $user_name
 * @property string|null $email
 * @property string $option
 * @property string $subject
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereOption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Inquiry whereUserName($value)
 * @mixin \Eloquent
 */
class Inquiry extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }

    /**
     * [Model]問い合わせ内容登録
     *
     * 問い合わせ内容をInquiryテーブルに追加する
     *
     * @param int|null $login_id
     * @param string|null $user_name
     * @param string|null $email
     * @param string $option
     * @param string $subject
     * @param string $content
     *
     * @throws QueryException
     */
    public function createInquiry(?int $login_id, ?string $user_name, ?string $email, string $option, string $subject, string $content)
    {
        static::create([
            "user_id" => "string",
            "user_name" => $user_name,
            "email" => $email,
            "option" => $option,
            "subject" => $subject,
            "content" => $content,
        ]);
    }

    public function getInquiryData(?int $pageNumber)
    {
       return static::latest("created_at")->paginate(12, ["*"], "inquiry_page", $pageNumber);
    }
}
