<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Rinvex\Subscriptions\Models\PlanFeature;

class PlanSubscriptionUsage extends \Rinvex\Subscriptions\Models\PlanSubscriptionUsage
{

	/**
	 * Scope subscription usage by feature slug.
	 *
	 * @param \Illuminate\Database\Eloquent\Builder $builder
	 * @param string                                $featureSlug
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeByFeatureSlug(Builder $builder, $featureSlug)
	{
		$feature = PlanFeature::where('slug', $featureSlug)->first();
		return $builder->where('feature_id', $feature->getKey() ?? null);
	}
}
