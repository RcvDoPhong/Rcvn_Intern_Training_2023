<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\Database\factories\ReviewFactory;

class Review extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'product_id',
        'title',
        'rating',
        'comment',
        'updated_by'
    ];
    
    protected $primaryKey = 'review_id';
    
    protected static function newFactory(): ReviewFactory
    {
        return ReviewFactory::new();
    }

    public function images(): HasMany
    {
        return $this->hasMany(ReviewImages::class, $this->primaryKey);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function isExistsById(int $id)
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function getDetail(int $id)
    {
        return $this->isExistsById($id) ? self::where($this->primaryKey, $id)->first() : null;
    }

    public function getPaginatedList(array $arrSearchData)
    {
        $query = self::orderBy('created_at', 'desc');

        if (!empty($arrSearchData)) {
            $conditions = formatQuery($arrSearchData);

            $query = $query->where($conditions);
        }

        return $query->paginate(Constants::PER_PAGE)
                ->withQueryString();
    }

    public function updateReview(int $id, array $arrReviewUpdateData)
    {
        $exists = $this->isExistsById($id);

        if ($exists) {
            self::where($this->primaryKey, $id)->update($arrReviewUpdateData);

            return true;
        }

        return false;
    }
}
