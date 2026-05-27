<?php

namespace DotMike\NmsWidgetAlertRules\Http\Controllers\Select;

use App\Models\AlertRule;
use App\Http\Controllers\Select\SelectController;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class AlertRulesController extends SelectController
{
    protected function searchFields(Request $request): array
    {
        return ['name'];
    }

    protected function baseQuery(Request $request): EloquentBuilder|Builder
    {
        return AlertRule::select('id', 'name');
    }

    public function formatItem(Model $alert_rule): array
    {
        return [
            'id' => $alert_rule->id,
            'text' => $alert_rule->name,
        ];
    }
}
