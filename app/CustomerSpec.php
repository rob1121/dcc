<?php

namespace App;

use App\DCC\Traits\ModelInstance;
use App\DCC\Traits\Presenter\ExternalSpecPresenter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CustomerSpec extends Model {

    use ModelInstance, ExternalSpecPresenter;

    protected $fillable = [
        'spec_no', 'name', 'reviewer'
    ];

    protected $appends = [
        'spec_name', 'latest_revision', 'latest_revision_date', 'external_show', 'external_edit'
    ];

    public function customerSpecRevision() {
        return $this->hasMany(CustomerSpecRevision::class);
    }

    public function customerSpecCategory() {
        return $this->hasOne(CustomerSpecCategory::class);
    }

    public static function uniqueReviewer() {
        return self::get(["reviewer"])->unique("reviewer")->pluck("reviewer");
    }

    public static function forReview()
    {
        return CustomerSpecRevision::select("is_reviewed","revision","revision_date","customer_spec_id")
            ->whereIsReviewed(0)
            ->where("revision_date", "<", Carbon::now()->subDays(5))
            ->orderBy("revision_date")
            ->with("customerSpec")
            ->get()
            ->map(function($item) {
                return [
                    "id"        => $item->customer_spec_id,
                    "name"      => \Str::upper($item->customerSpec->spec_no . " " . $item->customerSpec->name),
                    "revision"  => \Str::upper($item->revision),
                    "date"      => Carbon::parse($item->revision_date)->diffForHumans(),
                    "route"     => "http://" . config("app.url") . "/external/{$item->customer_spec_id}/{$item->revision}"
                ];
            });
    }

    /**
     * check if request instance already exist in the database
     * @param $request
     * @return mixed
     */
    public static function isExist($request) {
        $spec = collect(new self($request->all()))->toArray();
        return self::where($spec)->first();
    }
}
